<?php
//add_action('init', 'start_session', 1);
add_action( 'wp_ajax_get_child_category_by_parent_id_func', 'get_child_category_by_parent_id_func' );
add_action( 'wp_ajax_nopriv_get_child_category_by_parent_id_func', 'get_child_category_by_parent_id_func' );

add_shortcode( 'download_list', 'get_download_list_func' ); 
function get_download_list_func() 
{
    //InitSession();
    $args = array(
		'cat_id'	=> 0,
		'ids'   	=> '',
		'data'		=> '',
        'data2' 	=> '',
		'sel_data'  =>  ''
    );
	return PostTiles($args);
}

add_shortcode( 'Search_research', 'research' ); 
function research() 
{
    //InitSession();
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $args = array(
		'type'    => 'wpdmpro',
		'post_status'     => 'publish',
		'include' =>'73,74,234,268',
        'taxonomy' => 'wpdmcategory',
		'paged'  =>  $paged,
        'parent'  => 0
    );
    $cats = get_categories($args);
    ?> 

    <form method = "post" class="srch-content" style="width:100%; margin-bottom:0;">
	<div class="row">
        <div>
            <div class="w3eden">
                <div id="search_cat" class="col-md-4 col-sm-6 col-xs-12">
                    <select name="search_main" id="search_cat_parent" style="font-size:15;" class="raas;">
                        <option value="">Click to search our research:</option>
                        <?php
                        foreach($cats as $cates) 
                        { 
                            $cat_final_name=str_replace("[L]", "", $cates->name);
            			    if ($cates->term_id == 306 &&
                                isset($_GET["asxconference"]) &&
                                intval($_GET["asxconference"]) > 0)
                            { 
                                ?><option selected value="<?php echo $cates->term_id?>"><?php echo $cat_final_name; ?></option><?php
                            }
                            else
                            {
                                ?><option value="<?php echo $cates->term_id?>"><?php echo $cat_final_name; ?></option><?php 
                            } 
                        }?>
                    </select>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12" id="search_cat_sub" style="display:none;">
                    <select name="search_main" class="child-cat-cls" id="child_of_childcategory" style="font-size:15;">
                        <option value="">Click here to select from exchanges:</option>
                    </select>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12" id="search_cat_sub2" style="display:none;" class="custom-select">
                    <select name="search_main" class="child_ofchild__childcategory" id="child_ofchild__childcategory">
                        <option value="">Click here to select from company reports:</option>
                    </select>
                </div>
            </div>
        </div>
	</div>
    </form>
    <?php 
    if (isset($_GET["asxconference"]))
    {
        if (intval($_GET["asxconference"]) > 0)
        {
            if (intval($_GET["asxconference"]) == 1)
            {
                echo "<div id='asx1' style='display:none;'>1</div>";
            }
            else
            {
                echo "<div id='asx1' style='display:none;'>2</div>";
            }
        }
    }       
} 

function research_old() 
{
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $args = array(
		'type'    => 'wpdmpro',
		'post_status'     => 'publish',
		'include' =>'306, 73,74,234,268',
        'taxonomy' => 'wpdmcategory',
		'paged'  =>  $paged,
        'parent'  => 0
    );
    $cats = get_categories($args);
    ?> 

    <form method = "post" class="srch-content" style="width:100%; margin-bottom:0;">
	<div class="row">
        <div>
            <div>
                <select name="search_main" id="search_cat_parent" style="font-size:15;">
                    <option value="">Click to search our research:</option>
                    <?php
                    foreach($cats as $cates) 
                    { 
                        $cat_final_name=str_replace("[L]", "", $cates->name);
            			if ($cates->term_id == 306 &&
                            isset($_GET["asxconference"]) &&
                            intval($_GET["asxconference"]) > 0)
                        { 
                            ?><option selected value="<?php echo $cates->term_id?>"><?php echo $cat_final_name; ?></option><?php
                        }
                        else
                        {
                            ?><option value="<?php echo $cates->term_id?>"><?php echo $cat_final_name; ?></option><?php 
                        } 
                    }?>
                </select>
            </div>
            <div class="" id="search_cat_sub" style="display:none;">
                <select name="search_main" class="child-cat-cls" id="child_of_childcategory" style="font-size:15;">
                    <option value="">Click here to select from exchanges:</option>
                </select>
            </div>
            <div class="" id="search_cat_sub2" style="display:none;" class="custom-select">
                <select name="search_main" class="child_ofchild__childcategory" id="child_ofchild__childcategory">
                    <option value="">Click here to select from company reports:</option>
                </select>
            </div>
        </div>
	</div>
    </form>
    <?php 
    if (isset($_GET["asxconference"]))
    {
        if (intval($_GET["asxconference"]) > 0)
        {
            if (intval($_GET["asxconference"]) == 1)
            {
                echo "<div id='asx1' style='display:none;'>1</div>";
            }
            else
            {
                echo "<div id='asx1' style='display:none;'>2</div>";
            }
        }
    }       
} 
	
