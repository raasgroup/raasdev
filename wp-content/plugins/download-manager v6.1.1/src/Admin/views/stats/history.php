<?php
global $wpdb;
if ( ! defined( "ABSPATH" ) ) {
	die( "Shit happens!" );
}
$get_params = $_GET;

// Tables used
$states_table = "{$wpdb->prefix}ahm_download_stats";
$posts_table  = "{$wpdb->prefix}posts";
$users_table  = "{$wpdb->base_prefix}users";

/**
 * Query Parameters
 */
$from_date_string = wpdm_query_var( 'from_date' );
$to_date_string   = wpdm_query_var( 'to_date' );
$user_ids         = wpdm_query_var( 'user_ids' ) ?: [];
$package_ids      = wpdm_query_var( 'package_ids' ) ?: [];
$page_no          = wpdm_query_var( 'page_no', 'int' ) ?: 1;

/**
 * Sanitize parameters
 */
$from_date_string = sanitize_text_field( $from_date_string );
$to_date_string   = sanitize_text_field( $to_date_string );
$user_ids         = \WPDM\__\__::sanitize_array( $user_ids, 'int' );
$package_ids      = \WPDM\__\__::sanitize_array( $package_ids, 'int' );

/**
 * Selected/Initial Values for the fields
 * These are necessary for initialize filter fields
 */

$min_timestamp      = $wpdb->get_var( "SELECT min(timestamp) from $states_table" ) ?: time();
$selected_from_date = $from_date_string ? new DateTime( $from_date_string ) : ( new DateTime() )->setTimestamp( $min_timestamp );

$selected_to_date = $to_date_string ? ( new DateTime( $to_date_string ) ) : ( new DateTime() )->setTimestamp( time() );
$selected_to_date->modify( 'tomorrow' ); // we need to get the timestamp of the end of selected to_date
$end_of_selected_to_date_timestamp = $selected_to_date->getTimestamp() - 1;
$selected_to_date->setTimestamp( $end_of_selected_to_date_timestamp );


$user_ids_string = implode( ',', $user_ids );
$selected_users  = [];
if ( ! empty( $user_ids_string ) ) {
	$selected_users = $wpdb->get_results( "SELECT ID, user_login, display_name, user_email FROM $users_table  WHERE ID IN ({$user_ids_string})" );
}

$package_ids_string = implode( ',', $package_ids );
$selected_packages  = [];
if ( ! empty( $package_ids_string ) ) {
	$selected_packages = $wpdb->get_results( "SELECT ID, post_title  FROM $posts_table  WHERE ID IN ({$package_ids_string})" );
}


/**
 * Filter query parts
 */

$timestamp_filter = " AND s.timestamp >= {$selected_from_date->getTimestamp()}  AND s.timestamp <= {$selected_to_date->getTimestamp()}";

$user_ids_filter = "";
if ( count( $user_ids ) > 0 ) {
	$user_ids_filter = " AND s.uid IN (" . $user_ids_string . ") ";
}

$package_ids_filter = "";
if ( count( $package_ids ) > 0 ) {
	$package_ids_filter = " AND s.pid IN (" . $package_ids_string . ") ";
}

$uniqq = "";
if ( wpdm_query_var( 'uniq' ) ) {
	$uniqq = " group by pid ";
}


/**
 * Statistics query
 */

$items_per_page = 30;
$start          = $page_no ? ( $page_no - 1 ) * $items_per_page : 0;

//pd($selected_from_date->getTimestamp());

$cats_filter = get_posts( [
	'post_type'   => 'wpdmpro',
	'post_status'   => 'publish',
	'numberposts' => - 1,
	'tax_query'   => [
		[
			'taxonomy'         => 'wpdmcategory',
			'field'            => 'term_id',
			'terms'            => wpdm_query_var('cats'),
			'include_children' => false
		]
	]
] );
$pack_ids = [];
foreach ($cats_filter as $pac) {
	$pack_ids[] = $pac->ID;
}
$pid_query = '';
if(is_array($pack_ids) && count($pack_ids) > 0)
	$pid_query = ' and s.pid in ('.implode(',', $pack_ids).')';

$hash = \WPDM\__\Crypt::encrypt( "SELECT [##fields##] FROM $states_table s WHERE 1 {$package_ids_filter} {$user_ids_filter} {$timestamp_filter} {$pid_query} {$uniqq}" );

