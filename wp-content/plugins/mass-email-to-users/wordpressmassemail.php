<?php
  /* 
    Plugin Name: WordPress Mass Email to users
    Plugin URI:http://www.i13websolution.com/wordpress-bulk-email-pro-plugin.html
    Description:Plugin for send mass email to registered users
    Author:I Thirteen Web Solution
    Version:1.1.5
    Text Domain:mass-email-to-users
    Domain Path: /languages
    Author URI:http://www.i13websolution.com/wordpress-bulk-email-pro-plugin.html
*/  
    

    
    add_action('admin_menu',    'massemail_plugin_menu');  
    add_action('plugins_loaded', 'wmeu_lang_for_wp_mass_emails_to_users');
    register_deactivation_hook(__FILE__,'wmeu_mass_email_remove_access_capabilities');
    register_activation_hook(__FILE__,'wmeu_mass_email_add_access_capabilities');
    add_filter( 'user_has_cap', 'wmeu_mass_email_admin_cap_list' , 10, 4 );
    
    function massemail_plugin_menu(){
      
      $hook_suffix_mass_email_p=add_menu_page(__('Mass Email','mass-email-to-users'), __("Mass Email",'mass-email-to-users'), 'wmeu_mass_email_to_users', 'Mass-Email','massEmail_func');
      add_action( 'load-' . $hook_suffix_mass_email_p , 'massemail_plugin_admin_init' );
    }

    function wmeu_lang_for_wp_mass_emails_to_users() {
      
      load_plugin_textdomain( 'mass-email-to-users', false, basename( dirname( __FILE__ ) ) . '/languages/' );
      add_filter( 'map_meta_cap',  'map_wmeu_mass_email_meta_caps', 10, 4 );
    }
    
    
     function wmeu_mass_email_admin_cap_list($allcaps, $caps, $args, $user){
        
        
        if ( ! in_array( 'administrator', $user->roles ) ) {

            return $allcaps;
        }
        else{

            if(!isset($allcaps['wmeu_mass_email_to_users'])){

                $allcaps['wmeu_mass_email_to_users']=true;
            }
            
         


        }

        return $allcaps;

    }
    
     function map_wmeu_mass_email_meta_caps( array $caps, $cap, $user_id, array $args  ) {
        
     
            if ( ! in_array( $cap, array(
                
              'wmeu_mass_email_to_users',
           

          ), true ) ) {

             return $caps;
         }




         $caps = array();

         switch ( $cap ) {

           case 'wmeu_mass_email_to_users':
           $caps[] = 'wmeu_mass_email_to_users';
           break;

         
           default:

           $caps[] = 'do_not_allow';
           break;
       }


       return apply_filters( 'wmeu_mass_email_meta_caps', $caps, $cap, $user_id, $args );
     }
   
     function wmeu_mass_email_add_access_capabilities() {

        // Capabilities for all roles.
        $roles = array( 'administrator' );
        foreach ( $roles as $role ) {

            $role = get_role( $role );
            if ( empty( $role ) ) {
                continue;
            }


            if(!$role->has_cap( 'wmeu_mass_email_to_users' ) ){

                $role->add_cap( 'wmeu_mass_email_to_users' );
            }
            
           



        }

        $user = wp_get_current_user();
        $user->get_role_caps();

    }
    
    function wmeu_mass_email_remove_access_capabilities(){

        global $wp_roles;

        if ( ! isset( $wp_roles ) ) {
            $wp_roles = new WP_Roles();
        }

        foreach ( $wp_roles->roles as $role => $details ) {
            
            $role = $wp_roles->get_role( $role );
            if ( empty( $role ) ) {
                continue;
            }

            $role->remove_cap( 'wmeu_mass_email_to_users');
          
        }

        // Refresh current set of capabilities of the user, to be able to directly use the new caps.
        $user = wp_get_current_user();
        $user->get_role_caps();

    }
    
    function massemail_plugin_admin_init(){
      
     $url = plugin_dir_url(__FILE__);
     wp_enqueue_script('jquery');
     wp_enqueue_script( 'jqueryValidate', $url.'js/jqueryValidate.js' );
     wp_enqueue_style ( 'mass-email-admin-css', plugins_url ( '/css/styles.css', __FILE__ ) );
     
   }
   
   function massEmail_func(){
     
     $selfpage=$_SERVER['PHP_SELF']; 
     
     $action='';
     if(isset($_REQUEST['action'])){
      $action=$_REQUEST['action'];
    } 
    ?> 
    <table><tr>
     <td>
      <div class="fb-like" data-href="https://www.facebook.com/i13websolution" data-layout="button" data-action="like" data-size="large" data-show-faces="false" data-share="false"></div>
      <div id="fb-root"></div>
      <script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.2&appId=158817690866061&autoLogAppEvents=1';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));</script>
    </td> 
    <td>
      <a target="_blank" title="Donate" href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=nvgandhi123@gmail.com&item_name=Wp%20Mass%20email&item_number=mass%20email%20support&no_shipping=0&no_note=1&tax=0&currency_code=USD&lc=US&bn=PP%2dDonationsBF&charset=UTF%2d8">
        <img id="help us for free plugin" height="30" width="90" src="<?php echo plugins_url( 'images/paypaldonate.jpg', __FILE__ );?>" border="0" alt="help us for free plugin" title="help us for free plugin">
      </a>
    </td>
  </tr>
</table>
<h3 style="color: blue;"><a target="_blank" href="http://www.i13websolution.com/wordpress-pro-plugins/wordpress-bulk-email-pro-plugin.html"><?php echo __( 'UPGRADE TO PRO VERSION','mass-email-to-users');?></a></h3>
<?php         

switch($action){
  
  case 'sendEmailSend':
  
        $retrieved_nonce = '';

        if(isset($_POST['mass_email_nonce']) and $_POST['mass_email_nonce']!=''){

          $retrieved_nonce=sanitize_text_field($_POST['mass_email_nonce']);

        }
        if (!wp_verify_nonce($retrieved_nonce, 'action_mass_email_nonce' ) ){


          wp_die('Security check fail'); 
        }  

        $emailTo= preg_replace('/\s\s+/', ' ', $_POST['emailTo']);
        $toSendEmail=explode(",",$emailTo);
        $flag=false;
        foreach($toSendEmail as $key=>$val){

          $val=trim($val);

          $subject=sanitize_text_field($_POST['email_subject']);
          $from_name=sanitize_text_field($_POST['email_From_name']);
          $from_email=sanitize_text_field($_POST['email_From']);
          $emailBody=wp_kses_post($_POST['txtArea']);

          $userInfo=get_user_by('email',$val);
          $usernamerep="";
          if(is_object($userInfo)){
            $uerIdunsbs=base64_encode($userInfo->ID);
            $usernamerep=$userInfo->user_login;
          }
          $emailBody=stripslashes($emailBody);

          $emailBody=str_replace('[username]',$usernamerep,$emailBody); 
          $emailBody=wpautop($emailBody); 
          $charSet=get_bloginfo('charset');
          
          $mailheaders='';
          $mailheaders .= "Content-Type: text/html; charset=\"$charSet\"\n";
          $mailheaders .= "From: $from_name <$from_email>" . "\r\n";
              //$mailheaders .= "Bcc: $emailTo" . "\r\n";
          
          $emailBody='<!DOCTYPE html><html '.get_language_attributes().'><head> <meta http-equiv="Content-Type" content="text/html; charset='. get_bloginfo( "charset" ).'" /><title>'.get_bloginfo( 'name', 'display' ).'</title></head><body>'.$emailBody.'</body></html>';
          
   
          $Rreturns=wp_mail($val, $subject, $emailBody, $mailheaders);
          if($Rreturns)
           $flag=true;

       }  
       $adminUrl=get_admin_url();
       if($flag){

        update_option( 'mass_email_succ', __('Email sent successfully.' ,'mass-email-to-users'));
        if(isset($_POST['setPerPage']) and (int)$_POST['setPerPage']>0){

          $setPerPage=intval($_POST['setPerPage']);
          $searchuser=esc_html(sanitize_text_field(esc_sql($_POST['searchuser'])));
          
        }else{

          $setPerPage=30;
          
        }

        if(isset($_POST['entrant']) and (int)$_POST['entrant']>0){

          $entrant=intval($_POST['entrant']);
          $searchuser=esc_html(sanitize_text_field(esc_sql($_POST['searchuser'])));
          
        }else{

          $entrant=1;
        }



        echo "<script>location.href='". $adminUrl."admin.php?page=Mass-Email&entrant=$entrant&setPerPage=$setPerPage&searchuser=$searchuser"."';</script>"; 
        exit;

      }
      else{


       if(isset($_POST['setPerPage']) and (int)$_POST['setPerPage']>0){

        $setPerPage=intval($_POST['setPerPage']);
        $searchuser=esc_html(sanitize_text_field(esc_sql($_POST['searchuser'])));
        
      }else{

        $setPerPage=30;
        
      }
      if(isset($_POST['entrant']) and (int)$_POST['entrant']>0){

        $entrant=intval($_POST['entrant']);
        $searchuser=esc_html(sanitize_text_field(esc_sql($_POST['searchuser'])));
        
      }else{

        $entrant=1;
      }

      update_option( 'mass_email_err', __( 'Unable to send email to users.','mass-email-to-users') );
      echo "<script>location.href='". $adminUrl."admin.php?page=Mass-Email&entrant=$entrant&setPerPage=$setPerPage&searchuser=$searchuser"."';</script>";
      exit;
      } 
      break;

case 'sendEmailForm' :

    $retrieved_nonce = '';

    if(isset($_POST['mass_email_nonce']) and $_POST['mass_email_nonce']!=''){

      $retrieved_nonce=sanitize_text_field($_POST['mass_email_nonce']);

    }
    if (!wp_verify_nonce($retrieved_nonce, 'action_mass_email_nonce' ) ){


      wp_die('Security check fail'); 
    } 

    $lastaccessto=$_SERVER['QUERY_STRING'];
  
    $subscribersSelectedEmails=$_POST['ckboxs'];
    $convertToString=implode(",\n",$subscribersSelectedEmails); 

    if(!isset($entrant)){
     $entrant=1;
    }

    if(!isset($setPerPage)){
     $setPerPage=30;
    }
    
    if(empty($searchuser)){

          $searchuser='';
      }

    ?>    
    <h3><?php echo __( 'Send Email to Users','mass-email-to-users');?></h3>  
   
    <div style="width: 100%;">  
     <div style="float:left;width:100%;" >
   
       <form name="frmSendEmailsToUserSend" id='frmSendEmailsToUserSend' method="post" action="" > 
            <?php wp_nonce_field('action_mass_email_nonce','mass_email_nonce'); ?>    
            <input type="hidden" value="sendEmailSend" name="action"> 
            <input type="hidden" value="<?php echo $entrant; ?>" name="entrant"> 
            <input type="hidden" value="<?php echo $setPerPage; ?>" name="setPerPage"> 
            <input type="hidden" value="<?php echo $searchuser; ?>" name="searchuser"> 
            <table class="form-table" style="width:100%" >
              <tbody>
                <tr valign="top" id="subject">
                 <th scope="row" style="width:30%;text-align: right;"><?php echo __( 'Subject','mass-email-to-users');?> *</th>
                 <td>    
                  <input type="text" id="email_subject" name="email_subject"  class="valid" size="70">
                  <div style="clear: both;"></div><div></div>
                </td>
              </tr>
              <tr valign="top" id="subject">
               <th scope="row" style="width:30%;text-align: right"><?php echo __( 'Email From Name','mass-email-to-users');?> *</th>
               <td>    
                <input type="text" id="email_From_name" name="email_From_name"  class="valid" size="70">
                <br/><?php echo __( '(ex. admin)','mass-email-to-users');?> 
                <div style="clear: both;"></div><div></div>

              </td>
            </tr>
            <tr valign="top" id="subject">
             <th scope="row" style="width:30%;text-align: right"><?php echo __( 'Email From','mass-email-to-users');?> *</th>
             <td>    
              <input type="text" id="email_From" name="email_From"  class="valid" size="70">
              <br/><?php echo __( '(ex. admin@yoursite.com)','mass-email-to-users');?>
              <div style="clear: both;"></div><div></div>

            </td>
          </tr>
          <tr valign="top" id="subject">
           <th scope="row" style="width:30%;text-align: right"><?php echo __( 'Email To','mass-email-to-users');?> *</th>
           <td>    
            <textarea id='emailTo'  readonly="readonly"  name="emailTo" cols="58" rows="4"><?php echo $convertToString;?></textarea>
            <div style="clear: both;"></div><div></div>
          </td>
        </tr>
        <tr valign="top" id="subject">
         <th scope="row" style="width:30%;text-align: right"><?php echo __( 'Email Body','mass-email-to-users');?> *</th>
         <td>    
           <div class="wrap">
             <?php wp_editor( '', 'txtArea' );?>
             <input type="hidden" name="editor_val" id="editor_val" />    
             <div style="clear: both;"></div><div></div>                       
           </div>
           <input type="hidden" name="editor_val" id="editor_val" />  
           <div style="clear: both;"></div><div></div> 
           <b><?php echo __( 'you can use [username] place holder into email content','mass-email-to-users');?></b>   
         </td>
        </tr>
        <tr valign="top" id="subject">
         <th scope="row" style="width:30%"></th>
         <td> 

           <?php wp_nonce_field('action_mass_email_nonce','mass_email_nonce'); ?>  
           <input type='submit'  value='<?php echo __( 'Send Email','mass-email-to-users');?>' name='sendEmailsend' class='button-primary' id='sendEmailsend' >  
         </td>
        </tr>

        </table>
   </form>
    <script type="text/javascript">


        jQuery.validator.addMethod("chkCont", function(value, element) {
                                            
                                              

              var editorcontent=tinyMCE.get('txtArea').getContent();

              if (editorcontent.length){
                return true;
              }
              else{
                 return false;
              }
         
      
        },
             "<?php echo __( 'Please enter email content','mass-email-to-users');?>"
     );
     
     

       jQuery("#frmSendEmailsToUserSend").validate({
        errorClass: "error_admin_massemail",
        rules: {
         email_subject: { 
          required: true
        },
        email_From_name: { 
          required: true
        },  
        email_From: { 
          required: true ,email:true
        }, 
        emailTo:{

         required: true 
       },
      editor_val:{
            chkCont: true 
         } 

    }, 

    errorPlacement: function(error, element) {
      error.appendTo( element.next().next());
    }

    });


   
    </script> 
    </div>

    </div>           
<?php 
break;
default: 
    
    $url=plugin_dir_url(__FILE__);
    ?>
    <div style="width: 100%;">  
     <div style="float:left;width:65%;" >
      <div class="wrap">                                                                 
 
        <?php       
        global $wpdb;

        $rows_per_page = 30;
        if(isset($_GET['setPerPage']) and $_GET['setPerPage']!=""){

         $rows_per_page=intval($_GET['setPerPage']);
       } 

       $current = (isset($_GET['entrant'])) ? (intval($_GET['entrant'])) : 1;
       $wpcurrentdir=dirname(__FILE__);
       $wpcurrentdir=str_replace("\\","/",$wpcurrentdir);


       $unscbscribersQuery="SELECT GROUP_CONCAT( user_id ) AS  `unsbscribers` 
       FROM  $wpdb->usermeta 
       WHERE  `meta_key` =  'is_unsubscibed' and meta_value='1'" ;

       $resultUnsb=$wpdb->get_results($unscbscribersQuery,'ARRAY_A');

       $unsubscriber_users=$resultUnsb[0]['unsbscribers'];

       if($unsubscriber_users=="" or $unsubscriber_users==null)
         $unsubscriber_users=0;


       $query="SELECT ID,user_email from $wpdb->users where ID NOT IN ($unsubscriber_users)";
       $queryCount="SELECT count(ID) from $wpdb->users where ID NOT IN ($unsubscriber_users)";
        if(isset($_GET['searchuser']) and $_GET['searchuser']!=''){
            
            $term=esc_html(esc_sql(sanitize_text_field($_GET['searchuser'])));   
            $query.="  and ( user_login like '%$term%' or user_nicename like '%$term%' or user_email like '%$term%' or  display_name like '%$term%'  )  " ; 
            $queryCount.="  and ( user_login like '%$term%' or user_nicename like '%$term%' or user_email like '%$term%' or  display_name like '%$term%'  )  " ; 


          } 
          
       $totalRecordForQuery=$wpdb->get_var($queryCount);    

       $selfPage=$_SERVER['PHP_SELF'].'?page=Mass-Email'; 

       $pagination_args = array(
        'base' => @add_query_arg('entrant','%#%'),
        'format' => '',
        'total' => ceil($totalRecordForQuery/$rows_per_page),
        'current' => $current,
        'show_all' => false,
        'type' => 'plain',
      );

       $offset = ($current - 1) * $rows_per_page;
       $query.=" limit $offset, $rows_per_page";
       
       $emails=$wpdb->get_results($query,'ARRAY_A');
      
       $selfpage=$_SERVER['PHP_SELF'];

       if($totalRecordForQuery>0){



        ?>              
        <?php
        $SuccMsg=get_option('mass_email_succ');
        update_option( 'mass_email_succ', '' );

        $errMsg=get_option('mass_email_err');
        update_option( 'mass_email_err', '' );
        ?> 

        <?php
          if(trim($errMsg)!=''){ echo "<div class='notice notice-error is-dismissible'><p>"; echo $errMsg; $errMsg='';echo "</p></div>";}
          else if(trim($SuccMsg)!=''){ echo "<div class='notice notice-success is-dismissible'><p>"; echo $SuccMsg;$SuccMsg=''; echo "</p></div>";}
       ?>
        <h3><?php echo __( 'Send email to users','mass-email-to-users');?></h3>
         <?php
            $setacrionpage='admin.php?page=Mass-Email';

            if(isset($_GET['entrant']) and $_GET['entrant']!=""){
             $setacrionpage.='&entrant='.intval($_GET['entrant']);   
            }

            if(isset($_GET['setPerPage']) and $_GET['setPerPage']!=""){
             $setacrionpage.='&setPerPage='.intval($_GET['setPerPage']);   
            }

            $seval="";
            if(isset($_GET['searchuser']) and $_GET['searchuser']!=""){
             $seval=esc_html(sanitize_text_field(esc_sql(trim($_GET['searchuser']))));   
            }

        ?>
        
          <div style="padding-top:5px;padding-bottom:5px"><b><?php echo __( 'Search User','mass-email-to-users');?> : </b><input type="text" value="<?php echo $seval;?>" id="searchuser" name="searchuser">&nbsp;<input type='submit'  value='<?php echo __( 'Search User','mass-email-to-users');?>' name='searchusrsubmit' class='button-primary' id='searchusrsubmit' onclick="SearchredirectTO();" >&nbsp;<input type='submit'  value='<?php echo __( 'Reset Search','mass-email-to-users');?>' name='searchreset' class='button-primary' id='searchreset' onclick="ResetSearch();" ></div>  
        <script type="text/javascript" >
         function SearchredirectTO(){
           var redirectto='<?php echo $setacrionpage; ?>';
           var searchval=jQuery('#searchuser').val();
           redirectto=redirectto+'&searchuser='+jQuery.trim(searchval);    
           window.location.href=redirectto;
         }
        function ResetSearch(){

             var redirectto='<?php echo $setacrionpage; ?>';
             window.location.href=redirectto;
        }
        </script>  
        <form method="post" action="" id="sendemail" name="sendemail" onkeypress="return event.keyCode != 13;">

        
          <?php wp_nonce_field('action_mass_email_nonce','mass_email_nonce'); ?>   
          <input type="hidden" value="sendEmailForm" name="action" id="action">

          <table class="widefat fixed" cellspacing="0" style="width:97% !important" >
            <thead>
              <tr>
                <th scope="col" id="name" class="manage-column column-name" style=""><input onclick="chkAll(this)" type="checkbox" name="chkallHeader" id='chkallHeader'>&nbsp;<?php echo __( 'Select All Emails','mass-email-to-users');?></th>
                <th scope="col" id="name" class="manage-column column-name" style=""><?php echo __( 'Username','mass-email-to-users');?></th>

              </tr>
            </thead>

            <tfoot>
              <tr>
                <th scope="col" id="name" class="manage-column column-name" style=""><input onclick="chkAll(this)" type="checkbox" name="chkallfooter" id='chkallfooter'>&nbsp;<?php echo __( 'Select All Emails','mass-email-to-users');?></th>
                <th scope="col" id="name" class="manage-column column-name" style=""><?php echo __( 'Username','mass-email-to-users');?></th>


              </tr>
            </tfoot>

            <tbody id="the-list" class="list:cat">
             <?php                             
             foreach($emails as $em)
             {


          
               $userId=$em['ID'];
               $user_info = get_userdata($userId); 
               echo"<tr class='iedit alternate'>
               <td  class='name column-name' style='border:1px solid #DBDBDB;padding-left:13px;'><input type='checkBox' name='ckboxs[]'  value='".$em['user_email']."'>&nbsp;".$em['user_email']."</td>";
               echo "<td  class='name column-name' style='border:1px solid #DBDBDB;'> ".$user_info->user_login."</td>";
               echo "</tr>";
                

           }

           ?>  
         </tbody>       
       </table>
       <table>
        <tr>
          <?php if($totalRecordForQuery>0 && $totalRecordForQuery>$rows_per_page):?>  
            <td>
              <?php
               echo "<div class='pagination' style='padding-top:10px'>";
               echo paginate_links($pagination_args);
               echo "</div>";
             ?>

           </td>
         <?php endif;?>
         <td>
          <b>&nbsp;&nbsp;<?php echo __( 'Per Page','mass-email-to-users');?> : </b>
          <?php
          $setPerPageadmin='admin.php?page=Mass-Email';
                            /*if(isset($_GET['entrant']) and $_GET['entrant']!=""){
                                $setPerPageadmin.='&entrant='.(int)trim($_GET['entrant']);
                              }*/
                              $setPerPageadmin.='&setPerPage=';
                              ?>
                              <select name="setPerPage" onchange="document.location.href='<?php echo $setPerPageadmin;?>' + this.options[this.selectedIndex].value + ''">
                                <option <?php if($rows_per_page=="10"): ?>selected="selected"<?php endif;?>  value="10">10</option>
                                <option <?php if($rows_per_page=="20"): ?>selected="selected"<?php endif;?> value="20">20</option>
                                <option <?php if($rows_per_page=="30"): ?>selected="selected"<?php endif;?>value="30">30</option>
                                <option <?php if($rows_per_page=="40"): ?>selected="selected"<?php endif;?> value="40">40</option>
                                <option <?php if($rows_per_page=="50"): ?>selected="selected"<?php endif;?> value="50">50</option>

                              </select>  
                            </td>
                          </tr>
                          <tr>
                            <td class='name column-name' style='padding-top:15px;padding-left:10px;'><input onclick="return validateSendEmailAndDeleteEmail(this)" type='submit' value='<?php echo __( 'Send Email to Users','mass-email-to-users');?>' name='sendEmail' class='button-primary' id='sendEmail' ></td>
                          </tr>
                        </table>
                      </form>  


                      <?php

                    }
                    else
                    {
                     echo '<center><div style="padding-bottom:50pxpadding-top:50px;"><h3>'.__( 'No Users Found','mass-email-to-users').'</h3></div></center>';

                   } 
                   ?>
                 </div>              
               </div>
               <div id="postbox-container-1" class="postbox-container" style="float:right;margin-top: 50px" > 

                <div class="postbox"> 
                  <center><h3 class="hndle"><span></span><?php echo __( 'Access All Themes In One Price','mass-email-to-users');?></h3> </center>
                  <div class="inside">
                    <center><a href="http://www.elegantthemes.com/affiliates/idevaffiliate.php?id=11715_0_1_10" target="_blank"><img border="0" src="<?php echo plugins_url( 'images/300x250.gif', __FILE__ ) ;?>" width="250" height="250"></a></center>

                    <div style="margin:10px 5px">

                    </div>
                  </div></div>
                  <div class="postbox"> 
                      <center><h3 class="hndle"><span></span><?php echo __('Google For Business Coupon','mass-email-to-users');?></h3></center>
                        <div class="inside">
                            <center><a href="https://goo.gl/OJBuHT" target="_blank">
                                    <img src="<?php echo plugins_url( 'images/g-suite-promo-code-4.png', __FILE__ );?>" width="250" height="250" border="0">
                                </a></center>
                            <div style="margin:10px 5px">
                            </div>
                        </div>

                    </div>
                  </div>
                </div>               
                <?php
                break;

              } 

              ?>
              <script type="text/javascript" >

                function chkAll(id){

                  if(id.name=='chkallfooter'){

                    var chlOrnot=id.checked;
                    document.getElementById('chkallHeader').checked= chlOrnot;

                  }
                  else if(id.name=='chkallHeader'){ 

                    var chlOrnot=id.checked;
                    document.getElementById('chkallfooter').checked= chlOrnot;

                  }

                  if(id.checked){

                    var objs=document.getElementsByName("ckboxs[]");

                    for(var i=0; i < objs.length; i++)
                    {
                     objs[i].checked=true;

                   }


                 } 
                 else {

                  var objs=document.getElementsByName("ckboxs[]");

                  for(var i=0; i < objs.length; i++)
                  {
                   objs[i].checked=false;

                 }  
               } 
             } 

             function validateSendEmailAndDeleteEmail(idobj){

               var objs=document.getElementsByName("ckboxs[]");
               var ischkBoxChecked=false;
               for(var i=0; i < objs.length; i++){
                 if(objs[i].checked==true){

                   ischkBoxChecked=true;
                   break;
                 }

               }  

               if(ischkBoxChecked==false)
               {
                 if(idobj.name=='sendEmail'){
                   alert('<?php echo __( 'Please select atleast one email to send email.','mass-email-to-users');?>')  ;
                   return false;

                 }
                 else if(idobj.name=='deleteSubscriber') 
                 {
                  alert('<?php echo __( 'Please select atleast one email to delete.','mass-email-to-users');?>')  
                  return false;  
                }
              }
              else
               return true; 

           } 

         </script>

         <?php  

   }
   
   ?>