function get_child_category_by_parent_id_func()
{
    get_child_category_local($_POST['parent_cat_id'], $_POST['sub_cat_id'], $_POST['sub_child_cat_id'], $_POST['p_cat_val'], $_POST['n_asx']);
}

function get_child_category_local($parent_cat_id, $sub_cat_id, $sub_child_cat_id, $p_cat_val, $nASX)
{
 	$data = array();
    $data2 = array();
	$cat_ID = 0;

    if ($nASX > 0)
    {
        if ($nASX == 1)
        {
            $parent_cat_id = 306;
        }
        else
        {
            $parent_cat_id = 306;
            $sub_cat_id = 480; //(do this to select single subcategory)
        }
    }

    //if($sub_cat_id == '' && $sub_child_cat_id == '' &&  $p_cat_val == 'true')
    {
		if($parent_cat_id != '')
        {
			$cat_ID=$parent_cat_id;
            $args = array( 
				'hierarchical' => 1,
				'type'    => 'wpdmpro',
				'post_status'     => 'publish',
                'taxonomy' => 'wpdmcategory',
				'parent' =>  $cat_ID);
						
            $categories = get_categories( $args );
	
             if(!empty($categories))
            {
				$data[] = '<option value="">Click to select category:</option>';
 				foreach ( $categories as $category ) 
                {
                    if ($nASX > 1)
                    {
                        if ($category->term_id == 480)
                        {                   
                            $data[] .= '<option value="'.$category->term_id.'" selected >'.$category->name.'</option>';
                            $nASX = $nASX - 1;
                        }
                        else
                            $data[] .= '<option value="'.$category->term_id.'">'.$category->name.'</option>';
                    }
                    else
                    {
                         $data[] .= '<option value="'.$category->term_id.'">'.$category->name.'</option>';
                    }
            }
            }
            else
                $data[] .='<option value="">Click to select from company reports:</option><option value="">Not Found</option>'; 
        }
		$sel_data="true";
    }

    if($sub_cat_id != '' && $sub_child_cat_id == '')
    {
        $cat_ID=$sub_cat_id;
        $sel_data="false";
        $data2=array();
        $args3 = array( 
			'hierarchical' => 1,
			'type'    => 'wpdmpro',
			'post_status'     => 'publish',
            'taxonomy' => 'wpdmcategory',
			'parent' =>  $cat_ID);

        $categories2 = get_categories( $args3 );
		if(!empty($categories2))
    	{
            $data2[] = '<option value="">Select from reports below</option>';
            foreach ( $categories2 as $category ) 
                $data2[] .= '<option value="'.$category->term_id.'">'.$category->name.' '.$category->description.'</option>';
		}
		else
            $data2[] .='<option value="">No options</option><option value=""></option>'; 

        $sel_data="true_sub_cat";
      
    }
    else if($sub_child_cat_id != '')
		$cat_ID=$sub_child_cat_id;
    else
		//$sel_data="false";
 
	$par_ct=($_POST['parent_cat_id'] != "")?get_the_category_by_ID($parent_cat_id):'';
	$sub_ct=($_POST['sub_cat_id'] != "")?"| ".get_the_category_by_ID($sub_cat_id):''; 
	$all_cat_data=$par_ct.' '.$sub_ct;

	$args = array(
		'cat_id'	=> $cat_ID,
		'data'		=> $data,
		'data2' 	=> $data2,
		'sel_data'  => $sel_data
	);

	$post_data = PostTiles($args);
	$test = count($_SESSION["post_ids"]);
 
	if (count($_SESSION["post_ids"]) == 0)
		$status = false;
	else
		$status = true;
		
 	echo json_encode(array("option_val" => $data,"option_val2" => $data2 ,"post_val" => $post_data, "sel_data_key" => $sel_data, "sel_data_key2" => $all_cat_data, "status" => $status, "asxconference" => $nASX));
	
    die();
}