$count_downloads_without_paging = $wpdb->get_var( "SELECT count(s.pid) FROM $states_table s, $posts_table p WHERE s.pid = p.ID  
                                        {$package_ids_filter} {$user_ids_filter} {$timestamp_filter} {$pid_query}
                                        " );

$filtered_result_rows = $wpdb->get_results( "SELECT p.post_title, s.* FROM $states_table s, $posts_table p WHERE s.pid = p.ID 
                                    {$package_ids_filter} {$user_ids_filter} {$timestamp_filter} {$pid_query} {$uniqq}  
                                    order by `timestamp` desc limit $start, $items_per_page
                                    " );
/*wpdmdd("SELECT p.post_title, s.* FROM $states_table s, $posts_table p WHERE s.pid = p.ID
                                    {$package_ids_filter} {$user_ids_filter} {$timestamp_filter} {$pid_query} {$uniqq}
                                    order by `timestamp` desc limit $start, $items_per_page
                                    ");*/
$pagination           = array(
	'base'      => @add_query_arg( 'page_no', '%#%' ),
	'format'    => '',
	'total'     => ceil( $count_downloads_without_paging / $items_per_page ),
	'current'   => $page_no,
	'show_all'  => false,
	'type'      => 'list',
	'prev_next' => true,
	'prev_text' => '<i class="icon icon-angle-left"></i> Previous',
	'next_text' => 'Next <i class="icon icon-angle-right"></i>',
);

?>

<!-- Filters -->
<div class="row">
	<form method="get" action="<?php echo admin_url( 'edit.php' ); ?>">
		<!-- hidden fields. Necessary for navigating this page -->
		<input type="hidden" name="post_type" value="wpdmpro"/>
		<input type="hidden" name="page" value="wpdm-stats"/>
		<input type="hidden" name="type" value="history"/>
		<input type="hidden" name="filter" value="1"/>

		<section class="row" style="margin-top: 20px">
			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-heading"><?php _e( "Users", "download-manager" ); ?></div>
					<div class="panel-body">
						<select id="user_ids" name="user_ids[]" multiple="multiple" style="width: 100%; height: 100%"
						        class="form-control">
							<?php foreach ( $selected_users as $u ) : ?>
								<option selected
								        value="<?php echo $u->ID ?>"> <?php echo $u->display_name . "($u->user_login)" ?> </option>
							<?php endforeach ?>
						</select>

						<!-- remove user filter -->
						<?php if ( count( $user_ids ) ) {
							$get_params_xu = $get_params;
							unset( $get_params_xu['user_ids'] );

							$reset_url = add_query_arg( $get_params_xu, 'edit.php' );
							?>
							<div class="input-group-btn">
								<a href="<?php echo $reset_url; ?>" class="btn btn-secondary"><i
										class="fa fa-times-circle"></i></a>
							</div>
						<?php } ?>
					</div>
				</div>

			</div>
			<?php
			$cats = wpdm_query_var( 'cats' );
			$cats = is_array($cats) ? $cats : [];
            function printOptions($options, $level = 0) {
                $pstr = $level > 0 ? str_pad(" ", $level*2+1, "--",  STR_PAD_LEFT) : '';
                wpdmprecho([$level, $pstr]);
                foreach ($options as $option) {
                    echo "<option value='{$option['category']->term_id}'>{$pstr}{$option['category']->name}</option>";
                    if(count($option['childs']) > 0) {
	                    printOptions($option['childs'], $level + 1);
                    }
                }
            }
			?>
			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-heading"><?php _e( "Categories", "download-manager" ); ?></div>
					<div class="panel-body">
						<select id="cats" name="cats[]" multiple="multiple" style="width: 100%; height: 100%"
						        class="form-control">
							<?php
                            $cats = WPDM()->categories->hArray();
							printOptions($cats);
                            /* foreach ( get_terms( [ 'taxonomy' => 'wpdmcategory' ] ) as $cat ) : ?>
								<option <?php selected( in_array( $cat->term_id, $cats ), true ); ?> value="<?php echo $cat->term_id ?>"> <?php echo $cat->name . " ( $cat->count )" ?> </option>
							<?php endforeach */ ?>
						</select>

						<!-- remove user filter -->
						<?php if ( count( $user_ids ) ) {
							$get_params_xu = $get_params;
							unset( $get_params_xu['user_ids'] );

							$reset_url = add_query_arg( $get_params_xu, 'edit.php' );
							?>
							<div class="input-group-btn">
								<a href="<?php echo $reset_url; ?>" class="btn btn-secondary"><i
										class="fa fa-times-circle"></i></a>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>

			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-heading"><?php _e( "Packages", "download-manager" ); ?></div>
					<div class="panel-body">
						<select id="package_ids" name="package_ids[]" multiple="multiple"
						        style="width: 100%; height: 100%">
							<?php foreach ( $selected_packages as $p ) : ?>
								<option selected value="<?php echo $p->ID ?>"> <?php echo $p->post_title ?> </option>
							<?php endforeach ?>
						</select>
						<!-- remove package filter -->
						<?php if ( count( $package_ids ) ) {
							$get_params_xp = $get_params;
							unset( $get_params_xp['package_ids'] );

							$reset_url = add_query_arg( $get_params_xp, 'edit.php' );
							?>
							<div class="input-group-btn">
								<a href="<?php echo $reset_url; ?>" class="btn btn-secondary"><i
										class="fa fa-times-circle"></i></a>
							</div>
						<?php } ?>
					</div>
				</div>

			</div>


			<!-- Filter submit button -->

		</section>

        <section class="row">
            <!-- From date filter -->
            <div class="col-md-4">
                <div class="input-group input-group-lg">
                    <div class="input-group-addon">
                        <span class="input-group-text"><?php _e( "From Date", "download-manager" ); ?>:</span>
                    </div>
                    <input type="text" name="from_date" value="<?php echo $selected_from_date->format( 'Y-m-d' ) ?>"
                           class="datepicker form-control bg-white text-right" readonly="readonly"/>
                </div>
            </div>

            <!-- To date filter -->
            <div class="col-md-3">
                <div class="input-group input-group-lg">
                    <div class="input-group-addon">
                        <span class="input-group-text"><?php _e( "To Date", "download-manager" ); ?>:</span>
                    </div>
                    <input type="text" name="to_date" value="<?php echo $selected_to_date->format( 'Y-m-d' ) ?>"
                           class="datepicker form-control bg-white text-right" readonly="readonly"/>
                </div>
            </div>

            <div class="col-md-5">
                <div style="float:right">
                    <button type="submit"
                            class="btn btn-primary btn-lg"><?php echo __( "Filter", "download-manager" ) ?></button>
                    <a href="edit.php?post_type=wpdmpro&page=wpdm-stats&task=export&__xnonce=<?php echo wp_create_nonce( NONCE_KEY ); ?>&hash=<?php echo $hash; ?>"
                       class="btn btn-info btn-lg"><?php echo __( "Export Filtered Stats", "download-manager" ) ?></a>
                    <a href="edit.php?post_type=wpdmpro&page=wpdm-stats&type=history"
                       class="btn btn-danger btn-lg"><?php echo __( "Reset", "download-manager" ) ?></a>
                </div>
			</div>
        </section>


	</form>
</div>


<br/>


<?php if ( $count_downloads_without_paging ) : ?>
	<p><strong>Showing downloads <?= $start + 1 ?> - <?= $start + count( $filtered_result_rows ) ?> of
			total <?= $count_downloads_without_paging ?> </strong></p>

	<!-- Result table -->
	<div class="panel panel-default dashboard-panel">
		<table class="table table-striped">
			<thead>
			<tr>
				<th class="bg-white"><?php _e( "Package Name", "download-manager" ); ?></th>
				<th class="bg-white"><?php _e( "File Name", "download-manager" ); ?></th>
				<th class="bg-white"><?php _e( "Version", "download-manager" ); ?></th>
				<th class="bg-white"><?php _e( "Download Time", "download-manager" ); ?></th>
				<th class="bg-white"><?php _e( "User", "download-manager" ); ?></th>
				<th class="bg-white"><?php _e( "IP", "download-manager" ); ?></th>
				<th class="bg-white"><?php _e( "Browser", "download-manager" ); ?></th>
				<th class="bg-white"><?php _e( "OS", "download-manager" ); ?></th>
			</tr>
			</thead>
			<tbody>
			<?php
			foreach ( $filtered_result_rows as $stat ) {
				$agent        = WPDM()->userAgent->set( $stat->agent )->parse();
				$display_name = 'Guest';
				if ( $stat->uid > 0 ) {
					$user = get_user_by( 'id', $stat->uid );
					if ( is_object( $user ) ) {
						$display_name = $user->display_name;
					} else {
						$display_name = '[ Deleted User ]';
					}
				}
				?>
				<tr>
					<!-- Package -->
					<td>
						<a title='Filter By This Package' class='ttip'
						   href="edit.php?post_type=wpdmpro&page=wpdm-stats&type=history&package_ids[]=<?php echo $stat->pid ?>">
							<?php echo $stat->post_title; ?>
						</a>
						<div class="show-on-hover pull-right">
							<a target='_blank' href="post.php?action=edit&post=<?php echo $stat->pid; ?>"
							   title='Edit Package' class='ttip'>
								<i class="fas fa-pen-square"></i>
							</a>
							&mdash;
							<a target='_blank' href="<?php echo get_permalink( $stat->pid ); ?>" title='View Package'
							   class='ttip'>
								<i class="fas fa-eye"></i>
							</a>
						</div>
					</td>
					<!-- filename -->
					<td><?php echo $stat->filename; ?></td>
					<!-- version -->
					<td><?php echo $stat->version; ?></td>
					<!-- time -->
					<td><?php echo wp_date( get_option( 'date_format' ) . " " . get_option( 'time_format' ), $stat->timestamp ); ?></td>
					<!-- user -->
					<td><?php echo $stat->uid > 0 ? "<a title='Filter By This User' class='ttip' href='edit.php?post_type=wpdmpro&page=wpdm-stats&type=history&filter=1&user_ids[0]={$stat->uid}'>{$display_name}</a><div class='show-on-hover pull-right'><a target='_blank' title='Edit User' class='ttip' href='user-edit.php?user_id={$stat->uid}'><i class='fas fa-pen'></i></a></div>" : "Guest"; ?></td>
					<!-- IP -->
					<td><?php echo( ( get_option( '__wpdm_noip' ) == 0 ) ? "<a target='_blank' href='https://ip-api.com/#{$stat->ip}'>{$stat->ip}</a>" : "Unknown" ); ?></td>
					<!-- Browser -->
					<td><?php echo $agent->browserName; ?></td>
					<!-- OS -->
					<td><?php echo $agent->OS; ?></td>
				</tr>
				<?php
			}
			?>

			</tbody>
		</table>

		<div class="panel-footer">
			<?php


			//if( $wp_rewrite->using_permalinks() && !is_search())
			//    $pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg('s',get_pagenum_link(1) ) ) . 'paged=%#%', 'paged');

			if ( ! empty( $wp_query->query_vars['s'] ) ) {
				$pagination['add_args'] = array( 's' => get_query_var( 's' ) );
			}

			echo '<div class="text-center">' . str_replace( '<ul class=\'page-numbers\'>', '<ul class="pagination pagination-centered page-numbers" style="margin: 0">', paginate_links( $pagination ) ) . '</div>';
			?>
		</div>
	</div>

<?php else : ?>
	<div class="col-md-12">
		<div class="alert alert-info">
			<p>No downloads found</p>
		</div>
	</div>
<?php endif; ?>

<!-- SCRIPTS -->

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    jQuery(function ($) {

        $(".datepicker").datepicker({
            dateFormat: 'yy-mm-dd',
            minDate: new Date(<?= intval( $min_timestamp ) * 1000 ?>),
            maxDate: new Date()
        });


        $('#cats').select2();
        $('#package_ids').select2({
            theme: "classic",
            placeholder: "Filter by package titles",
            ajax: {
                url: ajaxurl,
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        action: 'wpdm_stats_get_packages',
                        term: params.term, // search term
                    };
                },
                cache: true
            },
            minimumInputLength: 2
        });


        $('#user_ids').select2({
            theme: "classic",
            placeholder: "Filter by user name, email",
            ajax: {
                url: ajaxurl,
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        action: 'wpdm_stats_get_users',
                        term: params.term, // search term
                    };
                },
                cache: true
            },
            minimumInputLength: 2
        });

    })
</script>
<style>
    .w3eden .input-group * {
        border-radius: 0 !important;
    }

    .w3eden .panel th.bg-white {
        background: #ffffff !important;
    }

    .select2-container--classic .select2-selection--multiple {
        padding-bottom: 10px;
    }

    .w3eden .select2-selection {
        border: 1px solid #ccc;
        height: 46px;
        margin: 0;
        padding: 0 10px;
    }

    .select2-selection textarea {
        min-height: 32px;
        line-height: 32px;
        padding: 0;
        margin: 0;
    }
</style>