function CheckSelection()
{
	$pageWasRefreshed = $_POST['b_first']; //isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';

	if ($_POST['parent_cat_id'] != $_SESSION['parent_cat_id']
	 || $_POST['sub_cat_id'] != $_SESSION['sub_cat_id'] 
	 || $_POST['sub_child_cat_id'] != $_SESSION['sub_child_cat_id'] 
	 || $_POST['p_cat_val'] != $_SESSION['p_cat_val']
	 || $pageWasRefreshed == "true")
	 {
		set_session_item('parent_cat_id', $_POST['parent_cat_id']);		 
		set_session_item('sub_cat_id', $_POST['sub_cat_id']);
		set_session_item('sub_child_cat_id', $_POST['sub_child_cat_id']);
		set_session_item('p_cat_val', $_POST['p_cat_val']);
		set_session_item("post_ids", '');

		return true;
	 }
	 return false;
}

function GetPostIDS($cat_ID)
{
	if (CheckSelection())
    {
		  $order_val=($_POST['sort_by_val'] == "post_modified")?'ASC':'DESC';
    	if ($cat_ID == 0)
	    {
		   	$args = array(
		    	'post_type'    => 'wpdmpro',	
			    'posts_per_page' => -1,
    			'post_status'     => 'publish',
           		'order' => $order_val, 			
		   		'fields'  =>  'ids'
		    );
    	} 
	    else 
		{
		    $args = array(
			    'post_type'    => 'wpdmpro',	
			    'posts_per_page' => -1,
			    'post_status'     => 'publish',
			    'fields'  =>  'ids',
        	    'order' => $order_val, 			
			    'tax_query' => 	array(
		   				array(
		    				'taxonomy' => 'wpdmcategory',
			    			'field' => 'term_id',
				    		'terms' => $cat_ID
					    )
				    )
			    );
		}   
		$my_data = new WP_Query($args);
        $my_ids = $my_data->posts;
	    set_session_item("post_ids", $my_ids);
	}
	else
    {
	    $my_ids = $_SESSION["post_ids"];
    }

	$perpage = $_SESSION["posts_default"];

	$ids = array();
	$ids = array_slice($my_ids, 0, $perpage);
	$my_ids = array_diff($my_ids, $ids);

    set_session_item('post_ids', $my_ids);

    return $ids;
}

function PostTiles($args = '')
{
    $defaults = array(
		'cat_id'	=> 0,
		'data'		=> '',
        'data2' 	=> '',
		'sel_data'  =>  ''
    );

	$args     = wp_parse_args( $args, $defaults );

	$cat_ID = $args['cat_id']; 
	$data = $args['data'];
	$data2 = $args['data2'];
	$sel_data = $args['sel_data'];

    $order_val=($_POST['sort_by_val'] == "post_modified")?'ASC':'DESC';
 
	$ids = GetPostIDS($cat_ID);
	if (count($ids) == 0)
		return '';

	if ($cat_ID == "0"  && $ids == '')
    {
        $args2 = array(
            'post_type'    => 'wpdmpro',	
            'posts_per_page' => $_SESSION['posts_max'],
            'post_status'     => 'publish',
            );
        }
    else
    {
        if ($ids == '')
        {
            $args2 = array(
                'post_type'    => 'wpdmpro',	
                'posts_per_page' => $_SESSION['posts_max'],
                'post_status'     => 'publish',
                'tax_query' => array(
                                array(
                                    'taxonomy' => 'wpdmcategory',
                                    'field' => 'term_id',
                                    'terms' => $cat_ID
                                    ) 
                                ) 
                ); 
        }
        else
        {
//            $array = array_map( 'trim', explode( ',', $ids ) ); 
            $args2 = array(
                'post_type'    => 'wpdmpro',	
                'posts_per_page' => $_SESSION['posts_max'],
                'post_status'     => 'publish',
                'post__in' => $ids
//               'tax_query' => array(
//                                array(
//                                    'taxonomy' => 'wpdmcategory',
//                                    'field' => 'term_id',
//                                    'terms' => $cat_ID
//                                    ) 
//                                ) 
                ); 
         }
    }                                                   

    $my_posts = new WP_Query($args2);

    $par_ct=($_POST['parent_cat_id'] != "")?get_the_category_by_ID($_POST['parent_cat_id']):'';
    $sub_ct=($_POST['sub_cat_id'] != "")?"| ".get_the_category_by_ID($_POST['sub_cat_id']):''; 
    $all_cat_data=$par_ct.' '.$sub_ct;
    $cat_arr=array();

	$post_data = '';
	
	if ( $my_posts->have_posts() ) : 
		
		while ( $my_posts->have_posts() ) : $my_posts->the_post();

            $cat_sub_data=array();
            $all_cat_arr = wp_get_post_terms(get_the_ID(), 'wpdmcategory', array("fields" => "all"));
            if(!empty($all_cat_arr))
            {
				foreach($all_cat_arr as $all_cat_val)
 					$cat_sub_data[]=$all_cat_val->name;
            }
            $List = implode(':',$cat_sub_data); 
		
            $image = get_field('company_logo');
            $imageurl = $image['url'];

            if ( has_post_thumbnail() ) 
                $img_feature =  get_the_post_thumbnail( get_the_ID(), array(600,300), array( 'class' => 'alignleft' ) );
            else 
				$img_feature ='<img src="https://raasdev.raasgroup.com/wp-content/uploads/2019/05/sydney-lite.jpg" />';

			$post_data .= WriteTile(site_url(), get_the_title(), get_the_ID(), $imageurl, $List, get_the_date('j M Y'));
		endwhile;

        wp_reset_postdata($cat_ID);  
    else : 
		$post_data .='<p>"'.esc_html_e( 'Sorry, no posts matched your criteria.' ).'"</p>';
    endif;  
	
	return $post_data;
}

function WriteTile($url, $title, $tile_id, $imageurl, $tile_list, $tile_date)
{
    $ticker = substr($title, 0, strpos($title, ' '));

    $start = strpos($title, 'RaaS');

    if (!$start)
        $strDesc = $ticker . '   ' . substr($title, strlen($ticker) + 1, strlen($title) - 10);
    else
        $strDesc = $ticker . ' ' . substr($title, $start, strlen($title) - $start - 10);
    
        $tileCode =
        '<div class="w3eden">'
            . '<div id="equal_box" class="col-md-4 col-sm-6 col-xs-12">'
                . '<a class="wpdm-download-link" rel="nofollow" href="'.$url.'/download/'.$title.'/?wpdmdl='.$tile_id.'" download target="_blank">'
                . '<div id="main_box">'
                    . '<div class="srch-content" style="width:100%;">'
                        . '<div class="panel panel-default">'
                            . '<div class="panel-bodys">'
                                . '<div class="panel-footers" id="topp">'
                                    . '<div class="col-md-4 col-sm-6 col-xs-12">'
                                        . '<span class="categoryss">'.$tile_list.''
                                        . '</span>'
                                    . '</div>'
                                    . '<div class="col-md-4 col-sm-6 col-xs-12">'
                                        . '<span class="logoss">'
                                            . '<img data-src="'.$imageurl.'" src="" class="lazyload"/>'
                                        . '</span>'
                                    . '</div>'
                                    . '<div class="col-md-4 col-sm-6 col-xs-12">'
                                        . '<span class="entry-date">'.$tile_date.'</span>'
                                    . '</div>'
                                . '</div>'
                                . '<div class="medias">'
                                    . '<div class="name_posts">'
                                        . '<strong class="ptitle '.$tile_id.'">'.$strDesc.'</strong>'
                                    . '</div>'
                                . '</div>'
                            . '</div>'
                        . '</div>'
                    . '</div>'
                . '</div>'
                . '</a>'
            . '</div>'
        . '</div>';

    return $tileCode;
}

function WriteSelectors($categories, $nASX)
{
         $tileCode =
        '<div class="w3eden">'
            . '<div id="equal_box" class="col-md-4 col-sm-6 col-xs-12">'
  
 
            . '</div>'
        . '</div>';

    return $tileCode;
}
?>