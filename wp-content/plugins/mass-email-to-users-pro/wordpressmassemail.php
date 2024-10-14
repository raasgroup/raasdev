<?php
  /* 
    Plugin Name: WordPress Mass Email to users Pro
    Plugin URI:https://www.i13websolution.com/product/wordpress-bulk-email-pro-plugin/
    Description: Plugin for send mass email to registered users.
    Author:I Thirteen Web Solution
    Version:1.31
    Text Domain:mass-email-to-users
    Domain Path: /languages
    Author URI:https://www.i13websolution.com
*/  
  
    if ( ! defined( 'ABSPATH' ) ) exit; 

    if (!defined('I13_MU_PSLUG')) {

     define('I13_MU_PSLUG', 'mass-email-to-users-pro');
    }

    if (!defined('I13_MU_PL_VERSION')) {

        define('I13_MU_PL_VERSION', '1.31');
    }
  
  add_action('admin_menu',    'massemail_plugin_menu');  
  add_action('plugins_loaded', 'wmeu_lang_for_wp_mass_emails_to_users');
  
  add_action( 'wp_ajax_getEmailTemplate_massmail', 'getEmailTemplate_massmail' );
  register_activation_hook(__FILE__,'install_mass_mail_admin_check_network');
  register_deactivation_hook(__FILE__,'ms_mass_mail_deactivation');
  add_action('wp_head','nks_unsubscribeuser_mass_mail');
  add_filter( 'user_has_cap', 'wmeu_mass_email_admin_cap_list' , 10, 4 );
  //add_action( 'template_redirect', 'mass_mail_cron_alternative_run' );
  add_filter( 'wp_default_editor', 'force_default_editor_mass_mail' );
  add_filter( 'cron_schedules', 'wp_mass_email_add_fivemin_cron_schedule' );
     // Hook into that action that'll fire every 5 min 
  add_action( 'e_mass_email_cron_action', 'e_mass_email_cron_action_func' );
  add_action('admin_init', 'i13_mass_mail_multisite_check_activated');
 
function i13_mass_email_get_editable_roles() {
    
    global $wp_roles;

    $all_roles = $wp_roles->roles;
    $editable_roles = apply_filters('editable_roles', $all_roles);

    return $editable_roles;
}

function massemail_table_exists( $table_name ) {
       
	global $wpdb;
	$tbl = $wpdb->get_results( $wpdb->prepare(
		"SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = %s AND TABLE_NAME = %s  ",
		DB_NAME, $table_name
	) );
	if ( ! empty( $tbl ) ) {
		return true;
	}
	return false;
        
 } 
 
function i13_mass_email_check_simple_membership_plugin_active(){
    
    $wordfence_isactive=false;
    $active_plugins = (array) apply_filters('active_plugins', get_option('active_plugins', array()));

    if (function_exists('is_multisite') && is_multisite() ) {
                    $active_plugins = array_merge($active_plugins, apply_filters('active_plugins', get_site_option('active_sitewide_plugins', array())));
    }

    if (( in_array('simple-membership/simple-wp-membership.php', $active_plugins) || array_key_exists('simple-membership/simple-wp-membership.php', $active_plugins) ) || ( in_array('simple-membership/simple-wp-membership.php', $active_plugins) || array_key_exists('simple-membership/simple-wp-membership.php', $active_plugins) )) {

            $wordfence_isactive=true;
    }

    return $wordfence_isactive;

    
    
}

function i13_mass_email_get_buddypress_groups() {
    
    $results=array();
    if ( function_exists('bp_is_active') ) {
        
        global $wpdb;
        $query="SELECT * FROM ".$wpdb->prefix."bp_groups order by name asc";
        $results=$wpdb->get_results($query,ARRAY_A);
        
    }
    
    return $results;
}

function i13_mass_email_check_simple_membership_get_levels(){
    
    global $wpdb;
    $levels=array();
    $query = "SELECT * FROM " . $wpdb->prefix . "swpm_membership_tbl WHERE  id !=1 ";
    $levels_res = $wpdb->get_results($query, ARRAY_A);
    foreach ($levels_res as $level) {
        
        $levels[$level['id']]=$level['alias'];
       
    }
    
    return $levels;
}
  
    function wmeu_lang_for_wp_mass_emails_to_users() {
      
      load_plugin_textdomain( 'mass-email-to-users', false, basename( dirname( __FILE__ ) ) . '/languages/' );
      add_filter( 'map_meta_cap',  'map_wmeu_mass_email_meta_caps', 10, 4 );
    }
    
    function force_default_editor_mass_mail() {
        //allowed: tinymce, html
        return 'tinymce';
    }
    
 
    
    function wp_mass_email_add_fivemin_cron_schedule( $schedules ) {
        $schedules['efive_min_mass_mail'] = array(
            'interval' => 60*5, 
            'display'  => __( 'every five min','mass-email-to-users' ),
        );

        return $schedules;
    }

    // Schedule an action if it's not already scheduled
    if ( ! wp_next_scheduled( 'e_mass_email_cron_action' ) ) {
        wp_schedule_event( time(), 'efive_min_mass_mail', 'e_mass_email_cron_action' );
    }

    function ms_mass_mail_deactivation() {
        
            wp_clear_scheduled_hook('e_mass_email_cron_action');
            wmeu_mass_email_remove_access_capabilities();
    }

    
    function wmeu_mass_email_admin_cap_list($allcaps, $caps, $args, $user){
        
        
        if ( ! in_array( 'administrator', $user->roles ) ) {

            return $allcaps;
        }
        else{

            if(!isset($allcaps['wmeu_mass_email_cronjob_settings'])){

                $allcaps['wmeu_mass_email_cronjob_settings']=true;
            }
            
            if(!isset($allcaps['wmeu_mass_email_view_newsletter_templates'])){

                $allcaps['wmeu_mass_email_view_newsletter_templates']=true;
            }
            
            if(!isset($allcaps['wmeu_mass_email_add_newsletter_templates'])){

                $allcaps['wmeu_mass_email_add_newsletter_templates']=true;
            }
            
            if(!isset($allcaps['wmeu_mass_email_edit_newsletter_templates'])){

                $allcaps['wmeu_mass_email_edit_newsletter_templates']=true;
            }
            
            if(!isset($allcaps['wmeu_mass_email_delete_newsletter_templates'])){

                $allcaps['wmeu_mass_email_delete_newsletter_templates']=true;
            }
            if(!isset($allcaps['wmeu_mass_email_send_newsletter'])){

                $allcaps['wmeu_mass_email_send_newsletter']=true;
            }
            
            if(!isset($allcaps['wmeu_mass_email_view_newsletter_log'])){

                $allcaps['wmeu_mass_email_view_newsletter_log']=true;
            }
            
            if(!isset($allcaps['wmeu_mass_email_view_users_to_send_mass_email'])){

                $allcaps['wmeu_mass_email_view_users_to_send_mass_email']=true;
            }
            
         
            if(!isset($allcaps['wmeu_mass_email_send_email_to_selected_users'])){

                $allcaps['wmeu_mass_email_send_email_to_selected_users']=true;
            }
            
            if(!isset($allcaps['wmeu_mass_email_send_email_to_all_users'])){

                $allcaps['wmeu_mass_email_send_email_to_all_users']=true;
            }
            
            if(!isset($allcaps['wmeu_mass_email_view_unsubscribers'])){

                $allcaps['wmeu_mass_email_view_unsubscribers']=true;
            }
            
            if(!isset($allcaps['wmeu_mass_email_re_subscribe_unsubscribers'])){

                $allcaps['wmeu_mass_email_re_subscribe_unsubscribers']=true;
            }
            
            if(!isset($allcaps['wmeu_mass_email_buddypress_fields'])){

                $allcaps['wmeu_mass_email_buddypress_fields']=true;
            }
            
         


        }

        return $allcaps;

    }
    
     function map_wmeu_mass_email_meta_caps( array $caps, $cap, $user_id, array $args  ) {
        
     
        if ( ! in_array( $cap, array(
                
              'wmeu_mass_email_cronjob_settings',
              'wmeu_mass_email_view_newsletter_templates',
              'wmeu_mass_email_add_newsletter_templates',
              'wmeu_mass_email_edit_newsletter_templates',
              'wmeu_mass_email_delete_newsletter_templates',
              'wmeu_mass_email_send_newsletter',
              'wmeu_mass_email_view_newsletter_log',
              'wmeu_mass_email_view_users_to_send_mass_email',
              'wmeu_mass_email_send_email_to_selected_users',
              'wmeu_mass_email_send_email_to_all_users',
              'wmeu_mass_email_view_unsubscribers',
              'wmeu_mass_email_re_subscribe_unsubscribers',
              'wmeu_mass_email_buddypress_fields'
           

          ), true ) ) {

             return $caps;
         }




         $caps = array();

         switch ( $cap ) {

           case 'wmeu_mass_email_cronjob_settings':
            $caps[] = 'wmeu_mass_email_cronjob_settings';
           break;
       
           case 'wmeu_mass_email_view_newsletter_templates':
              $caps[] = 'wmeu_mass_email_view_newsletter_templates';
           break;

         
           case 'wmeu_mass_email_add_newsletter_templates':
              $caps[] = 'wmeu_mass_email_add_newsletter_templates';
           break;
         
           case 'wmeu_mass_email_edit_newsletter_templates':
              $caps[] = 'wmeu_mass_email_edit_newsletter_templates';
           break;
       
           case 'wmeu_mass_email_delete_newsletter_templates':
              $caps[] = 'wmeu_mass_email_delete_newsletter_templates';
           break;

         
           case 'wmeu_mass_email_send_newsletter':
              $caps[] = 'wmeu_mass_email_send_newsletter';
           break;
       
           case 'wmeu_mass_email_view_newsletter_log':
              $caps[] = 'wmeu_mass_email_view_newsletter_log';
           break;

         
           case 'wmeu_mass_email_view_users_to_send_mass_email':
              $caps[] = 'wmeu_mass_email_view_users_to_send_mass_email';
           break;
       
           case 'wmeu_mass_email_send_email_to_selected_users':
              $caps[] = 'wmeu_mass_email_send_email_to_selected_users';
           break;
       
           case 'wmeu_mass_email_send_email_to_all_users':
              $caps[] = 'wmeu_mass_email_send_email_to_all_users';
           break;
       
           case 'wmeu_mass_email_view_unsubscribers':
              $caps[] = 'wmeu_mass_email_view_unsubscribers';
           break;
       
           case 'wmeu_mass_email_re_subscribe_unsubscribers':
              $caps[] = 'wmeu_mass_email_re_subscribe_unsubscribers';
           break;
       
           case 'wmeu_mass_email_buddypress_fields':
              $caps[] = 'wmeu_mass_email_buddypress_fields';
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


            if(!$role->has_cap( 'wmeu_mass_email_cronjob_settings' ) ){

                $role->add_cap( 'wmeu_mass_email_cronjob_settings' );
            }
            
            if(!$role->has_cap( 'wmeu_mass_email_view_newsletter_templates' ) ){

                $role->add_cap( 'wmeu_mass_email_view_newsletter_templates' );
            }
            
           
            if(!$role->has_cap( 'wmeu_mass_email_add_newsletter_templates' ) ){

                $role->add_cap( 'wmeu_mass_email_add_newsletter_templates' );
            }
            
            if(!$role->has_cap( 'wmeu_mass_email_edit_newsletter_templates' ) ){

                $role->add_cap( 'wmeu_mass_email_edit_newsletter_templates' );
            }
            
            if(!$role->has_cap( 'wmeu_mass_email_delete_newsletter_templates' ) ){

                $role->add_cap( 'wmeu_mass_email_delete_newsletter_templates' );
            }
            
            if(!$role->has_cap( 'wmeu_mass_email_send_newsletter' ) ){

                $role->add_cap( 'wmeu_mass_email_send_newsletter' );
            }
            
            if(!$role->has_cap( 'wmeu_mass_email_view_newsletter_log' ) ){

                $role->add_cap( 'wmeu_mass_email_view_newsletter_log' );
            }
            
           
            if(!$role->has_cap( 'wmeu_mass_email_view_users_to_send_mass_email' ) ){

                $role->add_cap( 'wmeu_mass_email_view_users_to_send_mass_email' );
            }
            
            if(!$role->has_cap( 'wmeu_mass_email_send_email_to_selected_users' ) ){

                $role->add_cap( 'wmeu_mass_email_send_email_to_selected_users' );
            }
            
            if(!$role->has_cap( 'wmeu_mass_email_send_email_to_all_users' ) ){

                $role->add_cap( 'wmeu_mass_email_send_email_to_all_users' );
            }
            
            if(!$role->has_cap( 'wmeu_mass_email_view_unsubscribers' ) ){

                $role->add_cap( 'wmeu_mass_email_view_unsubscribers' );
            }
            
            if(!$role->has_cap( 'wmeu_mass_email_re_subscribe_unsubscribers' ) ){

                $role->add_cap( 'wmeu_mass_email_re_subscribe_unsubscribers' );
            }
            
            if(!$role->has_cap( 'wmeu_mass_email_buddypress_fields' ) ){

                $role->add_cap( 'wmeu_mass_email_buddypress_fields' );
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

            $role->remove_cap( 'wmeu_mass_email_cronjob_settings');
            $role->remove_cap( 'wmeu_mass_email_view_newsletter_templates');
            $role->remove_cap( 'wmeu_mass_email_add_newsletter_templates');
            $role->remove_cap( 'wmeu_mass_email_edit_newsletter_templates');
            $role->remove_cap( 'wmeu_mass_email_delete_newsletter_templates');
            $role->remove_cap( 'wmeu_mass_email_send_newsletter');
            $role->remove_cap( 'wmeu_mass_email_view_newsletter_log');
            $role->remove_cap( 'wmeu_mass_email_view_users_to_send_mass_email');
            $role->remove_cap( 'wmeu_mass_email_send_email_to_selected_users');
            $role->remove_cap( 'wmeu_mass_email_send_email_to_all_users');
            $role->remove_cap( 'wmeu_mass_email_view_unsubscribers');
            $role->remove_cap( 'wmeu_mass_email_re_subscribe_unsubscribers');
            $role->remove_cap( 'wmeu_mass_email_buddypress_fields');
          
        }

        // Refresh current set of capabilities of the user, to be able to directly use the new caps.
        $user = wp_get_current_user();
        $user->get_role_caps();

    }

    function e_mass_email_cron_action_func() {
        
            global $wpdb;
            $opt_activation_settings=get_option('ms_massmail_cron_settings'); 
            $allowed_emails_per_hour=$opt_activation_settings['allowed_emails_per_hour'];
            $wait_time_between_two_emails=$opt_activation_settings['wait_time_between_two_emails'];
            $how_many_emails=$allowed_emails_per_hour/12;
            $how_many_emails=intval($how_many_emails);
            $query="SELECT * FROM ".$wpdb->prefix."ms_email_log where status=1 order by id asc limit $how_many_emails";
            $url = get_home_url();
            $results=$wpdb->get_results($query);
            if(is_array($results) and sizeof($results)>0){
                
                foreach($results as $res){
                    
                    
                    $news_letter_id=$res->news_letter_id;
                    
                    $query = "select * from  ".$wpdb->prefix."sent_ms_newsletter where id=$news_letter_id";
                    $newsLetterData=$wpdb->get_row($query); 
                           
                    $val=trim(htmlentities(strip_tags($res->email),ENT_QUOTES));
                    $subject=stripslashes($newsLetterData->subject);
                    $subject=do_shortcode(stripslashes(html_entity_decode($newsLetterData->subject)));
                    $from_name=stripslashes($newsLetterData->email_from_name);
                    $from_email=htmlentities(strip_tags($newsLetterData->email_from),ENT_QUOTES);
                    
                    $emailBody=html_entity_decode($newsLetterData->content);
                    $emailBody=stripslashes($emailBody);
                    $emailBody=do_shortcode(stripslashes($emailBody));
                    
                    

                    $userInfo=get_user_by('email',$val);
                    $usernamerep="";
                    $first_name="";
                    $last_name="";
                    $nickname="";
                    $user_email="";
                    $user_nicename="";
                    $display_name="";
                    $uerIdunsbs='';
                    if(is_object($userInfo)){
                        
                      $uerIdunsbs=base64_encode($userInfo->ID);
                      $usernamerep=$userInfo->user_login;
                      $user_info_meta = get_userdata($userInfo->ID);  
                      $first_name = $user_info_meta->user_firstname;
                      $last_name = $user_info_meta->user_lastname;
                      $nickname= $user_info_meta->nickname;
                      $user_email= $user_info_meta->user_email;
                      $user_nicename= $user_info_meta->user_nicename;
                      $display_name= $user_info_meta->display_name;
                    }

                    

                    $unsubs=$url.'?action=nks_unsubscribeuser_mass_mail&unsc_mass_mail='.$uerIdunsbs;  
                    $unsubscribeLinkHtml='<a href="'.$unsubs.'" target="_blank">Unsubscribe me from all email messages</a>';  
                    $unsubscribeLinkPlain=$unsubs;


                    $emailBody=stripslashes($emailBody);

                    $emailBody=str_replace('[username]',$usernamerep,$emailBody); 
                    $emailBody=str_replace('[first_name]',$first_name,$emailBody); 
                    $emailBody=str_replace('[last_name]',$last_name,$emailBody); 
                    $emailBody=str_replace('[nickname]',$nickname,$emailBody); 
                    $emailBody=str_replace('[user_email]',$user_email,$emailBody); 
                    $emailBody=str_replace('[user_nicename]',$user_nicename,$emailBody); 
                    $emailBody=str_replace('[display_name]',$display_name,$emailBody); 
                    $emailBody=str_replace('[unsubscribe_link_plain]',$unsubscribeLinkPlain,$emailBody); 
                    $emailBody=str_replace('[unsubscribe_link_html]',$unsubscribeLinkHtml,$emailBody); 

                    
                    $subject=str_replace('[username]',$usernamerep,$subject); 
                    $subject=str_replace('[first_name]',$first_name,$subject); 
                    $subject=str_replace('[last_name]',$last_name,$subject); 
                    $subject=str_replace('[nickname]',$nickname,$subject); 
                    $subject=str_replace('[user_email]',$user_email,$subject); 
                    $subject=str_replace('[user_nicename]',$user_nicename,$subject); 
                    $subject=str_replace('[display_name]',$display_name,$subject); 
                    
                    $options=get_option('buddypress_fields');
                    if($options!=false){

                        $selected= json_decode($options,true);
                    }
                  
                    if (function_exists('bp_is_active') && bp_is_active( 'xprofile' ) && is_array($selected) && sizeof($selected)>0 ){

                       $query="SELECT * FROM ".$wpdb->prefix."bp_xprofile_groups";
                       $results=$wpdb->get_results($query,ARRAY_A);

                       if(is_array($results) and sizeof($results)>0 ){


                           foreach($results as $res){


                               if (function_exists('bp_is_active') && bp_is_active( 'xprofile' ) ) : if ( bp_has_profile( array( 'profile_group_id' => $res['id'], 'fetch_field_data' => false ) ) ) : while ( bp_profile_groups() ) : bp_the_profile_group(); 

                                        while ( bp_profile_fields() ) : bp_the_profile_field();

                                           global $field;
                                           if(isset($selected[$field->id]) && isset($selected[$field->id]['list']) && $selected[$field->id]['list']==1){

                                                ob_start();
                                                bp_the_profile_field_name();
                                                $fieldname = ob_get_clean();

                                               $emailBody=str_replace('['.$fieldname.']',i13_format_xprofile_field_for_display(xprofile_get_field_data($field->id,$userInfo->ID)),$emailBody); 
                                               $subject=str_replace('['.$fieldname.']',i13_format_xprofile_field_for_display(xprofile_get_field_data($field->id,$userInfo->ID)),$subject); 

                                           }

                                       endwhile; 


                                       endwhile; endif; endif;
                                   }
                              }
                       }

                    $charSet=get_bloginfo( "charset" );   
                    $mailheaders='';
                    //$mailheaders .= "X-Priority: 1\n";
                    $mailheaders .= "Content-Type: text/html; charset=\"$charSet\"\n";
                    $mailheaders .= "From: $from_name <$from_email>" . "\r\n";
                    //$mailheaders .= "Bcc: $emailTo" . "\r\n";
                    $emailBody=wpautop($emailBody);
                    $emailBody='<!DOCTYPE html><html '.get_language_attributes().'><head> <meta http-equiv="Content-Type" content="text/html; charset='. get_bloginfo( "charset" ).'" /><title>'.get_bloginfo( 'name', 'display' ).'</title></head><body>'.$emailBody.'</body></html>';
                     $is_sent=3;
                     $Rreturns=wp_mail($val, $subject, $emailBody, $mailheaders);
                     if($Rreturns){
                         
                         $is_sent=2;
                     }
                    
                      $createdOn=current_time('mysql');
                        
                        $data=array();
                        $data['status']          =$is_sent;
                        $data['sent_on']         =$createdOn;
                        $where=array('id'=>$res->id);
                        $wpdb->update( $wpdb->prefix."ms_email_log", $data, $where); 
                        sleep($wait_time_between_two_emails);
                        

                    
                }
                
                
            }

        
    }

    function mass_mail_cron_alternative_run(){
        
        if(isset($_GET) and isset($_GET['run_ms_cron'])){
          
            global $wpdb;
            $url = get_home_url();
            $opt_activation_settings=get_option('ms_massmail_cron_settings'); 
            $allowed_emails_per_hour=$opt_activation_settings['allowed_emails_per_hour'];
            $wait_time_between_two_emails=$opt_activation_settings['wait_time_between_two_emails'];
            $how_many_emails=$allowed_emails_per_hour/12;
            $how_many_emails=intval($how_many_emails);
            $query="SELECT * FROM ".$wpdb->prefix."ms_email_log where status=1 order by id asc limit $how_many_emails";
            $results=$wpdb->get_results($query);
            if(is_array($results) and sizeof($results)>0){
                
                foreach($results as $res){
                    
                    
                    $news_letter_id=$res->news_letter_id;
                    
                    $query = "select * from  ".$wpdb->prefix."sent_ms_newsletter where id=$news_letter_id";
                    $newsLetterData=$wpdb->get_row($query); 
                           
                    $val=trim(htmlentities(strip_tags($res->email),ENT_QUOTES));
                    $subject=stripslashes($newsLetterData->subject);
                    $subject=do_shortcode(stripslashes($newsLetterData->subject));
                    $from_name=stripslashes($newsLetterData->email_from_name);
                    $from_email=htmlentities(strip_tags($newsLetterData->email_from),ENT_QUOTES);
                    
                    $emailBody=html_entity_decode($newsLetterData->content);
                    $emailBody=stripslashes($emailBody);
                    $emailBody=do_shortcode(stripslashes($emailBody));

                    $userInfo=get_user_by('email',$val);
                    $usernamerep="";
                    $first_name="";
                    $last_name="";
                    $nickname="";
                    $user_email="";
                    $user_nicename="";
                    $display_name="";
                    $uerIdunsbs='';
                    if(is_object($userInfo)){
                      $uerIdunsbs=base64_encode($userInfo->ID);
                      $usernamerep=$userInfo->user_login;
                      $user_info_meta = get_userdata($userInfo->ID);  
                      $first_name = $user_info_meta->user_firstname;
                      $last_name = $user_info_meta->user_lastname;
                      $nickname= $user_info_meta->nickname;
                      $user_email= $user_info_meta->user_email;
                      $user_nicename= $user_info_meta->user_nicename;
                      $display_name= $user_info_meta->display_name;
                    }
                    


                    $unsubs=$url.'?action=nks_unsubscribeuser_mass_mail&unsc_mass_mail='.$uerIdunsbs;  
                    $unsubscribeLinkHtml='<a href="'.$unsubs.'" target="_blank">Unsubscribe me from all email messages</a>';  
                    $unsubscribeLinkPlain=$unsubs;


                    $emailBody=stripslashes($emailBody);

                    $emailBody=str_replace('[username]',$usernamerep,$emailBody); 
                    $emailBody=str_replace('[first_name]',$first_name,$emailBody); 
                    $emailBody=str_replace('[last_name]',$last_name,$emailBody); 
                    $emailBody=str_replace('[nickname]',$nickname,$emailBody); 
                    $emailBody=str_replace('[user_email]',$user_email,$emailBody); 
                    $emailBody=str_replace('[user_nicename]',$user_nicename,$emailBody); 
                    $emailBody=str_replace('[display_name]',$display_name,$emailBody); 
                    $emailBody=str_replace('[unsubscribe_link_plain]',$unsubscribeLinkPlain,$emailBody); 
                    $emailBody=str_replace('[unsubscribe_link_html]',$unsubscribeLinkHtml,$emailBody); 

                    
                    $subject=str_replace('[username]',$usernamerep,$subject); 
                    $subject=str_replace('[first_name]',$first_name,$subject); 
                    $subject=str_replace('[last_name]',$last_name,$subject); 
                    $subject=str_replace('[nickname]',$nickname,$subject); 
                    $subject=str_replace('[user_email]',$user_email,$subject); 
                    $subject=str_replace('[user_nicename]',$user_nicename,$subject); 
                    $subject=str_replace('[display_name]',$display_name,$subject); 
                    
                    
                    $options=get_option('buddypress_fields');
                    if($options!=false){

                        $selected= json_decode($options,true);
                    }
                  
                    if (function_exists('bp_is_active') && bp_is_active( 'xprofile' ) && is_array($selected) && sizeof($selected)>0 ){

                       $query="SELECT * FROM ".$wpdb->prefix."bp_xprofile_groups";
                       $results=$wpdb->get_results($query,ARRAY_A);

                       if(is_array($results) and sizeof($results)>0 ){


                           foreach($results as $res){


                               if (function_exists('bp_is_active') && bp_is_active( 'xprofile' ) ) : if ( bp_has_profile( array( 'profile_group_id' => $res['id'], 'fetch_field_data' => false ) ) ) : while ( bp_profile_groups() ) : bp_the_profile_group(); 

                                        while ( bp_profile_fields() ) : bp_the_profile_field();

                                           global $field;
                                           if(isset($selected[$field->id]) && isset($selected[$field->id]['list']) && $selected[$field->id]['list']==1){

                                                ob_start();
                                                bp_the_profile_field_name();
                                                $fieldname = ob_get_clean();

                                               $emailBody=str_replace('['.$fieldname.']',i13_format_xprofile_field_for_display(xprofile_get_field_data($field->id,$userInfo->ID)),$emailBody); 
                                               $subject=str_replace('['.$fieldname.']',i13_format_xprofile_field_for_display(xprofile_get_field_data($field->id,$userInfo->ID)),$subject); 

                                           }

                                       endwhile; 


                                       endwhile; endif; endif;
                                   }
                              }
                       }
                   

                    $charSet=get_bloginfo( "charset" );    
                    $mailheaders='';
                    //$mailheaders .= "X-Priority: 1\n";
                    $mailheaders .= "Content-Type: text/html; charset=\"$charSet\"\n";
                    $mailheaders .= "From: $from_name <$from_email>" . "\r\n";
                    //$mailheaders .= "Bcc: $emailTo" . "\r\n";
                    $emailBody=wpautop($emailBody);
                    $emailBody='<!DOCTYPE html><html '.get_language_attributes().'><head> <meta http-equiv="Content-Type" content="text/html; charset='. get_bloginfo( "charset" ).'" /><title>'.get_bloginfo( 'name', 'display' ).'</title></head><body>'.$emailBody.'</body></html>';

                    $is_sent=3;
                     $Rreturns=wp_mail($val, $subject, $emailBody, $mailheaders);
                     if($Rreturns){
                         
                         $is_sent=2;
                     }
                    
                      $createdOn=current_time('mysql');
                     
                        
                        $data=array();
                        $data['status']          =$is_sent;
                        $data['sent_on']         =$createdOn;
                        $where=array('id'=>$res->id);
                        $wpdb->update( $wpdb->prefix."ms_email_log", $data, $where); 
                        sleep($wait_time_between_two_emails);
                        

                    
                }
                
                
            }
            
            
        }   
        
  }
    
  function nks_unsubscribeuser_mass_mail(){
    
    if(isset($_GET) and isset($_GET['action']) and isset($_GET['unsc_mass_mail'])){
            
            if(trim($_GET['unsc_mass_mail'])!=''){
                
                    $emails=get_option('storedSubscription');
                    $unsubscriberEmail=$_GET['unsc_mass_mail'];

                    $userid=base64_decode($unsubscriberEmail);
                    $userid=sanitize_text_field($userid);
                    $userid=esc_html($userid);
                
                    update_user_meta($userid,'is_unsubscibed',1);

                    echo "<script>alert('".__( 'You are successfully unsubscribed from email newsletter.Thank you...','mass-email-to-users')."')</script>";

                    $url=get_bloginfo( 'url' );  
                    echo "<script>window.location.href='$url'</script>";
                
                
           }  
        }
   }  
   
  
function i13_mass_mail_multisite_check_activated() {
    
            global $wpdb;
           $activated = get_site_option('i13_mass_email_multisite_activated');

            if($activated == false) {
                    return false;
            } else {
                    $sql = "SELECT blog_id FROM $wpdb->blogs";
                    $blog_ids = $wpdb->get_col($sql);
                    foreach($blog_ids as $blog_id) {
                            if(!in_array($blog_id, $activated)) {
                                    switch_to_blog($blog_id);
                                    install_mass_mail_admin();
                                    $activated[] = $blog_id;
                            }
                    }
                    restore_current_blog();
                    update_site_option('i13_mass_email_multisite_activated', $activated);
            }
            
 }  
 
 function install_mass_mail_admin_check_network($network_wide) {
    
	if(is_multisite() && $network_wide) { 
        // running on multi site with network install
                global $wpdb;
                $activated = array();
                $sql = "SELECT blog_id FROM $wpdb->blogs";
                $blog_ids = $wpdb->get_col($sql);
                foreach($blog_ids as $blog_id) {
                        switch_to_blog($blog_id);
                        install_mass_mail_admin();
                        $activated[] = $blog_id;
                }
                restore_current_blog();
                update_site_option('i13_mass_email_multisite_activated', $activated);


        } else { 

                install_mass_mail_admin();
        }
}

 function install_mass_mail_admin(){
     
     
           global $wpdb;
           $table_name2 = $wpdb->prefix . "massmail_e_template";
           $table_name3 = $wpdb->prefix . "sent_ms_newsletter";
           $table_name4 = $wpdb->prefix . "ms_email_log";
         
           $charset_collate = $wpdb->get_charset_collate();
           
                $sql2=" CREATE TABLE IF NOT EXISTS " . $table_name2 . " (
                  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                  `subject` varchar(400) NOT NULL,
                  `email_from_name` varchar(200) NOT NULL,
                  `email_from` varchar(400) NOT NULL,
                  `content` text NOT NULL,
                  `createdon` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
                  PRIMARY KEY (`id`)
                ) $charset_collate";
                
                
                 $sql3=" CREATE TABLE IF NOT EXISTS " . $table_name3 . " (
                  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                  `subject` varchar(400) NOT NULL,
                  `email_from_name` varchar(200) NOT NULL,
                  `email_from` varchar(400) NOT NULL,
                  `content` text NOT NULL,
                  `createdon` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
                   PRIMARY KEY (`id`)
                ) $charset_collate";
                
                $sql4=" CREATE TABLE IF NOT EXISTS " . $table_name4 . " (
                  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                  `news_letter_id` int(10) unsigned NOT NULL,
                   `name` varchar(200) default NULL,
                   `email` varchar(250) NOT NULL,
                   `status` tinyint(1) NOT NULL ,
                   `sent_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
                   PRIMARY KEY (`id`)
                ) $charset_collate";
                
                
               require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
               dbDelta($sql2);
               dbDelta($sql3);
               dbDelta($sql4);
               
               
                $ms_massmail_cron_settings=array();
                $ms_massmail_cron_settings['allowed_emails_per_hour']=200;
                $ms_massmail_cron_settings['wait_time_between_two_emails']=1;
                $opt_activation_settings=get_option('ms_massmail_cron_settings');
                if(!is_array($opt_activation_settings)){

                   update_option('ms_massmail_cron_settings', $ms_massmail_cron_settings); 

                } 
                else{
                 
                 
                    $flag=false;
                     if(!isset($opt_activation_settings['wait_time_between_two_emails'])){

                      $flag=true; 
                      $opt_activation_settings['wait_time_between_two_emails']=1;

                    }
                    
                     if($flag==true){

                     
                       update_option('ms_massmail_cron_settings', $opt_activation_settings); 
                    }  
                    
                 
                }
                
                
                wmeu_mass_email_add_access_capabilities();
               
     
 } 
 function massemail_plugin_admin_init(){
     
        $url = plugin_dir_url(__FILE__);  
        wp_enqueue_script('jquery'); 
        wp_enqueue_script( 'jqueryValidate', $url.'js/jqueryValidate.js' );  
        wp_enqueue_script( 'chosen.jquery.min', $url.'js/chosen.jquery.min.js' );  
        wp_enqueue_style ( 'mass-email-admin-css', plugins_url ( '/css/styles.css', __FILE__ ) );
        wp_enqueue_style ( 'chosen.min', plugins_url ( '/css/chosen.min.css', __FILE__ ) );
        
 }
  function massemail_plugin_menu(){
  
      
    $hook_suffix_mass_email_p=add_menu_page(__('Mass Email','mass-email-to-users'), __("Mass Email",'mass-email-to-users'), 'wmeu_mass_email_view_users_to_send_mass_email', 'Mass-Email','massEmail_func');
    $hook_suffix_mass_email_p_3=add_submenu_page( 'Mass-Email', __( 'Cronjob Settings','mass-email-to-users'), __( 'Cronjob Settings','mass-email-to-users'),'wmeu_mass_email_cronjob_settings', 'ms_cron_settings', 'ms_cron_settings_func' );
    $hook_suffix_mass_email_p_4=add_submenu_page( 'Mass-Email', __( 'Send Newsletter','mass-email-to-users'), __( 'Send Newsletter','mass-email-to-users'),'wmeu_mass_email_send_newsletter', 'ms_send_news_letter', 'ms_send_news_letter_func' );
    $hook_suffix_mass_email_p_5=add_submenu_page( 'Mass-Email', __( 'Newsletter Log','mass-email-to-users'), __( 'Newsletter Log','mass-email-to-users'),'wmeu_mass_email_view_newsletter_log', 'mass_mail_newsletters_log', 'mass_mail_newsletters_log_func' );
    $hook_suffix_mass_email_p_2=add_submenu_page( 'Mass-Email', __( 'Manage Email Templates','mass-email-to-users'), __( 'Manage Email Templates','mass-email-to-users'),'wmeu_mass_email_view_newsletter_templates', 'mass_mail_email_template_management', 'mass_mail_email_template_management_func' );
    $hook_suffix_mass_email_p_1=add_submenu_page( 'Mass-Email', __( 'Unsubscribers List','mass-email-to-users'), __( 'Unsubscribers List','mass-email-to-users' ),'wmeu_mass_email_view_unsubscribers', 'Mass-Email-Unsubscriber', 'unsubscriber_list_func' );
    if ( function_exists('bp_is_active') ) {
        
        $hook_suffix_mass_email_p_6=add_submenu_page( 'Mass-Email', __( 'BuddyPress Fields','mass-email-to-users'), __( 'BuddyPress Fields','mass-email-to-users' ),'wmeu_mass_email_buddypress_fields', 'Mass-Email-BuddyPress', 'i13_buddypress_fieldslist' );
        
    }
            
    add_action( 'load-' . $hook_suffix_mass_email_p , 'massemail_plugin_admin_init' );
    add_action( 'load-' . $hook_suffix_mass_email_p_1 , 'massemail_plugin_admin_init' );
    add_action( 'load-' . $hook_suffix_mass_email_p_2 , 'massemail_plugin_admin_init' );
    add_action( 'load-' . $hook_suffix_mass_email_p_3 , 'massemail_plugin_admin_init' );
    add_action( 'load-' . $hook_suffix_mass_email_p_4 , 'massemail_plugin_admin_init' );
    add_action( 'load-' . $hook_suffix_mass_email_p_5 , 'massemail_plugin_admin_init' );
    if ( function_exists('bp_is_active') ) {
 
        add_action( 'load-' . $hook_suffix_mass_email_p_6 , 'massemail_plugin_admin_init' );
    }
   
    
  }

 
 
 function massEmail_func(){
   
   
 $selfpage=$_SERVER['PHP_SELF']; 
   
 $action='';  
 if(isset($_REQUEST['action'])){
     
    $action=$_REQUEST['action']; 
 }
 $selectedRoles=array();
 $selectedMlevels=array();
?>

<?php         
 switch($action){
     
  
  case 'sendEmailSend':
    
    set_time_limit(5000);  
    $retrieved_nonce = '';

    if(isset($_POST['mass_email_nonce']) and $_POST['mass_email_nonce']!=''){

        $retrieved_nonce=$_POST['mass_email_nonce'];

    }
    if (!wp_verify_nonce($retrieved_nonce, 'action_mass_email_nonce' ) ){


        wp_die('Security check fail'); 
    }


    $emailTo= preg_replace('/\s\s+/', ' ', $_POST['emailTo']);
    $toSendEmail=explode(",",$emailTo);
    
     $url = get_home_url();
     $flag=false;
    foreach($toSendEmail as $key=>$val){
        
        $val=trim($val);
        $val = preg_replace('/\s+/', '', $val);
        $val=trim(htmlentities(sanitize_email($val),ENT_QUOTES));
        
        if($val!=''){
            
        
            $subject=do_shortcode(stripslashes($_POST['email_subject']));
           // $subject=trim(htmlentities(strip_tags($subject),ENT_QUOTES));
            $from_name=stripslashes($_POST['email_From_name']);
           // $from_name=trim(htmlentities(strip_tags($from_name),ENT_QUOTES));


            $from_email=htmlentities(sanitize_email($_POST['email_From']),ENT_QUOTES);
            $emailBody=$_POST['txtArea'];

            $userInfo=get_user_by('email',$val);

            $usernamerep="";
            $first_name="";
            $last_name="";
            $nickname="";
            $user_email="";
            $user_nicename="";
            $display_name="";
            $uerIdunsbs='';
            if(is_object($userInfo)){

              $uerIdunsbs=base64_encode($userInfo->ID);
              $usernamerep=$userInfo->user_login;
              $user_info_meta = get_userdata($userInfo->ID);  
              $first_name = $user_info_meta->user_firstname;
              $last_name = $user_info_meta->user_lastname;
              $nickname= $user_info_meta->nickname;
              $user_email= $user_info_meta->user_email;
              $user_nicename= $user_info_meta->user_nicename;
              $display_name= $user_info_meta->display_name;

            }



            $unsubs=$url.'?action=nks_unsubscribeuser_mass_mail&unsc_mass_mail='.$uerIdunsbs;  
            $unsubscribeLinkHtml='<a href="'.$unsubs.'" target="_blank">Unsubscribe me from all email messages</a>';  
            $unsubscribeLinkPlain=$unsubs;


            $emailBody=do_shortcode(stripslashes($emailBody));

            $emailBody=str_replace('[username]',$usernamerep,$emailBody); 
            $emailBody=str_replace('[first_name]',$first_name,$emailBody); 
            $emailBody=str_replace('[last_name]',$last_name,$emailBody); 
            $emailBody=str_replace('[nickname]',$nickname,$emailBody); 
            $emailBody=str_replace('[user_email]',$user_email,$emailBody); 
            $emailBody=str_replace('[user_nicename]',$user_nicename,$emailBody); 
            $emailBody=str_replace('[display_name]',$display_name,$emailBody); 
            $emailBody=str_replace('[unsubscribe_link_plain]',$unsubscribeLinkPlain,$emailBody); 
            $emailBody=str_replace('[unsubscribe_link_html]',$unsubscribeLinkHtml,$emailBody); 


            $subject=str_replace('[username]',$usernamerep,$subject); 
            $subject=str_replace('[first_name]',$first_name,$subject); 
            $subject=str_replace('[last_name]',$last_name,$subject); 
            $subject=str_replace('[nickname]',$nickname,$subject); 
            $subject=str_replace('[user_email]',$user_email,$subject); 
            $subject=str_replace('[user_nicename]',$user_nicename,$subject); 
            $subject=str_replace('[display_name]',$display_name,$subject); 

            $options=get_option('buddypress_fields');
            if($options!=false){

                $selected= json_decode($options,true);
            }

            if (function_exists('bp_is_active') && bp_is_active( 'xprofile' ) && is_array($selected) && sizeof($selected)>0 ){

               global $wpdb; 
               $query="SELECT * FROM ".$wpdb->prefix."bp_xprofile_groups";
               $results=$wpdb->get_results($query,ARRAY_A);

               if(is_array($results) and sizeof($results)>0 ){


                   foreach($results as $res){


                       if (function_exists('bp_is_active') && bp_is_active( 'xprofile' ) ) : if ( bp_has_profile( array( 'profile_group_id' => $res['id'], 'fetch_field_data' => false ) ) ) : while ( bp_profile_groups() ) : bp_the_profile_group(); 

                                while ( bp_profile_fields() ) : bp_the_profile_field();

                                   global $field;
                                   if(isset($selected[$field->id]) && isset($selected[$field->id]['list']) && $selected[$field->id]['list']==1){

                                       ob_start();
                                       bp_the_profile_field_name();
                                       $fieldname = ob_get_clean();
                                       $emailBody=str_replace('['.$fieldname.']',i13_format_xprofile_field_for_display(xprofile_get_field_data($field->id,$userInfo->ID)),$emailBody); 
                                       $subject=str_replace('['.$fieldname.']',i13_format_xprofile_field_for_display(xprofile_get_field_data($field->id,$userInfo->ID)),$subject); 

                                   }

                               endwhile; 


                               endwhile; endif; endif;
                           }
                      }
               }

            $charSet=get_bloginfo( "charset" );    
            $mailheaders='';
            //$mailheaders .= "X-Priority: 1\n";
            $mailheaders .= "Content-Type: text/html; charset=\"$charSet\"\n";
            $mailheaders .= "From: $from_name <$from_email>" . "\r\n";
            //$mailheaders .= "Bcc: $emailTo" . "\r\n";
            $emailBody=wpautop($emailBody);
            $emailBody='<!DOCTYPE html><html '.get_language_attributes().'><head> <meta http-equiv="Content-Type" content="text/html; charset='. get_bloginfo( "charset" ).'" /><title>'.get_bloginfo( 'name', 'display' ).'</title></head><body>'.$emailBody.'</body></html>';


            $Rreturns=wp_mail($val, $subject, $emailBody, $mailheaders);

            if($Rreturns)
               $flag=true;
       }   
        
    }  
     $adminUrl=get_admin_url();
     if($flag){
     
        update_option( 'mass_email_succ', __( 'Email sent successfully.','mass-email-to-users') );
        $entrant=intval($_POST['entrant']);
        $setPerPage=intval($_POST['setPerPage']);
        $searchuser=sanitize_text_field($_POST['searchuser']);
        
        echo "<script>location.href='". $adminUrl."admin.php?page=Mass-Email&entrant=$entrant&setPerPage=$setPerPage&searchuser=$searchuser"."';</script>"; 
        die;
     }
    else{
        
           $entrant=empty($_POST['entrant'])?1:(int)$_POST['entrant'];
           $setPerPage=empty($_POST['setPerPage'])?10:(int)$_POST['setPerPage'];
           $searchuser=htmlentities(sanitize_text_field($_POST['searchuser']),ENT_QUOTES);
           
           update_option( 'mass_email_err', __( 'Unable to send email to users.' ,'mass-email-to-users'));
           echo "<script>location.href='". $adminUrl."admin.php?page=Mass-Email&entrant=$entrant&setPerPage=$setPerPage&searchuser=$searchuser"."';</script>";
           die;
    } 
   break;
       
  case 'sendEmailForm' :
  	
      
   $retrieved_nonce = '';

    if(isset($_POST['mass_email_nonce']) and $_POST['mass_email_nonce']!=''){

        $retrieved_nonce=$_POST['mass_email_nonce'];

    }
    if (!wp_verify_nonce($retrieved_nonce, 'action_mass_email_nonce' ) ){


        wp_die('Security check fail'); 
    }  
    
   $referer=$_SERVER['HTTP_REFERER'];
   if(isset($_POST['sendEmailqueue'])){
       $mass_email_queue=get_option('mass_email_queue');
       if($mass_email_queue==false){
           if(isset($_POST['ckboxs'])){
            $subscribersSelectedEmails=$_POST['ckboxs'];
            update_option('mass_email_queue',$subscribersSelectedEmails);
           }
       }
       else{
            
             $mass_email_queue=get_option('mass_email_queue');
             
              if($mass_email_queue!="" and $mass_email_queue!=null){
                  
                  $mass_email_queue=get_option('mass_email_queue');
                  if(isset($_POST['ckboxs'])){
                    $subscribersSelectedEmails=$_POST['ckboxs'];
                  }
                  else{
                      
                      $subscribersSelectedEmails='';
                  }
                    
                  $uncheckedemails=$_POST['uncheckedemails'];
                  $uncheckedemailsArr=explode('|||',$uncheckedemails);
                  
                  if(!is_array($subscribersSelectedEmails)){
                      $subscribersSelectedEmails=array();
                  }
                                                 
                  foreach($subscribersSelectedEmails as $em){
                       if(!in_array($em,$mass_email_queue)){
                          $mass_email_queue[]=$em; 
                       }
                      
                  }    
                  
                  if($uncheckedemails!="" and $uncheckedemails!=null){
                      
                      foreach($uncheckedemailsArr as $eml){
                         if($eml!="" and $eml!=null){
                             
                              $key=(int)array_search($eml,$mass_email_queue);
                              //var_dump($key).'<br/>';
                              if(array_search($eml,$mass_email_queue)>=0){
                                  
                                   unset($mass_email_queue[$key]);
                                }
                         }  
                      }               
                 }
                 update_option('mass_email_queue',$mass_email_queue); 
                 update_option( 'mass_email_succ', __( 'Email queue updated successfully.','mass-email-to-users') );
              }    
       }
      
      echo "<script>location.href='".$referer."';</script>"; 
      exit;
   }
   else if(isset($_POST['resetemailqueue'])){
       
      update_option('mass_email_queue',false); 
      update_option( 'mass_email_succ',__(  'Email queue reseted successfully.','mass-email-to-users') ); 
      $setacrionpage='admin.php?page=Mass-Email';
      $setacrionpage_reset='admin.php?page=Mass-Email';
      echo "<script>location.href='".$setacrionpage."';</script>"; 
      exit;
       
   }
   else if(isset($_POST['UnsubscribeSelected'])){
       
         global $wpdb;
         
         if ( ! current_user_can( 'wmeu_mass_email_view_unsubscribers' ) ) {

            wp_die( __( "Access Denied", "mass-email-to-users",403 ) );

         }
         
         if(isset($_POST['mass_email_nonce']) and $_POST['mass_email_nonce']!=''){

                $retrieved_nonce=$_POST['mass_email_nonce'];

        }
        if (!wp_verify_nonce($retrieved_nonce, 'action_mass_email_nonce' ) ){


            wp_die('Security check fail'); 
        }

        if(isset($_POST['ckboxs'])){
            
         $unseribers=$_POST['ckboxs'];
         
         
         foreach($unseribers as $unsub_id) {
             
             $user = get_user_by( 'email', $unsub_id );
             if($user && is_object($user) && !empty($user)){
             
                    update_user_meta( $user->ID, 'is_unsubscibed', '1');
             }
         }
         
        update_option( 'mass_email_succ', __( 'Selected users subscription updated successfully.','mass-email-to-users') );
        $referer=$_SERVER['HTTP_REFERER'];
        echo "<script>location.href='".$referer."';</script>"; 
        exit;
     }

   
       
   }
   $lastaccessto=$_SERVER['QUERY_STRING'];
   
  // parse_str($lastaccessto);
   
   if(isset($_POST['sendEmailAll'])){
   	
   	 global $wpdb;
         
         if ( ! current_user_can( 'wmeu_mass_email_send_email_to_all_users' ) ) {

            wp_die( __( "Access Denied", "mass-email-to-users",403 ) );

         }
   	 
         $query = 'SET SESSION group_concat_max_len=150000';
         $wpdb->query($query);

   	 $unscbscribersQuery="SELECT GROUP_CONCAT( user_id ) AS  `unsbscribers`
   	 FROM  $wpdb->usermeta
   	 WHERE  `meta_key` =  'is_unsubscibed' and meta_value='1'" ;
   	  
   	 $resultUnsb=$wpdb->get_results($unscbscribersQuery,'ARRAY_A');
   	 
   	 $unsubscriber_users=$resultUnsb[0]['unsbscribers'];
   	 
   	 if($unsubscriber_users=="" or $unsubscriber_users==null)
   	 	$unsubscriber_users=0;
   	 
   	 $query="SELECT user_email as emails from $wpdb->users where ID NOT IN ($unsubscriber_users)";
   	 
   	 $emails=$wpdb->get_results($query,'OBJECT');
   	 $count=0;
         $convertToString='';
   	 foreach($emails as $mail){

   	 	$convertToString.=$mail->emails.",\n";
   	 	$count++;
   	 }
   	 $convertToString=trim($convertToString,',\n');
   	
   }
   else if(isset($_POST['sendEmailFilter'])){
       
        global $wpdb;
         
         if ( ! current_user_can( 'wmeu_mass_email_send_email_to_selected_users' ) ) {

            wp_die( __( "Access Denied", "mass-email-to-users",403 ) );

         }
   	 
         
         $query = 'SET SESSION group_concat_max_len=150000';
         $wpdb->query($query);

   	 $unscbscribersQuery="SELECT GROUP_CONCAT( user_id ) AS  `unsbscribers`
   	 FROM  $wpdb->usermeta
   	 WHERE  `meta_key` =  'is_unsubscibed' and meta_value='1'" ;
   	  
   	 $resultUnsb=$wpdb->get_results($unscbscribersQuery,'ARRAY_A');
   	 
   	 $unsubscriber_users=$resultUnsb[0]['unsbscribers'];
   	 
   	 if($unsubscriber_users=="" or $unsubscriber_users==null)
   	 	$unsubscriber_users=0;
   	 
   	 $query="SELECT distinct user_email as emails from $wpdb->users u "; 
   	 
         if(isset($_POST['search_filter']) and trim($_POST['search_filter']!='')){
        
            
            parse_str($_POST['search_filter'], $get_array);
            if(is_array($get_array) and sizeof($get_array)>0){
                
                
                    $options=get_option('buddypress_fields');
                    $options_groups=get_option('buddypress_groups');
                    $selected=array();
                    $selected_grp=array();
                    $buddypress=array();
                    $grpsArr=array();
                    $mlevels=array();
                    $selectedMlevels=array();

                    if($options_groups!=false){

                        $selected_grp= json_decode($options_groups,true);

                        if(isset($selected_grp) and is_array($selected_grp) && sizeof($selected_grp)>0 && massemail_table_exists($wpdb->prefix."bp_groups_members")){

                            $query.=" left join ".$wpdb->prefix."bp_groups_members gp on gp.user_id=u.id ";


                        }
                    }

                    if($options!=false){

                        $selected= json_decode($options,true);
                        if(isset($selected) and is_array($selected) && sizeof($selected)>0){

                            $query.=" left join ".$wpdb->prefix."bp_xprofile_data upd on u.id=upd.user_id ";

                        }
                    }  


                    if(isset($get_array['mlevels']) and $get_array['mlevels']!='' and $get_array['mlevels']!='null' and $get_array['mlevels']!=NULL){

                        
                    
                      $mlevels=esc_sql(($get_array['mlevels']));
                      $selectedMlevels=$mlevels;
                      $mlevels_comma= implode(",", $selectedMlevels);
                      
                      $query.=" join ".$wpdb->prefix."swpm_members_tbl mb on u.user_email=mb.email and mb.membership_level in($mlevels_comma) ";
            

                    } 
                    
                    $query.=" join $wpdb->usermeta t on u.id=t.user_id and t.meta_key='{$wpdb->prefix}capabilities'  where u.ID NOT IN ($unsubscriber_users)";


                    if(isset($get_array['searchuser']) and $get_array['searchuser']!=''){

                      $term=esc_sql(trim($get_array['searchuser']));   
                      $query.="  and ( user_login like '%$term%' or user_nicename like '%$term%' or user_email like '%$term%' or  display_name like '%$term%'  )  " ; 



                    } 

                    if(isset($get_array['roles']) and $get_array['roles']!='' and $get_array['roles']!='null' and $get_array['roles']!=NULL){

                      $rolesArr=esc_sql(($get_array['roles']));
                      $roles=$rolesArr;
                      $selectedRoles=$rolesArr;
                      //$rolesArr=explode(",",$roles);
                      $query.="  and ( ";

                      $count=1;
                      foreach($rolesArr as $rl){

                        $query.=" t.meta_value like '%$rl%'   " ; 

                        if(is_array($rolesArr) && $count!=sizeof($rolesArr)){

                            $query.=" or ";

                        }

                        $count++;
                      }

                      $query.="  ) ";


                    } 


                    if(isset($get_array['grps']) and $get_array['grps']!='' and $get_array['grps']!='null' and $get_array['grps']!=NULL){

                      $grpsArr=esc_sql(($get_array['grps']));
                      $selectedGrps=$grpsArr;
                      //$rolesArr=explode(",",$roles);
                      $query.="  and ( ";

                      $count=1;
                      foreach($grpsArr as $rl){

                        $query.=" gp.group_id='{$rl}' " ; 

                        if(is_array($grpsArr) && $count!=sizeof($grpsArr)){

                            $query.=" or ";

                        }

                        $count++;
                      }

                      $query.="  ) ";


                    } 




                    if($options!=false){
                        $flg=0;
                        $selected= json_decode($options,true);
                        foreach($selected as $k=>$v){
                            if(isset($v['filter']) && $v['filter']==1){

                                    $field_id=$k;
                                    i13_bp_xprofile_maybe_format_datebox_post_data( $field_id );

                                    // Trim post fields.
                                    if ( isset( $get_array[ 'field_' . $field_id ] ) ) {

                                            if ( is_array( $get_array[ 'field_' . $field_id ] ) ) {

                                                    $get_array[ 'field_' . $field_id ] = array_map( 'trim', $get_array[ 'field_' . $field_id ] );
                                                    $_POST[ 'field_' . $field_id ]= array_map( 'trim', $get_array[ 'field_' . $field_id ] );

                                                     $query.="  and ( field_id=$field_id and ( ";


                                                    foreach($get_array[ 'field_' . $field_id ] as $vl){
                                                        $vl=sanitize_text_field(esc_sql($vl));
                                                        if($vl!=''){
                                                            $query.="  upd.value  like '%$vl%' or";

                                                            $flg=1;
                                                        }
                                                    }

                                                    $query=rtrim($query,'or');



                                                    $query.="  ) ) ";


                                            } else {

                                                    $get_array[ 'field_' . $field_id ] = trim( $get_array[ 'field_' . $field_id ] );
                                                    $_POST[ 'field_' . $field_id ]= trim( $get_array[ 'field_' . $field_id ] );

                                                     $vls=sanitize_text_field(esc_sql($get_array[ 'field_' . $field_id ]));
                                                     if($vls!=''){
                                                        $query.="  and ( field_id=$field_id and ( upd.value  like '%$vls%' ) ) ";

                                                        $flg=1;
                                                     }
                                            }
                                    }


                            }


                        }


                       //print_r($get_array);die;
                    }


                    
            }

         } 

         
            
         $emails=$wpdb->get_results($query,'OBJECT');
    	 $count=0;
         $convertToString='';
   	 foreach($emails as $mail){

   	 	$convertToString.=$mail->emails.",\n";
   	 	$count++;
   	 }
   	 $convertToString=trim($convertToString,',\n');
       
   }
   else{
   	
	   if(isset($_POST['sendEmailQueue'])){
	       
	       $convertToString=$_POST['queueemails'];
	        
	   }
	   else{
               
                   if ( ! current_user_can( 'wmeu_mass_email_send_email_to_selected_users' ) ) {

                        wp_die( __( "Access Denied", "mass-email-to-users",403 ) );

                      }
                    $subscribersSelectedEmails=$_POST['ckboxs'];
                    $convertToString=implode(",\n",$subscribersSelectedEmails); 
	  } 
   }
 ?>    
<h3><?php echo __( 'Send Email to Users','mass-email-to-users');?></h3>  
<?php  $url = plugin_dir_url(__FILE__);
       
       $tinymceJS=$url."ckeditorReq/";
       
       if(empty($entrant)){
           
           $entrant=1;
       }
       
       if(empty($setPerPage)){
           
           $setPerPage=30;
       }
       if(empty($searchuser)){
           
           $searchuser='';
       }
       
       
       
 ?> 
 
 
 

<form name="frmSendEmailsToUserSend" id='frmSendEmailsToUserSend' method="post" action=""> 
 <?php wp_nonce_field('action_mass_email_nonce','mass_email_nonce'); ?>    
<input type="hidden" value="sendEmailSend" name="action"> 
<input type="hidden" value="<?php echo $entrant; ?>" name="entrant"> 
<input type="hidden" value="<?php echo $setPerPage; ?>" name="setPerPage"> 
<input type="hidden" value="<?php echo $searchuser; ?>" name="searchuser"> 
<table class="form-table" style="width:100%" >
<tbody>
  
  <tr valign="top" id="subject">
     <th scope="row" style="width:30%;text-align: right;"><?php echo __( 'Load Email Template','mass-email-to-users');?></th>
     <td>    
         <select name="loadtemplate" id="loadtemplate" >
             <option value=""></option>
             <?php
              global $wpdb;
                    $query="SELECT * FROM ".$wpdb->prefix."massmail_e_template order by createdon desc";
                    $rows=$wpdb->get_results($query);
                    $rowCount=sizeof($rows);
           
                    if($rowCount > 0){
                        
                        foreach ($rows as $row){ ?>
                            
                            <option value="<?php echo $row->id;?>"><?php echo $row->subject;?></option> 
                       <?php }
                        
                    }
             ?>       
         </select>   
         <?php
            $loadingUrl=plugins_url( 'images/ajax-loader.gif', __FILE__ ) ;
            
         ?>
         <img id="imgLoader" src="<?php echo $loadingUrl;?>" style="display:none" />
         <script>

            function stripslashes(str) {
               str=str.replace(/\\'/g,'\'');
               str=str.replace(/\\"/g,'"');
               str=str.replace(/\\0/g,'\0');
               str=str.replace(/\\\\/g,'\\');
              return str;
            }

            
         </script>
      </td>
   </tr>   
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
         <?php echo __( 'you can use','mass-email-to-users');?> [username],[first_name],[last_name],[nickname],[user_email],[user_nicename],[display_name],[unsubscribe_link_plain],[unsubscribe_link_html] 
             
         
            <?php $selected=array();?>
                <?php $options=get_option('buddypress_fields');
                if($options!=false){
                    
                    $selected= json_decode($options,true);
                }
                  
                 if (function_exists('bp_is_active') && bp_is_active( 'xprofile' ) ){
                     
                    $query="SELECT * FROM ".$wpdb->prefix."bp_xprofile_groups";
                    $results=$wpdb->get_results($query,ARRAY_A);
                    
                    if(is_array($results) && sizeof($results)>0  && is_array($selected) && sizeof($selected)>0){
                        
                    ?>
                    <?php

                        foreach($results as $res){


                                ?>
                               <?php if (function_exists('bp_is_active') && bp_is_active( 'xprofile' ) ) : if ( bp_has_profile( array( 'profile_group_id' => $res['id'], 'fetch_field_data' => false ) ) ) : while ( bp_profile_groups() ) : bp_the_profile_group(); ?>

                                    <?php while ( bp_profile_fields() ) : bp_the_profile_field(); ?>
                                        <?php global $field;?>

                                      
                                                     <?php if(isset($selected[$field->id]) && isset($selected[$field->id]['list']) && $selected[$field->id]['list']==1):?>
                                                       ,[<?php bp_the_profile_field_name(); ?>]
                                                     <?php endif;?>   
                                        

                                <?php endwhile; ?>


                               <?php endwhile; endif; endif; ?>

                        <?php }
                        
                        }
                       
                        
                
                        }?>
                        
             <?php echo __( 'place holder into email content','mass-email-to-users');?>
        </div>
      </td>
   </tr>
    <tr valign="top" id="subject">
     <th scope="row" style="width:30%"></th>
     <td> 
       
       <input type='submit'  value='<?php echo __( 'Send Email','mass-email-to-users');?>' name='sendEmailsend' class='button-primary' id='sendEmailsend' >  
      </td>
   </tr>
   
</table>
</form>

<script type="text/javascript">


 jQuery(document).ready(function() {

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
                      

  });
 
 
 jQuery(document).ready(function() {
            
          // tinymce.on('addeditor', function( event ) {
               
              jQuery( "#loadtemplate" ).change(function() {
                
               
                 var data = {
                                'action': 'getEmailTemplate_massmail',
                                'templateId':jQuery( "#loadtemplate" ).val() 
                        };

                      if(jQuery( "#loadtemplate" ).val()!=''){
                        
                        jQuery("#imgLoader").show();
                        jQuery("#txtArea-tmce").trigger('click');
                        setTimeout(function(){ 
                                jQuery.ajax({
                                   type: "GET",
                                   dataType: "json",
                                   url: ajaxurl, 
                                   data: data,
                                   success: function(response) {


                                      obj = jQuery.parseJSON(JSON.stringify(response));
                                      decoded_sub = jQuery("<div/>").html(obj.subject).text();
                                      decoded_email_from_name = jQuery("<div/>").html(obj.email_from_name).text();

                                       jQuery("#email_subject").val(decoded_sub);
                                       jQuery("#email_From_name").val(decoded_email_from_name);

                                       jQuery("#email_From").val(obj.email_from);

                                       var decoded = stripslashes(jQuery('<div/>').html(obj.content).text());
                                       jQuery( "#txtArea-html" ).trigger( "click" );
                                       jQuery(".wp-editor-area").val(obj.content);
                                     
                                     //  tinyMCE.activeEditor.setContent(decoded);
                                      // jQuery( "#txtArea-html" ).trigger( "click" );
                                      // jQuery('#txtArea').html(decoded);
                                       jQuery( "#txtArea-tmce" ).trigger( "click" );

                                     //  CKEDITOR.instances['txtArea'].setData(decoded);

                                       jQuery("#imgLoader").hide();

                                   }
                                 });
                      
                              }, 1000);
                         
                     }
                     else{
                         
                          jQuery("#email_subject").val('');
                          jQuery("#email_From_name").val('');
                          jQuery("#email_From").val('');
                          jQuery("#email_From").val('');
                          jQuery("#txtArea").val('');
                     }
            
                });
            
              //}, true );
        }); 
        
 </script> 
 <?php 
  break;
  default: 
       $url=plugin_dir_url(__FILE__);
         
  ?>       
     <div style="width: 100%;">  
        <div style="float:left;" >
            <style>
                .chosen-container{width: 240px !important;height: 36px}
                .option-label{margin-right: 5px}
            </style>                                                                        
  
  
<?php       
    global $wpdb;
    
    
     if ( ! current_user_can( 'wmeu_mass_email_view_users_to_send_mass_email' ) ) {

        wp_die( __( "Access Denied", "mass-email-to-users",403 ) );

     }

     $wpcurrentdir=dirname(__FILE__);
     $wpcurrentdir=str_replace("\\","/",$wpcurrentdir);
    
     $group_concate_max='100000000';
     
     $query='SET SESSION group_concat_max_len = 1000000';
     $wpdb->query($query);
     
     $unscbscribersQuery="SELECT GROUP_CONCAT( user_id ) AS  `unsbscribers` 
                            FROM  $wpdb->usermeta 
                            WHERE  `meta_key` =  'is_unsubscibed' and meta_value='1'" ;
                                   
    $resultUnsb=$wpdb->get_results($unscbscribersQuery,'ARRAY_A');
    
    $unsubscriber_users=$resultUnsb[0]['unsbscribers'];
    
    if($unsubscriber_users=="" or $unsubscriber_users==null)
     $unsubscriber_users=0;
    
    
                            
    $query="SELECT distinct u.ID,user_email from $wpdb->users u "; 
    $queryCount="SELECT count(distinct u.ID) from $wpdb->users u ";
    
    $options=get_option('buddypress_fields');
    $options_groups=get_option('buddypress_groups');
    $selected=array();
    $selected_grp=array();
    $buddypress=array();
    $grpsArr=array();
    $mlevels=array();
    $selectedMlevels=array();
    
    if(isset($_GET['mlevels']) and $_GET['mlevels']!='' and $_GET['mlevels']!='null' and $_GET['mlevels']!=NULL){
          
        $selectedMlevels=esc_sql(($_GET['mlevels']));
        $mlevels_comma= implode(",", $selectedMlevels);
        
        $query.=" join ".$wpdb->prefix."swpm_members_tbl mb on u.user_email=mb.email and mb.membership_level in($mlevels_comma) ";
        $queryCount.=" join ".$wpdb->prefix."swpm_members_tbl mb on u.user_email=mb.email and mb.membership_level in($mlevels_comma) ";

     }
     
    if($options_groups!=false){
        
        $selected_grp= json_decode($options_groups,true);
        
        if(isset($selected_grp) and is_array($selected_grp) && sizeof($selected_grp)>0 && massemail_table_exists($wpdb->prefix."bp_groups_members")){
            
            $query.=" left join ".$wpdb->prefix."bp_groups_members gp on gp.user_id=u.id ";
            $queryCount.=" left join ".$wpdb->prefix."bp_groups_members gp on gp.user_id=u.id ";
            
        }
    }
    
    if($options!=false){

        $selected= json_decode($options,true);
        if(isset($selected) and is_array($selected) && sizeof($selected)>0){
            
            $query.=" left join ".$wpdb->prefix."bp_xprofile_data upd on u.id=upd.user_id ";
            $queryCount.=" left join ".$wpdb->prefix."bp_xprofile_data upd on u.id=upd.user_id ";
        }
    }  
   
    
    $query.=" join $wpdb->usermeta t on u.id=t.user_id and t.meta_key='{$wpdb->prefix}capabilities'  where u.ID NOT IN ($unsubscriber_users)";
    $queryCount.=" join $wpdb->usermeta t on u.id=t.user_id and t.meta_key='{$wpdb->prefix}capabilities' where u.ID NOT IN ($unsubscriber_users)";
     
    if(isset($_GET['searchuser']) and $_GET['searchuser']!=''){
        
      $term=esc_sql(trim($_GET['searchuser']));   
      $query.="  and ( user_login like '%$term%' or user_nicename like '%$term%' or user_email like '%$term%' or  display_name like '%$term%'  )  " ; 
      $queryCount.="  and ( user_login like '%$term%' or user_nicename like '%$term%' or user_email like '%$term%' or  display_name like '%$term%'  )  " ; 
      
      
    } 
    
    if(isset($_GET['roles']) and $_GET['roles']!='' and $_GET['roles']!='null' and $_GET['roles']!=NULL){
        
      $rolesArr=esc_sql(($_GET['roles']));
      $roles=$rolesArr;
      $selectedRoles=$rolesArr;
      //$rolesArr=explode(",",$roles);
      $query.="  and ( ";
      $queryCount.="  and ( ";
      $count=1;
      foreach($rolesArr as $rl){
          
        $query.=" t.meta_value like '%$rl%'   " ; 
        $queryCount.=" t.meta_value like '%$rl%'   " ; 
        if(is_array($rolesArr) && $count!=sizeof($rolesArr)){
            
            $query.=" or ";
            $queryCount.=" or ";
        }
        
        $count++;
      }
      
      $query.="  ) ";
      $queryCount.="  ) ";
      
    } 
    
    
    if(isset($_GET['grps']) and $_GET['grps']!='' and $_GET['grps']!='null' and $_GET['grps']!=NULL){
        
      $grpsArr=esc_sql(($_GET['grps']));
      $selectedGrps=$grpsArr;
      //$rolesArr=explode(",",$roles);
      $query.="  and ( ";
      $queryCount.="  and ( ";
      $count=1;
      foreach($grpsArr as $rl){
          
        $query.=" gp.group_id='{$rl}' " ; 
        $queryCount.=" gp.group_id='{$rl}'   " ; 
        if(is_array($grpsArr) && $count!=sizeof($grpsArr)){
            
            $query.=" or ";
            $queryCount.=" or ";
        }
        
        $count++;
      }
      
      $query.="  ) ";
      $queryCount.="  ) ";
      
    } 
    
    
    
    
    if($options!=false){
        $flg=0;
        $selected= json_decode($options,true);
        foreach($selected as $k=>$v){
            if(isset($v['filter']) && $v['filter']==1){
                
                    $field_id=$k;
                    i13_bp_xprofile_maybe_format_datebox_post_data( $field_id );

                    // Trim post fields.
                    if ( isset( $_GET[ 'field_' . $field_id ] ) ) {
                           
                            if ( is_array( $_GET[ 'field_' . $field_id ] ) ) {
                                    
                                    $_GET[ 'field_' . $field_id ] = array_map( 'trim', $_GET[ 'field_' . $field_id ] );
                                    $_POST[ 'field_' . $field_id ]= array_map( 'trim', $_GET[ 'field_' . $field_id ] );
                                    
                                     $query.="  and ( field_id=$field_id and ( ";
                                     $queryCount.="  and ( field_id=$field_id and ( ";
                                   
                                    foreach($_GET[ 'field_' . $field_id ] as $vl){
                                        $vl=sanitize_text_field(esc_sql($vl));
                                        if($vl!=''){
                                            $query.="  upd.value  like '%$vl%' or";
                                            $queryCount.=" upd.value like '%$vl%' or"; 
                                            $flg=1;
                                        }
                                    }
                                    
                                    $query=rtrim($query,'or');
                                    $queryCount=rtrim($query,'or');
                                    
                                    
                                    $query.="  ) ) ";
                                     $queryCount.="   ) ) ";
                                    
                            } else {
                                
                                    $_GET[ 'field_' . $field_id ] = trim( $_GET[ 'field_' . $field_id ] );
                                    $_POST[ 'field_' . $field_id ]= trim( $_GET[ 'field_' . $field_id ] );
                                   
                                     $vls=sanitize_text_field(esc_sql($_GET[ 'field_' . $field_id ]));
                                     if($vls!=''){
                                        $query.="  and ( field_id=$field_id and ( upd.value  like '%$vls%' ) ) ";
                                        $queryCount.=" and ( field_id=$field_id and ( upd.value  like '%$vls%' ) ) ";
                                        $flg=1;
                                     }
                            }
                    }

                
            }
           
            
        }
        
      
       //print_r($_GET);die;
    }
    
    
     
     $rows_per_page = 30;
    if(isset($_GET['setPerPage']) and $_GET['setPerPage']!=""){
        
       $rows_per_page=intval($_GET['setPerPage']);
    } 
    
    
    
    $totalRecordForQuery=$wpdb->get_var($queryCount);  
    $selfPage=$_SERVER['PHP_SELF'].'?page=Mass-Email'; 
   
    $current = (isset($_GET['entrant'])) ? (intval($_GET['entrant'])) : 1;
    $pagination_args = array(
        'base' => @add_query_arg('entrant','%#%'),
        'format' => '',
        'total' => ceil($totalRecordForQuery/$rows_per_page),
        'current' => $current,
        'show_all' => false,
        'type' => 'plain',
    );
                
    $selfpage=$_SERVER['PHP_SELF'];
        
    if($totalRecordForQuery>0){
        
             
     $selected=array();
     $options=get_option('buddypress_fields');
     if($options!=false){

            $selected= json_decode($options,true);
     }

                         
          
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
                
                   $order_by='user_login';
                   $order_pos="asc";
                   $roles_sel='';
                   
                    $setacrionpage='admin.php?page=Mass-Email&';
                    $setacrionpage_reset='admin.php?page=Mass-Email';
                    $getVal=$_GET;
                    $FilterVal=$_GET;
                    if(isset($FilterVal['page'])){
                        unset($FilterVal['page']);
                    }
                    if(isset($FilterVal['setPerPage'])){
                        unset($FilterVal['setPerPage']);
                    }
                    if(isset($FilterVal['searchusrsubmit'])){
                        unset($FilterVal['searchusrsubmit']);
                    }
                    foreach($getVal as $k=>$val){
                        
                        if($k=='page' && $k=='order_by' && $k=='order_pos'){
                           unset($getVal[$k]);
                        }
                    }
                    $setacrionpage.=http_build_query($getVal);
                    
                    if(isset($_GET['entrant']) and $_GET['entrant']!=""){
                     $setacrionpage.='&entrant='.$_GET['entrant'];   
                    }
                
                    if(isset($_GET['setPerPage']) and $_GET['setPerPage']!=""){
        
                        $rows_per_page=intval($_GET['setPerPage']);
                     } 

                    if(isset($_GET['setPerPage']) and $_GET['setPerPage']!=""){
                     $setacrionpage.='&setPerPage='.$_GET['setPerPage'];   
                    }
                    
                    $seval="";
                    if(isset($_GET['searchuser']) and $_GET['searchuser']!=""){
                     $seval=trim($_GET['searchuser']);   
                    }
                    
                    $search_term_='';
                    if(isset($_GET['searchuser'])){

                       $search_term_='&searchuser='.urlencode(sanitize_text_field($_GET['searchuser']));
                    }

                    if(isset($_GET['order_by'])){

                       $order_by=trim($_GET['order_by']); 
                    }

                    if(isset($_GET['order_pos'])){

                       $order_pos=trim($_GET['order_pos']); 
                    }
                   
                    $roles=i13_mass_email_get_editable_roles();
                    $UGroups=i13_mass_email_get_buddypress_groups();
                    
                    $flag_membership=false;
                                       
                ?>
                <style>
                    fieldset.scheduler-border {
                        border: 1px solid #ccc !important;
                        padding: 0 1.4em 1.4em 1.4em !important;
                        margin: 0 0 1.5em 0 !important;
                        -webkit-box-shadow:  0px 0px 0px 0px #000;
                                box-shadow:  0px 0px 0px 0px #000;
                    }

                    legend.scheduler-border {
                        font-size: 1.2em !important;
                        font-weight: bold !important;
                        text-align: left !important;
                    }
                  

                </style>
              
                    <div style="padding-top:5px;padding-bottom:5px">
                         
                            <fieldset class="scheduler-border">
                                <legend style="width:auto" class="scheduler-border" >Filter</legend>

                              <form method="get" action="<?php echo $setacrionpage; ?>">     
                                  <table cellpadding="5" cellspacing="5" class="mytbl">
                                    <tr>
                                        <td>
                                            <b><?php echo __( 'Search User','mass-email-to-users');?> : </b>
                                        </td>
                                        <td>
                                            <input type="text" value="<?php echo $seval;?>" id="searchuser" name="searchuser">&nbsp;
                                        </td>
                                         <td>
                                            <b><?php echo __( 'Role(s)','mass-email-to-users');?> : </b>
                                        </td>
                                        <td>
                                            <select data-placeholder="<?php echo __('All Roles','mass-email-to-users');?>" multiple=""  name="roles[]" id="roles" style="vertical-align:baseline"><?php foreach($roles as $k=>$role):?><option <?php if(in_array($k, $selectedRoles)):?> selected="" <?php endif;?> value="<?php echo $k;?>"><?php echo $role['name'];?></option> <?php endforeach;?></select>&nbsp;
                                        </td>
                                        <?php if( function_exists('bp_is_active') && isset($selected_grp['filter']) and $selected_grp['filter']==1 && massemail_table_exists($wpdb->prefix."bp_groups_members")):?>
                                            <td>
                                               <b><?php echo __( 'BuddyPress Groups','mass-email-to-users');?> : </b>
                                           </td>
                                           <td>
                                               <select data-placeholder="<?php echo __('All Groups','mass-email-to-users');?>" multiple=""  name="grps[]" id="grps" style="vertical-align:baseline"><?php foreach($UGroups as $g=>$gpr):?><option <?php if(in_array($gpr['id'], $grpsArr)):?> selected="" <?php endif;?> value="<?php echo $gpr['id'];?>"><?php echo $gpr['name'];?></option> <?php endforeach;?></select>&nbsp;
                                           </td>
                                        <?php else:?>
                                            <?php if(i13_mass_email_check_simple_membership_plugin_active() && sizeof(i13_mass_email_check_simple_membership_get_levels())>0):?>
                                                <?php  $flag_membership=true; ?>
                                                <?php $Mlevels=i13_mass_email_check_simple_membership_get_levels();?>
                                                <td>
                                                     <b><?php echo __( 'Membership Level(s)','mass-email-to-users');?> : </b>
                                                 </td>
                                                 <td>
                                                     <select data-placeholder="<?php echo __('All Membership Levels','mass-email-to-users');?>" multiple=""  name="mlevels[]" id="mlevels" style="vertical-align:baseline"><?php foreach($Mlevels as $l=>$lvl):?><option <?php if(in_array($l, $selectedMlevels)):?> selected="" <?php endif;?> value="<?php echo $l;?>"><?php echo $lvl;?></option> <?php endforeach;?></select>&nbsp;
                                                 </td>
                                            <?php endif;?>
                                        <?php endif;?>
                                    </tr>
                                  <?php $cnt=0;?>  
                                    
                                    <?php
                                        
                                        global $wpdb; 
                                        if (function_exists('bp_is_active') && bp_is_active( 'xprofile' ) ){

                                           $query_pg="SELECT * FROM ".$wpdb->prefix."bp_xprofile_groups";
                                           $results_pg=$wpdb->get_results($query_pg,ARRAY_A);
                                           
                                           if(is_array($results_pg) and sizeof($results_pg)>0){ ?>

                                                <tr>
                                                    <?php if(!$flag_membership && i13_mass_email_check_simple_membership_plugin_active() && sizeof(i13_mass_email_check_simple_membership_get_levels())>0):?>
                                                        <?php $cnt=1; $flag_membership=true; ?>
                                                        <?php $Mlevels=i13_mass_email_check_simple_membership_get_levels();?>
                                                        <td>
                                                             <b><?php echo __( 'Membership Level(s)','mass-email-to-users');?> : </b>
                                                         </td>
                                                         <td>
                                                             <select data-placeholder="<?php echo __('All Membership Levels','mass-email-to-users');?>" multiple=""  name="mlevels[]" id="mlevels" style="vertical-align:baseline"><?php foreach($Mlevels as $l=>$lvl):?><option <?php if(in_array($l, $selectedMlevels)):?> selected="" <?php endif;?> value="<?php echo $l;?>"><?php echo $lvl;?></option> <?php endforeach;?></select>&nbsp;
                                                         </td>
                                                    <?php endif;?>
                                               <?php foreach($results_pg as $respg){ ?>
                                    
                                                        <?php if ( function_exists('bp_is_active') && bp_is_active( 'xprofile' ) ) : if ( bp_has_profile( array( 'profile_group_id' => $respg['id'], 'fetch_field_data' => false ) ) ) : while ( bp_profile_groups() ) : bp_the_profile_group(); ?>
                                                              

                                                              <?php while ( bp_profile_fields() ) : bp_the_profile_field(); ?>


                                                                              <?php global $field;?>

                                                                                <?php if(isset($selected[$field->id]) && isset($selected[$field->id]['filter']) && $selected[$field->id]['filter']==1):?>

                                                                                      <?php $cnt++;?>  
                                                                                      <?php if ( 'textbox' == bp_get_the_profile_field_type() ) : ?>

                                                                                              <td>
                                                                                                  <b><?php bp_the_profile_field_name();?> : </b>

                                                                                              </td>

                                                                                              <td>
                                                                                                  <input type="text" name="<?php bp_the_profile_field_input_name(); ?>" id="<?php bp_the_profile_field_input_name(); ?>" value="<?php bp_the_profile_field_edit_value(); ?>" />
                                                                                              </td>    

                                                                                      <?php endif; ?>

                                                                                      <?php if ( 'textarea' == bp_get_the_profile_field_type() ) : ?>

                                                                                              <td>
                                                                                                  <b><?php bp_the_profile_field_name();?> : </b>
                                                                                              </td>

                                                                                              <td>
                                                                                                  <textarea rows="5" cols="40" name="<?php bp_the_profile_field_input_name(); ?>" id="<?php bp_the_profile_field_input_name(); ?>"><?php bp_the_profile_field_edit_value(); ?></textarea>
                                                                                              </td>    

                                                                                      <?php endif; ?>

                                                                                      <?php if ( 'selectbox' == bp_get_the_profile_field_type() ) : ?>

                                                                                              <td>
                                                                                                  <b><?php bp_the_profile_field_name();?> : </b>
                                                                                              </td>
                                                                                              <td>
                                                                                                  <select name="<?php bp_the_profile_field_input_name(); ?>" id="<?php bp_the_profile_field_input_name(); ?>">
                                                                                                          <?php bp_the_profile_field_options(); ?>
                                                                                                  </select>
                                                                                              </td>    

                                                                                      <?php endif; ?>

                                                                                      <?php if ( 'multiselectbox' == bp_get_the_profile_field_type() ) : ?>

                                                                                              <td>
                                                                                                  <b><?php bp_the_profile_field_name();?> : </b>
                                                                                              </td>
                                                                                              <td>
                                                                                                  <?php
                                                                                                  ob_start();
                                                                                                  bp_the_profile_field_input_name();
                                                                                                  $fieldname = ob_get_clean();

                                                                                                  ?>
                                                                                                  <select name="<?php echo $fieldname; ?>[]" id="<?php echo $fieldname; ?>" multiple="multiple">
                                                                                                          <?php bp_the_profile_field_options(); ?>
                                                                                                  </select>
                                                                                                  <script>
                                                                                                      
                                                                                                       jQuery(document).ready(function() {
                                                                                                         <?php if(isset($_POST[$fieldname]) && is_array($_POST[$fieldname])): ?>
                                                                                                                 <?php foreach($_POST[$fieldname] as $kr => $rr):?>
                                                                                                                     jQuery('#<?php echo $fieldname;?> option[value="<?php echo $rr;?>"]').attr("selected", "selected");
                                                                                                                 <?php endforeach;?>    
                                                                                                         <?php endif;?>        
                                                                                                       })

                                                                                                  </script>
                                                                                              </td>    

                                                                                      <?php endif; ?>

                                                                                      <?php if ( 'radio' == bp_get_the_profile_field_type() ) : ?>

                                                                                               <td>
                                                                                                 <b><?php bp_the_profile_field_name();?> : </b>
                                                                                              </td>
                                                                                              <td>
                                                                                                  <?php bp_the_profile_field_options(); ?>

                                                                                              </td>  


                                                                                      <?php endif; ?>
                                                                                      <?php if ( 'checkbox' == bp_get_the_profile_field_type() ) : ?>

                                                                                               <td>
                                                                                                 <b><?php echo bp_the_profile_field_name();?> : </b>
                                                                                              </td>
                                                                                              <td>
                                                                                                  <?php bp_the_profile_field_options(); ?>
                                                                                              </td>


                                                                                      <?php endif; ?>


                                                                                      <?php if ( 'datebox' == bp_get_the_profile_field_type() ) : ?>

                                                                                               <td>
                                                                                                  <b><?php bp_the_profile_field_name();?> : </b>
                                                                                              </td>
                                                                                              <td>
                                                                                                  <div class="datebox">

                                                                                                          <?php do_action( bp_get_the_profile_field_errors_action() ); ?>

                                                                                                          <select name="<?php bp_the_profile_field_input_name(); ?>_day" id="<?php bp_the_profile_field_input_name(); ?>_day">
                                                                                                                  <?php bp_the_profile_field_options( 'type=day' ); ?>
                                                                                                          </select>

                                                                                                          <select name="<?php bp_the_profile_field_input_name(); ?>_month" id="<?php bp_the_profile_field_input_name(); ?>_month">
                                                                                                                  <?php bp_the_profile_field_options( 'type=month' ); ?>
                                                                                                          </select>

                                                                                                          <select name="<?php bp_the_profile_field_input_name(); ?>_year" id="<?php bp_the_profile_field_input_name(); ?>_year">
                                                                                                                  <?php bp_the_profile_field_options( 'type=year' ); ?>
                                                                                                          </select>
                                                                                                  </div>
                                                                                              </td>    
                                                                                      <?php endif; ?>

                                                                                      <?php if ( 'url' == bp_get_the_profile_field_type() ) : ?>


                                                                                               <td>
                                                                                                  <b><?php bp_the_profile_field_name();?> : </b>
                                                                                               </td>
                                                                                               <td>
                                                                                                  <input type="text" name="<?php bp_the_profile_field_input_name(); ?>" id="<?php bp_the_profile_field_input_name(); ?>" value="<?php bp_the_profile_field_edit_value(); ?>" <?php if ( bp_get_the_profile_field_is_required() ) : ?>aria-required="true"<?php endif; ?>/>
                                                                                              </td>
                                                                                      <?php endif; ?>
                                                                                   
                                                                                   <?php if($cnt==3):?>
                                                                                    </tr><tr>  
                                                                                    <?php $cnt=0;?>    
                                                                                   <?php endif;?>   
                                                                        <?php endif;?>              


                                                              <?php endwhile; ?>


                                                           <?php endwhile; endif; endif; ?>
                                               <?php }
                                               
                                           }
                                           
                                        }
                                        ?>
                                      <?php if(!$flag_membership && i13_mass_email_check_simple_membership_plugin_active() && sizeof(i13_mass_email_check_simple_membership_get_levels())>0):?>
                                            <?php $flag_membership=true; ?>
                                            <?php $Mlevels=i13_mass_email_check_simple_membership_get_levels();?>
                                             <tr>                                            
                                                <td>
                                                     <b><?php echo __( 'Membership Level(s)','mass-email-to-users');?> : </b>
                                                 </td>
                                                 <td>
                                                     <select data-placeholder="<?php echo __('All Membership Levels','mass-email-to-users');?>" multiple=""  name="mlevels[]" id="mlevels" style="vertical-align:baseline"><?php foreach($Mlevels as $l=>$lvl):?><option <?php if(in_array($l, $selectedMlevels)):?> selected="" <?php endif;?> value="<?php echo $l;?>"><?php echo $lvl;?></option> <?php endforeach;?></select>&nbsp;
                                                 </td>
                                             </tr>   
                                        <?php endif;?>                                                  
                                     <?php if($cnt>=2):?>                             
                                        <tr>
                                            <td>
                                                &nbsp;
                                            </td>
                                            <td>
                                                &nbsp;
                                            </td>
                                            <td>
                                                &nbsp;
                                            </td>
                                            <td>
                                                   
                                                <input type="hidden" value="<?php echo $rows_per_page;?>" name="setPerPage" id="setPerPage">
                                            
                                                <input type='hidden'  value='Mass-Email' name='page' >
                                                <input type='submit'  value='<?php echo __( 'Search User','mass-email-to-users');?>' name='searchusrsubmit' class='button-primary' id='searchusrsubmit'  >&nbsp;<input type='button'  value='<?php echo __( 'Reset Search','mass-email-to-users');?>' name='searchreset' class='button-primary' id='searchreset' onclick="ResetSearch();" >
                                            </td>

                                        </tr>
                                     <?php else:?>

                                        <td>
                                                &nbsp;
                                            </td>
                                            <td>
                                                 
                                                <input type="hidden" value="<?php echo $rows_per_page;?>" name="setPerPage" id="setPerPage">
                                          
                                                <input type='hidden'  value='Mass-Email' name='page' >
                                                <input type='submit'  value='<?php echo __( 'Search User','mass-email-to-users');?>' name='searchusrsubmit' class='button-primary' id='searchusrsubmit' onclick="SearchredirectTO();" >&nbsp;<input type='button'  value='<?php echo __( 'Reset Search','mass-email-to-users');?>' name='searchreset' class='button-primary' id='searchreset' onclick="ResetSearch();" >
                                            </td>

                                        </tr>

                                     <?php endif;?>   

                                </table>
                            </form>   
                    </fieldset>
                  
                <script type="text/javascript" >
                 function SearchredirectTO(){
                   var redirectto='<?php echo $setacrionpage; ?>';
                   var searchval=jQuery('#searchuser').val();
                   roles = jQuery('#roles').val(); 

                   redirectto=redirectto+'&searchuser='+jQuery.trim(searchval)+'&roles='+roles;    
                   window.location.href=redirectto;
                 }
                function ResetSearch(){
                    
                     var redirectto='<?php echo $setacrionpage_reset; ?>';
                     window.location.href=redirectto;
                }

                jQuery(function () {
                    jQuery("#roles").chosen();
                    jQuery("#grps").chosen();
                    if(jQuery("#mlevels").length>0){
                        
                        jQuery("#mlevels").chosen();
                        
                    }
                });

                </script>
               <form method="post" action="" id="sendemail" name="sendemail">
                
                <?php wp_nonce_field('action_mass_email_nonce','mass_email_nonce'); ?>    
                <input type="hidden" value="sendEmailForm" name="action" id="action">
                <input type="hidden" value="<?php echo http_build_query($FilterVal);?>" name="search_filter" id="search_filter">
                <input type="hidden" value="<?php echo $roles_sel;?>" name="search_role" id="search_role">
                
              <table class="widefat fixed" cellspacing="0" style="width:100% !important" >
                <thead>
                <tr>
                    
                       <?php if($order_by=="user_email" and $order_pos=="asc"):?>
                        
                            <th>
                                <input onclick="chkAll(this)" type="checkbox" name="chkallHeader" id='chkallHeader'>&nbsp;
                                <a href="<?php echo $setacrionpage;?>&order_by=user_email&order_pos=desc<?php echo $search_term_;?>"><?php echo __('Email','mass-email-to-users');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/desc.png', __FILE__); ?>"/></a>
                            </th>
                       <?php else:?>
                           <?php if($order_by=="user_email"):?>
                                <th>
                                    <input onclick="chkAll(this)" type="checkbox" name="chkallHeader" id='chkallHeader'>&nbsp;
                                    <a href="<?php echo $setacrionpage;?>&order_by=user_email&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Email','mass-email-to-users');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/asc.png', __FILE__); ?>"/></a>
                                </th>
                           <?php else:?>
                               <th>
                                   <input onclick="chkAll(this)" type="checkbox" name="chkallHeader" id='chkallHeader'>&nbsp;
                                   <a href="<?php echo $setacrionpage;?>&order_by=user_email&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Email','mass-email-to-users');?></a>
                               </th>
                           <?php endif;?>    
                       <?php endif;?> 
                        
                        <?php if($order_by=="user_login" and $order_pos=="asc"):?>
                            <th><a href="<?php echo $setacrionpage;?>&order_by=user_login&order_pos=desc<?php echo $search_term_;?>"><?php echo __('Username','mass-email-to-users');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/desc.png', __FILE__); ?>"/></a></th>
                       <?php else:?>
                           <?php if($order_by=="user_login"):?>
                                <th><a href="<?php echo $setacrionpage;?>&order_by=user_login&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Username','mass-email-to-users');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/asc.png', __FILE__); ?>"/></a></th>
                           <?php else:?>
                               <th><a href="<?php echo $setacrionpage;?>&order_by=user_login&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Username','mass-email-to-users');?></a></th>
                           <?php endif;?>    
                       <?php endif;?> 
                        <th><?php echo __('Name','mass-email-to-users');?></th>
                        <th><?php echo __('Role(s)','mass-email-to-users');?></th>
                        
                         <?php if( function_exists('bp_is_active') && isset($selected_grp['list']) and $selected_grp['list']==1 && massemail_table_exists($wpdb->prefix."bp_groups_members")):?>
                            <th><?php echo __('User Group(s)','mass-email-to-users');?></th> 
                         <?php endif;?>
                             <?php $selected=array();?>
                            <?php $options=get_option('buddypress_fields');
                            if($options!=false){

                                $selected= json_decode($options,true);
                            }

                            global $wpdb; 
                            if (function_exists('bp_is_active') && bp_is_active( 'xprofile' ) ){

                               $query_pg="SELECT * FROM ".$wpdb->prefix."bp_xprofile_groups";
                               $results_pg=$wpdb->get_results($query_pg,ARRAY_A);

                               if(is_array($results_pg) and sizeof($results_pg)>0){


                                   foreach($results_pg as $respg){ ?>
                                       <?php if (function_exists('bp_is_active') && bp_is_active( 'xprofile' ) ) : if ( bp_has_profile( array( 'profile_group_id' => $respg['id'], 'fetch_field_data' => false ) ) ) : while ( bp_profile_groups() ) : bp_the_profile_group(); ?>

                                            <?php while ( bp_profile_fields() ) : bp_the_profile_field(); ?>
                                                <?php global $field;?>

                                                    <?php if(isset($selected[$field->id]) && isset($selected[$field->id]['list']) && $selected[$field->id]['list']==1):?>
                                                     <th scope="col" id="name" class="manage-column column-name">
                                                       <?php bp_the_profile_field_name(); ?>
                                                     </th>
                                                     <?php endif;?>


                                        <?php endwhile; ?>


                                       <?php endwhile; endif; endif; ?>
                                   <?php }
                               }
                            }
                            ?>
                </tr>
                </thead>

              

                <tbody id="the-list" class="list:cat">
               <?php             
               
               
                    $offset = ($current - 1) * $rows_per_page;
                    $order_by=sanitize_text_field(sanitize_sql_orderby($order_by));
                    $order_pos=sanitize_text_field(sanitize_sql_orderby($order_pos));

                    $query.=" order by $order_by $order_pos";
                    $query.=" limit $offset, $rows_per_page";
                   
                    $emails=$wpdb->get_results($query,'ARRAY_A');   


                    $mass_email_queue=array();               
                    if(get_option('mass_email_queue')!=false and is_array(get_option('mass_email_queue')))
                      $mass_email_queue=get_option('mass_email_queue');
                                            
                    foreach($emails as $em)
                     {
                        
                         
                           
                           $userId=$em['ID'];
                           $user_info = get_userdata($userId); 
                           $user_roles = $user_info->roles;
                           
                           if(in_array($em['user_email'],$mass_email_queue)) 
                                $checked="checked='checked'";
                           else
                             $checked="";
                                 
                           echo"<tr class='iedit alternate'>
                            <td  class='name column-name' style='border:1px solid #DBDBDB;padding-left:13px;'><input type='checkBox' name='ckboxs[]'".$checked."  value='".$em['user_email']."'>&nbsp;".$em['user_email']."</td>";
                            echo "<td  class='name column-name' style='border:1px solid #DBDBDB;'> ".$user_info->user_login."</td>";
                            echo "<td  class='name column-name' style='border:1px solid #DBDBDB;'> ".$user_info->user_firstname.' '.$user_info->user_lastname."</td>";
                            echo "<td  class='name column-name' style='border:1px solid #DBDBDB;'> ";
                            $role_str='';
                            foreach($user_roles as $r){
                                
                                $role_str.= $r.',';
                            }
                            echo trim($role_str,',');
                            echo "</td>";
                            ?>
                    
                            <?php if( function_exists('bp_is_active') && isset($selected_grp['list']) and $selected_grp['list']==1 && massemail_table_exists($wpdb->prefix."bp_groups_members")):?>
                                <td class='name column-name' style='border:1px solid #DBDBDB;'>
                                    
                                    <?php
                                        
                                        $query_gp="SELECT GROUP_CONCAT(gr.name) as grps,is_admin FROM ".$wpdb->prefix."bp_groups gr join ".$wpdb->prefix."bp_groups_members gm on gr.id=gm.group_id where user_id='$userId'";
                                        $results_gp=$wpdb->get_row($query_gp,ARRAY_A);
                                        if(is_array($results_gp) and sizeof($results_gp)>0):?>
                                            <?php echo $results_gp['grps'];?>
                                        <?php endif;?>
                                    
                               </td>
                               
                            <?php endif;?>
                            <?php
                             global $wpdb; 
                                        if (function_exists('bp_is_active') && bp_is_active( 'xprofile' ) ){

                                           $query_pg="SELECT * FROM ".$wpdb->prefix."bp_xprofile_groups";
                                           $results_pg=$wpdb->get_results($query_pg,ARRAY_A);
                                           
                                           if(is_array($results_pg) and sizeof($results_pg)>0){


                                               foreach($results_pg as $respg){ ?>
                    
                                                    <?php if (function_exists('bp_is_active') && bp_is_active( 'xprofile' ) ) : if ( bp_has_profile( array( 'profile_group_id' => $respg['id'], 'fetch_field_data' => false ) ) ) : while ( bp_profile_groups() ) : bp_the_profile_group(); ?>

                                                       <?php while ( bp_profile_fields() ) : bp_the_profile_field(); ?>
                                                           <?php global $field;?>

                                                               <?php if(isset($selected[$field->id]) && isset($selected[$field->id]['list']) && $selected[$field->id]['list']==1):?>
                                                                <td class='name column-name' style='border:1px solid #DBDBDB;'>
                                                                  <?php echo i13_format_xprofile_field_for_display(xprofile_get_field_data($field->id,$userId)); ?>
                                                                </td>
                                                                <?php endif;?>


                                                   <?php endwhile; ?>


                                                  <?php endwhile; endif; endif; ?>
                                               <?php }
                                           }
                                        }
                                        ?>
                                         
                           <?php echo "</tr>";
                           
                           
                     }
                       
                   ?>  
                 </tbody>       
                </table>
                 <table>
                  <tr>
                    <td>
                      <?php
                       if($totalRecordForQuery>0){
                         echo "<div class='pagination' style='padding-top:10px'>";
                         echo paginate_links($pagination_args);
                         echo "</div>";
                        }
                        
                       ?>
                
                    </td>
                    <td>
                      <b>&nbsp;&nbsp;<?php echo __( 'Per Page','mass-email-to-users');?> : </b>
                      <?php
                        $setacrionpage.='&setPerPage=';
                      ?>
                      <select name="setPerPage" onchange="document.location.href='<?php echo $setacrionpage;?>' + this.options[this.selectedIndex].value + ''">
                        <option <?php if($rows_per_page=="10"): ?>selected="selected"<?php endif;?>  value="10">10</option>
                        <option <?php if($rows_per_page=="20"): ?>selected="selected"<?php endif;?> value="20">20</option>
                        <option <?php if($rows_per_page=="30"): ?>selected="selected"<?php endif;?>value="30">30</option>
                        <option <?php if($rows_per_page=="40"): ?>selected="selected"<?php endif;?> value="40">40</option>
                        <option <?php if($rows_per_page=="50"): ?>selected="selected"<?php endif;?> value="50">50</option>
                        <option <?php if($rows_per_page=="60"): ?>selected="selected"<?php endif;?> value="60">60</option>
                        <option <?php if($rows_per_page=="70"): ?>selected="selected"<?php endif;?> value="70">70</option>
                        <option <?php if($rows_per_page=="80"): ?>selected="selected"<?php endif;?> value="80">80</option>
                        <option <?php if($rows_per_page=="90"): ?>selected="selected"<?php endif;?> value="90">90</option>
                        <option <?php if($rows_per_page=="100"): ?>selected="selected"<?php endif;?> value="100">100</option>
                        <option <?php if($rows_per_page=="500"): ?>selected="selected"<?php endif;?> value="500">500</option>
                        <option <?php if($rows_per_page=="1000"): ?>selected="selected"<?php endif;?> value="1000">1000</option>
                        <option <?php if($rows_per_page=="2000"): ?>selected="selected"<?php endif;?> value="2000">2000</option>
                        <option <?php if($rows_per_page=="3000"): ?>selected="selected"<?php endif;?> value="3000">3000</option>
                        <option <?php if($rows_per_page=="4000"): ?>selected="selected"<?php endif;?> value="4000">4000</option>
                        <option <?php if($rows_per_page=="5000"): ?>selected="selected"<?php endif;?> value="5000">5000</option>
                      </select>  
                    </td>
                  </tr>
                </table>
                <table> 
                    <tr>
                    <td class='name column-name' style='padding-top:15px;padding-left:10px;'>
                    
                        <script type="text/javascript">
                        function sendEmailToAll(obj){

                      	  var txt;
                      	  var r = confirm("<?php echo __( 'It is not recommaded to send email to all at once as there is always hosting server limit for send emails horly basis.Most of hosting providers allow 250 emails per hour.Please use cronjob newsletter to send email automatically.Do you still want to continue ?','mass-email-to-users');?>");
                      	  if (r == true) {
                      	     return true;
                      	  } else {
                      		return false;
                      	  }
                      	  	  

                        }
                        </script>
                    	<input onclick="return validateSendEmailAndDeleteEmail(this)" type='submit' value='<?php echo __( 'Send Email To Selected Users','mass-email-to-users');?>' name='sendEmail' class='button-primary' id='sendEmail' >&nbsp;<input  type='submit' value='<?php echo __( 'Send Email to Filtered Users','mass-email-to-users');?>' name='sendEmailFilter' class='button-primary' id='sendEmailFilter' >&nbsp;<input onclick="return sendEmailToAll(this)" type='submit' value='<?php echo __( 'Send Email To All Users','mass-email-to-users');?>' name='sendEmailAll' class='button-primary' id='sendEmailAll' >&nbsp;<input  type='submit' value='<?php echo __( 'Add/Update Selected Emails To Queue','mass-email-to-users');?>' name='sendEmailqueue' class='button-primary' id='sendEmailqueue' >
                    	&nbsp;<input onclick="return validateAndUnsubscribe(this)" type='submit' value='<?php echo __( 'Unsubscribe Selected Users','mass-email-to-users');?>' name='UnsubscribeSelected' class='button-primary' id='UnsubscribeSelected' >
                    
                    </td>
                    </tr>
                    <?php
                        $mass_email_queue=get_option('mass_email_queue');
                        if($mass_email_queue!=false and $mass_email_queue!=null ){ 
                           if(is_array($mass_email_queue)){ ?>
                            <tr>
                               <td>
                                  <h3><?php echo __( 'Emails In Queue','mass-email-to-users');?></h3>
                                  <textarea readonly="readonly" name="queueemails" id="queueemails" cols="70" rows="10"><?php
                                     foreach($mass_email_queue as $key=>$email_){
                                      $id_of_user=email_exists($email_);   
                                      
                                      $userMeta=get_user_meta($id_of_user, 'is_unsubscibed', true); 
                                      
                                      if($id_of_user>0 and ($userMeta==0 or $userMeta==null)){   
                                        echo "$email_".",\n";   
                                      }
                                      else{
                                          unset($mass_email_queue[$key]);
                                      }
                                     }
                                     update_option('mass_email_queue',$mass_email_queue);
                                    ?></textarea>
                                    <br/>
                                     <input type="hidden" name="uncheckedemails" id="uncheckedemails" value="">
                                     <input  type='submit' value='<?php echo __( 'Send Email To users In Queue','mass-email-to-users');?>' name='sendEmailQueue' class='button-primary' id='sendEmailQueue' >&nbsp;<input  type='submit' value='<?php echo __( 'Reset Email Queue','mass-email-to-users');?>' name='resetemailqueue' class='button-primary' id='resetemailqueue' >
                               </td>
                            </tr>
                        <?php } 
                           }
                        ?>    
                </table>
                </form>  
      
                  
     <?php
                   
      }
     else
      {
             echo '<center><div style="padding-bottom:50pxpadding-top:50px;"><h3>'.__( 'No Users Found','mass-email-to-users'),'</h3></div></center>';
             echo '<center><div style="padding-bottom:50pxpadding-top:50px;"><h3><a href="admin.php?page=Mass-Email">'.__( 'Click Here To Continue..','mass-email-to-users').'</a></h3></div></center>';
             
      } 
     ?>
     </div>
  </div>             
 </div>
    <?php 
     break;
     
  } 
 
?>
 <script type="text/javascript" >
 
 jQuery("input[name='ckboxs[]']").click(function() {
    uncheckedmanagement(this); 
       
});

function uncheckedmanagement(elementset){
   
     //alert(jQuery(this).is(':checked'));
     
     if(jQuery("#uncheckedemails").length>0){
        var hiddenvals=jQuery("#uncheckedemails").val();
     }
     else
       hiddenvals="|||";
       
     var emailval=jQuery(elementset).val();
     var emailsUn= hiddenvals.split('|||');
     
     if(jQuery(elementset).is(':checked')){
         
         if(jQuery.isArray(emailsUn)==true){
             
            emailsUn.splice(jQuery.inArray(emailval, emailsUn),1); 
            var strconvert=emailsUn.join('|||'); 
            jQuery("#uncheckedemails").val(strconvert); 
         }
        else{
            
             var addtohidden=emailval.toString()+'|||';
             jQuery("#uncheckedemails").val(addtohidden);
        }  
         
     }
     else{
            
            if(jQuery.isArray(emailsUn)==true){
                
                if(jQuery.inArray(emailval, emailsUn)<=0){
                    emailsUn.push(emailval);      
                    var strconvert=emailsUn.join('|||');             
                    jQuery("#uncheckedemails").val(strconvert); 
                }
                
            }
           else{
                    var addtohidden=emailval.toString()+'|||';
                    jQuery("#uncheckedemails").val(addtohidden);
               
           }         
     }
     
       
}

  function chkAll(id){
  
  if(id.name=='chkallHeader'){ 
  
      var chlOrnot=id.checked;
     document.getElementById('chkallHeader').checked= chlOrnot;
  
   }
 
     if(id.checked){
     
          var objs=document.getElementsByName("ckboxs[]");
           
           for(var i=0; i < objs.length; i++)
          {
             objs[i].checked=true;
              uncheckedmanagement(objs[i]);
            }

     
     } 
    else {

          var objs=document.getElementsByName("ckboxs[]");
           
           for(var i=0; i < objs.length; i++)
          {
              objs[i].checked=false;
              uncheckedmanagement(objs[i]);
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
         if(idobj.name=='sendEmail' || idobj.name=='sendEmailqueue'){
         alert('<?php echo __( 'Please select atleast one email.','mass-email-to-users');?>')  ;
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
  function validateAndUnsubscribe(idobj){
  
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
         alert('<?php echo __( 'Please select atleast one email.','mass-email-to-users');?>')  ;
         return false;
        
        }
     else
     {
       
        var agree=confirm("<?php echo __( 'Are you sure you want to unsubscribe selected users?','mass-email-to-users');?>");
         if (agree){
             
             return true;
         }
         else{
             
             return false;
         }
       
       }
        
  } 
     
  </script>
 
<?php  
   
}

function unsubscriber_list_func(){
    
   if(isset($_REQUEST['action'])){
        $action=$_REQUEST['action'];  
   }
   else
    $action='';
    
   switch($action){
    
    case 'resubscribe':
        
      if ( ! current_user_can( 'wmeu_mass_email_re_subscribe_unsubscribers' ) ) {

        wp_die( __( "Access Denied", "mass-email-to-users",403 ) );

      }  
      
      if(isset($_POST['mass_email_nonce']) and $_POST['mass_email_nonce']!=''){

        $retrieved_nonce=$_POST['mass_email_nonce'];

        }
        if (!wp_verify_nonce($retrieved_nonce, 'action_mass_email_nonce' ) ){


            wp_die('Security check fail'); 
        }     
     if(isset($_POST['ckboxs'])){
         $unseribers=$_POST['ckboxs'];
         
         foreach($unseribers as $unsub_id) {
             
           update_user_meta( $unsub_id, 'is_unsubscibed', '0');
         }
     }
    
    update_option( 'mass_email_succ', __( 'Selected users subscription updated successfully.','mass-email-to-users') );
    $referer=$_SERVER['HTTP_REFERER'];
    echo "<script>location.href='".$referer."';</script>"; 
    exit;
    break;   
    default:   
      $url=plugin_dir_url(__FILE__);
       
  ?>       
     <div style="width: 100%;">  
        <div style="float:left;width:69%;" >
                                                                                
  
  
<?php       
    global $wpdb;
    
     $wpcurrentdir=dirname(__FILE__);
     $wpcurrentdir=str_replace("\\","/",$wpcurrentdir);
     
     $group_concate_max='100000000';
     
     $query='SET SESSION group_concat_max_len = 1000000';
     $wpdb->query($query);
     
     $unscbscribersQuery="SELECT GROUP_CONCAT( user_id ) AS  `unsbscribers` 
                            FROM  $wpdb->usermeta 
                            WHERE  `meta_key` =  'is_unsubscibed' and meta_value='1'" ;
                                   
    $resultUnsb=$wpdb->get_results($unscbscribersQuery,'ARRAY_A');
    
    $unsubscriber_users=$resultUnsb[0]['unsbscribers'];
    
    if($unsubscriber_users=="" or $unsubscriber_users==null)
     $unsubscriber_users=0;
    
    
    $query="SELECT ID,user_email from $wpdb->users where ID IN ($unsubscriber_users)";
    $queryCount="SELECT count(ID) from $wpdb->users where ID IN ($unsubscriber_users)";
    
    if(isset($_GET['searchuser']) and $_GET['searchuser']!=''){
      $term=esc_sql(trim($_GET['searchuser']));   
      $query.="  and ( user_login like '%$term%' or user_nicename like '%$term%' or user_email like '%$term%' or  display_name like '%$term%'  )  " ; 
      $queryCount.="  and ( user_login like '%$term%' or user_nicename like '%$term%' or user_email like '%$term%' or  display_name like '%$term%'  )  " ; 
    } 
    
    $rows_per_page = 30;
    if(isset($_GET['setPerPage']) and $_GET['setPerPage']!=""){
        
       $rows_per_page=intval($_GET['setPerPage']);
    } 
    
    
    $totalRecordForQuery=$wpdb->get_var($queryCount);
    $selfPage=$_SERVER['PHP_SELF'].'?page=Mass-Email'; 
   
    $current = (isset($_GET['entrant'])) ? (intval($_GET['entrant'])) : 1;
    $pagination_args = array(
        'base' => @add_query_arg('entrant','%#%'),
        'format' => '',
        'total' => ceil($totalRecordForQuery/$rows_per_page),
        'current' => $current,
        'show_all' => false,
        'type' => 'plain',
    );
                
    
    $selfpage=$_SERVER['PHP_SELF'];
        
    if($totalRecordForQuery>0){
        
             
             
?>              
  <?php
                $SuccMsg=get_option('mass_email_succ');
                update_option( 'mass_email_succ', '' );
               
                $errMsg=get_option('mass_email_err');
                update_option( 'mass_email_err', '' );

                if(trim($errMsg)!=''){ echo "<div class='notice notice-error is-dismissible'><p>"; echo $errMsg; $errMsg='';echo "</p></div>";}
                else if(trim($SuccMsg)!=''){ echo "<div class='notice notice-success is-dismissible'><p>"; echo $SuccMsg;$SuccMsg=''; echo "</p></div>";}
                 ?>
                <h3><?php echo __( 'Unsubscribed users','mass-email-to-users');?></h3>
                <?php
                    $setacrionpage='admin.php?page=Mass-Email-Unsubscriber';
                    
                    $order_by='user_login';
                    $order_pos="asc";
                    
                    if(isset($_GET['entrant']) and $_GET['entrant']!=""){
                     $setacrionpage.='&entrant='.$_GET['entrant'];   
                    }
                
                    if(isset($_GET['setPerPage']) and $_GET['setPerPage']!=""){
                     $setacrionpage.='&setPerPage='.$_GET['setPerPage'];   
                    }
                    
                    $seval="";
                    if(isset($_GET['searchuser']) and $_GET['searchuser']!=""){
                     $seval=trim($_GET['searchuser']);   
                    }
                    
                    $search_term_='';
                    if(isset($_GET['searchuser'])){

                       $search_term_='&searchuser='.urlencode(sanitize_text_field($_GET['searchuser']));
                    }

                    if(isset($_GET['order_by'])){

                       $order_by=trim($_GET['order_by']); 
                    }

                    if(isset($_GET['order_pos'])){

                       $order_pos=trim($_GET['order_pos']); 
                    }
                    
                    $offset = ($current - 1) * $rows_per_page;
                    $order_by=sanitize_text_field(sanitize_sql_orderby($order_by));
                    $order_pos=sanitize_text_field(sanitize_sql_orderby($order_pos));

                    $query.=" order by $order_by $order_pos";
                    $query.=" limit $offset, $rows_per_page";
                   
                    $emails=$wpdb->get_results($query,'ARRAY_A');   

                   
                ?>
                <div style="padding-top:5px;padding-bottom:5px"><b>Search User : </b><input type="text" value="<?php echo $seval;?>" id="searchuser" name="searchuser">&nbsp;<input type='submit'  value='Search User' name='searchusrsubmit' class='button-primary' id='searchusrsubmit' onclick="SearchredirectTO();" >&nbsp;<input type='submit'  value='Reset Search' name='searchreset' class='button-primary' id='searchreset' onclick="ResetSearch();" ></div>  
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
               <form method="post" action="" id="sendemail" name="sendemail">
                   
                 <?php wp_nonce_field('action_mass_email_nonce','mass_email_nonce'); ?>  
                <input type="hidden" value="resubscribe" name="action" id="action">
                
              <table class="widefat fixed" cellspacing="0" style="width:97% !important" >
                <thead>
                <tr>
                    
                       <?php if($order_by=="user_email" and $order_pos=="asc"):?>
                        
                            <th>
                                <input onclick="chkAll(this)" type="checkbox" name="chkallHeader" id='chkallHeader'>&nbsp;
                                <a href="<?php echo $setacrionpage;?>&order_by=user_email&order_pos=desc<?php echo $search_term_;?>"><?php echo __('Email','mass-email-to-users');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/desc.png', __FILE__); ?>"/></a>
                            </th>
                       <?php else:?>
                           <?php if($order_by=="user_email"):?>
                                <th>
                                    <input onclick="chkAll(this)" type="checkbox" name="chkallHeader" id='chkallHeader'>&nbsp;
                                    <a href="<?php echo $setacrionpage;?>&order_by=user_email&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Email','mass-email-to-users');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/asc.png', __FILE__); ?>"/></a>
                                </th>
                           <?php else:?>
                               <th>
                                   <input onclick="chkAll(this)" type="checkbox" name="chkallHeader" id='chkallHeader'>&nbsp;
                                   <a href="<?php echo $setacrionpage;?>&order_by=user_email&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Email','mass-email-to-users');?></a>
                               </th>
                           <?php endif;?>    
                       <?php endif;?> 
                        
                        <?php if($order_by=="user_login" and $order_pos=="asc"):?>
                            <th><a href="<?php echo $setacrionpage;?>&order_by=user_login&order_pos=desc<?php echo $search_term_;?>"><?php echo __('Username','mass-email-to-users');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/desc.png', __FILE__); ?>"/></a></th>
                       <?php else:?>
                           <?php if($order_by=="user_login"):?>
                                <th><a href="<?php echo $setacrionpage;?>&order_by=user_login&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Username','mass-email-to-users');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/asc.png', __FILE__); ?>"/></a></th>
                           <?php else:?>
                               <th><a href="<?php echo $setacrionpage;?>&order_by=user_login&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Username','mass-email-to-users');?></a></th>
                           <?php endif;?>    
                       <?php endif;?> 
                        
                        <th scope="col" id="name" class="manage-column column-name" style=""><?php echo __('Name','mass-email-to-users');?></th>
                </tr>
                </thead>

                <tfoot>
                <tr>
                        <th scope="col" id="name" class="manage-column column-name" style=""><input onclick="chkAll(this)" type="checkbox" name="chkallfooter" id='chkallfooter'>&nbsp;<?php echo __( 'Select All Emails','mass-email-to-users');?></th>
                        <th scope="col" id="name" class="manage-column column-name" style=""><?php echo __( 'Username','mass-email-to-users');?></th>
                         <th scope="col" id="name" class="manage-column column-name" style=""><?php echo __('Name','mass-email-to-users');?></th>
                        
                </tr>
                </tfoot>

                <tbody id="the-list" class="list:cat">
               <?php                 
                                            
                    foreach($emails as $em)
                     {
                        
                           
                           $userId=$em['ID'];
                           $user_info = get_userdata($userId); 
                                 
                           echo"<tr class='iedit alternate'>
                            <td  class='name column-name' style='border:1px solid #DBDBDB;padding-left:13px;'><input type='checkBox' name='ckboxs[]' value='".$userId."'>&nbsp;".$em['user_email']."</td>";
                            echo "<td  class='name column-name' style='border:1px solid #DBDBDB;'> ".$user_info->user_login."</td>";
                           echo "<td  class='name column-name' style='border:1px solid #DBDBDB;'> ".$user_info->user_firstname.' '.$user_info->user_lastname."</td>";
                            echo "</tr>";
                          
                           
                     }
                       
                   ?>  
                 </tbody>       
                </table>
                <table>
                  <tr>
                    <td>
                      <?php
                       if($totalRecordForQuery>0){
                         echo "<div class='pagination' style='padding-top:10px'>";
                         echo paginate_links($pagination_args);
                         echo "</div>";
                        }
                        
                       ?>
                
                    </td>
                    <td>
                      <b>&nbsp;&nbsp;<?php echo __( 'Per Page','mass-email-to-users');?> : </b>
                      <?php
                        $setPerPageadmin='admin.php?page=Mass-Email-Unsubscriber';
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
                        <option <?php if($rows_per_page=="60"): ?>selected="selected"<?php endif;?> value="60">60</option>
                        <option <?php if($rows_per_page=="70"): ?>selected="selected"<?php endif;?> value="70">70</option>
                        <option <?php if($rows_per_page=="80"): ?>selected="selected"<?php endif;?> value="80">80</option>
                        <option <?php if($rows_per_page=="90"): ?>selected="selected"<?php endif;?> value="90">90</option>
                        <option <?php if($rows_per_page=="100"): ?>selected="selected"<?php endif;?> value="100">100</option>
                        <option <?php if($rows_per_page=="500"): ?>selected="selected"<?php endif;?> value="500">500</option>
                        <option <?php if($rows_per_page=="1000"): ?>selected="selected"<?php endif;?> value="1000">1000</option>
                        <option <?php if($rows_per_page=="2000"): ?>selected="selected"<?php endif;?> value="2000">2000</option>
                        <option <?php if($rows_per_page=="3000"): ?>selected="selected"<?php endif;?> value="3000">3000</option>
                        <option <?php if($rows_per_page=="4000"): ?>selected="selected"<?php endif;?> value="4000">4000</option>
                        <option <?php if($rows_per_page=="5000"): ?>selected="selected"<?php endif;?> value="5000">5000</option>
                      </select>  
                    </td>
                  </tr>
                </table>
                <table> 
                    <tr>
                    <td class='name column-name' style='padding-top:15px;padding-left:10px;'><input onclick="return validateSendEmailAndDeleteEmail(this)" type='submit' value='<?php echo __( 'Subscribe Again','mass-email-to-users');?>' name='subscribeagain' class='button-primary' id='subscribeagain' ></td>
                    </tr>
                </table>
                </form>  
      
                  
     <?php
                   
      }
     else
      {
               $SuccMsg=get_option('mass_email_succ');
                update_option( 'mass_email_succ', '' );
               
                $errMsg=get_option('mass_email_err');
                update_option( 'mass_email_err', '' );
                   
                if(trim($errMsg)!=''){ echo "<div class='notice notice-error is-dismissible'><p>"; echo $errMsg; $errMsg='';echo "</p></div>";}
                else if(trim($SuccMsg)!=''){ echo "<div class='notice notice-success is-dismissible'><p>"; echo $SuccMsg;$SuccMsg=''; echo "</p></div>";}
             
           
               echo '<center><div style="padding-bottom:50pxpadding-top:50px;"><h3>'.__( 'No Email unsubscription Found','mass-email-to-users').'</h3></div></center>';
               echo '<center><div style="padding-bottom:50pxpadding-top:50px;"><h3><a href="admin.php?page=Mass-Email">'.__( 'Click Here To Continue..','mass-email-to-users').'</a></h3></div></center>';
             
      } 
     ?>
     </div>
  </div>             

    <?php 
     break;
     
  } 
 
?>
 <script type="text/javascript" >
 
 jQuery("input[name='ckboxs[]']").click(function() {
    uncheckedmanagement(this); 
       
});


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

         alert('<?php echo __( 'Please select atleast one email','mass-email-to-users');?>.')  ;
         return false;
        
      }
     else
       return true; 
        
  } 
     
  </script>
 
<?php  
   
}


add_filter('plugins_api', 'i13_pro_plugin_mass_email_to_users_info', 10, 3);

    /*
     * $res empty at this step
     * $action 'plugin_information'
     * $args stdClass Object ( [slug] => woocommerce [is_ssl] => [fields] => Array ( [banners] => 1 [reviews] => 1 [downloaded] => [active_installs] => 1 ) [per_page] => 24 [locale] => en_US )
     */
    function i13_pro_plugin_mass_email_to_users_info( $res, $action, $args ){

            $plugin_slug = I13_MU_PSLUG;
        
            
            // do nothing if this is not about getting plugin information
            if( 'plugin_information' !== $action ) {
                    return $res;
            }

             // do nothing if it is not our plugin
            if( $plugin_slug !== $args->slug ) {
                
                    return $res;
            }
            
            // trying to get from cache first
           if( false == $remote = get_transient( 'i13_update_' . $plugin_slug ) ) {

                
                    $remote = wp_remote_get( add_query_arg( array(
                                    'lic_key' => urlencode( base64_encode($_SERVER['SERVER_ADDR'])),
                                    'up_info'=>urlencode('wp-07'),
                                    'sk'=>urlencode('R361va3bgQ1JPhs4qMd6Omw6hEutm8km'),
                                ), 'https://i13websolution.com/u/p/d/getjson.php' ), array(
                                    'timeout' => 50,
                                    'headers' => array(
                                            'Accept' => 'application/json'
                                    )
                            )
                    );

                   

                    if ( ! is_wp_error( $remote ) && isset( $remote['response']['code'] ) && $remote['response']['code'] == 200 && ! empty( $remote['body'] ) ) {
                            set_transient( 'i13_update_' . $plugin_slug, $remote, 3600 ); // 1 hours cache
                    }

            }
                  
            if( ! is_wp_error( $remote ) && isset( $remote['response']['code'] ) && $remote['response']['code'] == 200 && ! empty( $remote['body'] ) ) {
  
                    $remote = json_decode( $remote['body'] );
                    $res = new stdClass();

                    $res->name = $remote->name;
                    $res->slug = $plugin_slug;
                    $res->version = $remote->version;
                    $res->tested = $remote->tested;
                    $res->requires = $remote->requires;
                    $res->author = '<a href="https://i13websolution.com/">Niks</a>';
                    $res->author_profile = 'https://profiles.wordpress.org/nik00726';
                    $res->download_link = $remote->download_url;
                    $res->trunk = $remote->download_url;
                    $res->requires_php = $remote->requires_php;
                    $res->last_updated = $remote->last_updated;
                    $res->sections = array(
                            'description' => $remote->sections->description,
                            'changelog' => $remote->sections->changelog
                    );
                    $res->banners = array(
                            'low' =>$remote->banners->low,
                    );
                   
                    return $res;

            }

            return $res;

    }

    add_filter('site_transient_update_plugins', 'i13_mass_email_to_users_push_update' );

    function i13_mass_email_to_users_push_update( $transient ){

            if ( empty($transient->checked ) ) {
                return $transient;
            }

            
            // trying to get from cache first, to disable cache comment 10,20,21,22,24
            if( false == $remote = get_transient( 'i13_upgrade_'.I13_MU_PSLUG ) ) {

                     $remote = wp_remote_get( add_query_arg( array(
                                    'lic_key' => urlencode( base64_encode($_SERVER['SERVER_ADDR'])),
                                    'up_info'=>urlencode('wp-07'),
                                    'sk'=>urlencode('R361va3bgQ1JPhs4qMd6Omw6hEutm8km'),
                                ), 'https://i13websolution.com/u/p/d/getjson.php' ), array(
                                    'timeout' => 50,
                                    'headers' => array(
                                            'Accept' => 'application/json'
                                    )
                            )
                    );

                   
                    if ( !is_wp_error( $remote ) && isset( $remote['response']['code'] ) && $remote['response']['code'] == 200 && !empty( $remote['body'] ) ) {
                            set_transient( 'i13_upgrade_'.I13_MU_PSLUG, $remote, 3600 ); // 1 hours cache
                    }

            }

            if( $remote && !is_wp_error($remote)) {

                    $remote = json_decode( $remote['body'] );

                    // your installed plugin version should be on the line below! You can obtain it dynamically of course 
                    if( $remote && version_compare( I13_MU_PL_VERSION, $remote->version, '<' ) && version_compare($remote->requires, get_bloginfo('version'), '<' ) ) {
                            $res = new stdClass();
                            $res->slug = I13_MU_PSLUG;
                            $res->plugin = 'mass-email-to-users-pro/wordpressmassemail.php'; // it could be just YOUR_PLUGIN_SLUG.php if your plugin doesn't have its own directory
                            $res->new_version = $remote->version;
                            $res->tested = $remote->tested;
                            $res->package = $remote->download_url;
                            $transient->response[$res->plugin] = $res;
                            //$transient->checked[$res->plugin] = $remote->version;
                    }
                    else{
                        
                            $res = new stdClass();
                            $res->slug = I13_MU_PSLUG;
                            $res->plugin = 'mass-email-to-users-pro/wordpressmassemail.php'; // it could be just YOUR_PLUGIN_SLUG.php if your plugin doesn't have its own directory
                            $res->tested = $remote->tested;
                            $res->update=0;
                            $transient->no_update[$res->plugin]=$res;
                    }

            }
            return $transient;
    }

    add_action( 'upgrader_process_complete', 'i13_mass_email_to_users_after_update', 10, 2 );

    function i13_mass_email_to_users_after_update( $upgrader_object, $options ) {
            if ( $options['action'] == 'update' && $options['type'] === 'plugin' )  {
                    // just clean the cache when new plugin version is installed
                    delete_transient( 'i13_upgrade_'.I13_MU_PSLUG );
            }
    }
    
function getEmailTemplate_massmail() {

            if(isset($_GET) and is_array($_GET) and  isset($_GET['templateId'])){
                    
                   $tId=(int) htmlentities(sanitize_text_field($_GET['templateId']),ENT_QUOTES); 
                   global $wpdb; 
                   $query="SELECT * FROM ".$wpdb->prefix."massmail_e_template where id=".$tId;
                   $row=$wpdb->get_row($query, ARRAY_A);
                   //$row['content']=wpautop($row['content']);
                   $row['content']= stripslashes_deep($row['content']);
                   $row['content']= html_entity_decode($row['content']);
                   echo json_encode($row);
                   exit;
 

            }
            
           echo "";exit;     
            //echo die;

    }
function mass_mail_email_template_management_func(){
    
     $action='gridview';
      if(isset($_GET['action']) and $_GET['action']!=''){
        
         $action=trim($_GET['action']);       
      }                    
      if(strtolower($action)==strtolower('gridview')){ 
      
           if ( ! current_user_can( 'wmeu_mass_email_view_newsletter_templates' ) ) {

              wp_die( __( "Access Denied", "mass-email-to-users",403 ) );

           }  
      
      ?>
      <div class="wrap">
        <?php
        $url = plugin_dir_url(__FILE__); 
        $url = str_replace("\\","/",$url); 
       
       ?>       
     
       <div style="width: 100%;">  
        <div style="float:left;width:90%;" >
       <?php
                
                $messages=get_option('mass_email_email_template'); 
                $type='';
                $message='';
                if(isset($messages['type']) and $messages['type']!=""){

                $type=$messages['type'];
                $message=$messages['message'];

                }  

                if(trim($type)=='err'){ echo "<div class='notice notice-error is-dismissible'><p>"; echo $message; echo "</p></div>";}
                else if(trim($type)=='succ'){ echo "<div class='notice notice-success is-dismissible'><p>"; echo $message; echo "</p></div>";}


                update_option('mass_email_email_template', array());     
          ?>    
        <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
        <h2><?php echo __( 'Manage Email Templates','mass-email-to-users');?> <a class="button add-new-h2" href="admin.php?page=mass_mail_email_template_management&action=addedit"><?php echo __( 'Add New','mass-email-to-users');?></a> </h2>
        <br/>    
        <form method="POST" action="admin.php?page=mass_mail_email_template_management&action=deleteselected"  id="posts-filter" onkeypress="return event.keyCode != 13;">
              <div class="alignleft actions">
                <select name="action_upper" id="action_upper">
                    <option selected="selected" value="-1"><?php echo __( 'Bulk Actions','mass-email-to-users');?></option>
                    <option value="delete"><?php echo __( 'Delete','mass-email-to-users');?></option>
                </select>
                <input type="submit" value="<?php echo __( 'Apply','mass-email-to-users');?>" class="button-secondary action" id="deleteselected" name="deleteselected" onclick="return confirmDelete_bulk();">
            </div>
         <br class="clear">
          <?php

                $setacrionpage='admin.php?page=mass_mail_email_template_management';

                if(isset($_GET['order_by']) and $_GET['order_by']!=""){
                 $setacrionpage.='&order_by='.$_GET['order_by'];   
                }

                if(isset($_GET['order_pos']) and $_GET['order_pos']!=""){
                 $setacrionpage.='&order_pos='.$_GET['order_pos'];   
                }

                $seval="";
                if(isset($_GET['search_term']) and $_GET['search_term']!=""){
                 $seval=trim($_GET['search_term']);   
                }

            ?>
           <?php
               global $wpdb;

               $order_by='id';
               $order_pos="asc";

               if(isset($_GET['order_by'])){

                  $order_by=trim($_GET['order_by']); 
               }

               if(isset($_GET['order_pos'])){

                  $order_pos=trim($_GET['order_pos']); 
               }
                $search_term='';
               if(isset($_GET['search_term'])){

                  $search_term= sanitize_text_field(esc_sql($_GET['search_term']));
               }

               $search_term_='';
                if(isset($_GET['search_term'])){

                   $search_term_='&search_term='.urlencode(sanitize_text_field($_GET['search_term']));
                }


               $query = "SELECT * FROM " . $wpdb->prefix . "massmail_e_template ";
               $queryCount = "SELECT count(*) FROM " . $wpdb->prefix . "massmail_e_template ";
               if($search_term!=''){
                  $query.=" where id like '%$search_term%' or name like '%$search_term%' "; 
                  $queryCount.=" where id like '%$search_term%' or name like '%$search_term%' "; 
               }


               $order_by=sanitize_text_field(sanitize_sql_orderby($order_by));
               $order_pos=sanitize_text_field(sanitize_sql_orderby($order_pos));

               $query.=" order by $order_by $order_pos";

               $rowsCount=$wpdb->get_var($queryCount);



               ?>
               <div style="padding-top:5px;padding-bottom:5px">
                  <b><?php echo __( 'Search','mass-email-to-users');?> : </b>
                    <input type="text" value="<?php echo $seval;?>" id="search_term" name="search_term">&nbsp;
                    <input type='button'  value='<?php echo __( 'Search','mass-email-to-users');?>' name='searchusrsubmit' class='button-primary' id='searchusrsubmit' onclick="SearchredirectTO();" >&nbsp;
                    <input type='button'  value='<?php echo __( 'Reset Search','mass-email-to-users');?>' name='searchreset' class='button-primary' id='searchreset' onclick="ResetSearch();" >
              </div>  
              <script type="text/javascript" >
                 
                  jQuery('#search_term').on("keyup", function(e) {
                         if (e.which == 13) {

                             SearchredirectTO();
                         }
                    });   
               function SearchredirectTO(){
                 var redirectto='<?php echo $setacrionpage; ?>';
                 var searchval=jQuery('#search_term').val();
                 redirectto=redirectto+'&search_term='+jQuery.trim(encodeURIComponent(searchval));  
                 window.location.href=redirectto;
               }
              function ResetSearch(){

                   var redirectto='<?php echo $setacrionpage; ?>';
                   window.location.href=redirectto;
                   exit;
              }
              </script>
         <div id="no-more-tables">
              <table cellspacing="0" id="gridTbl" class="table-bordered table-striped table-condensed cf" >
            <thead>
                <tr>
                    <th class="manage-column column-cb check-column" scope="col"><input type="checkbox"></th>
                    <?php if($order_by=="id" and $order_pos=="asc"):?>
                        <th><a href="<?php echo $setacrionpage;?>&order_by=id&order_pos=desc<?php echo $search_term_;?>"><?php echo __('Id','mass-email-to-users');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/desc.png', __FILE__); ?>"/></a></th>
                   <?php else:?>
                       <?php if($order_by=="id"):?>
                            <th><a href="<?php echo $setacrionpage;?>&order_by=id&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Id','mass-email-to-users');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/asc.png', __FILE__); ?>"/></a></th>
                       <?php else:?>
                           <th><a href="<?php echo $setacrionpage;?>&order_by=id&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Id','mass-email-to-users');?></a></th>
                       <?php endif;?>    
                   <?php endif;?> 
                    
                   <?php if($order_by=="subject" and $order_pos=="asc"):?>
                        <th><a href="<?php echo $setacrionpage;?>&order_by=subject&order_pos=desc<?php echo $search_term_;?>"><?php echo __('Subject','mass-email-to-users');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/desc.png', __FILE__); ?>"/></a></th>
                   <?php else:?>
                       <?php if($order_by=="subject"):?>
                            <th><a href="<?php echo $setacrionpage;?>&order_by=subject&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Subject','mass-email-to-users');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/asc.png', __FILE__); ?>"/></a></th>
                       <?php else:?>
                           <th><a href="<?php echo $setacrionpage;?>&order_by=subject&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Subject','mass-email-to-users');?></a></th>
                       <?php endif;?>    
                   <?php endif;?> 
                           
                    <?php if($order_by=="createdon" and $order_pos=="asc"):?>
                        <th><a href="<?php echo $setacrionpage;?>&order_by=createdon&order_pos=desc<?php echo $search_term_;?>"><?php echo __('Created On','mass-email-to-users');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/desc.png', __FILE__); ?>"/></a></th>
                    <?php else:?>
                        <?php if($order_by=="createdon"):?>
                    <th><a href="<?php echo $setacrionpage;?>&order_by=createdon&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Created On','mass-email-to-users');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/asc.png', __FILE__); ?>"/></a></th>
                        <?php else:?>
                            <th><a href="<?php echo $setacrionpage;?>&order_by=createdon&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Created On','mass-email-to-users');?></a></th>
                        <?php endif;?>    
                    <?php endif;?>                            
                    
                    <th><span><?php echo __( 'Edit','mass-email-to-users');?></span></th>
                    <th><span><?php echo __( 'Delete','mass-email-to-users');?></span></th>
                </tr>  
           </thead>
            <tbody id="the-list">
                   <?php
                   
                    if($rowsCount > 0){
                    
                            global $wp_rewrite;
                            $rows_per_page = 10;
                            
                            $current = (isset($_GET['paged'])) ? (intval($_GET['paged'])) : 1;
                            $pagination_args = array(
                            'base' => @add_query_arg('paged','%#%'),
                            'format' => '',
                            'total' => ceil($rowsCount/$rows_per_page),
                            'current' => $current,
                            'show_all' => false,
                            'type' => 'plain',
                           );
                            
                          
                          $offset = ($current - 1) * $rows_per_page;
                                            
                          $query.=" limit $offset, $rows_per_page";
                          $rows = $wpdb->get_results ( $query);

                         
                           $delRecNonce=wp_create_nonce('delete_template');           
                           foreach ($rows as $row ) {
                               
                               $id=$row->id;
                               $editlink="admin.php?page=mass_mail_email_template_management&action=addedit&id=$id";
                               $deletelink="admin.php?page=mass_mail_email_template_management&action=delete&id=$id&nonce=$delRecNonce";
                               $manageImages="admin.php?page=mass_mail_email_template_management&sliderid=$id";
                               
                            ?>
                              <tr valign="top" >
                                <td class="alignCenter check-column"   data-title="<?php echo __( 'Select Record','mass-email-to-users');?>" ><input type="checkbox" value="<?php echo $row->id ?>" name="newsletters[]"></td>
                                <td class="alignCenter"   data-title="<?php echo __( 'Id','mass-email-to-users');?>"><?php echo $row->id; ?></td>
                                <td class="alignCenter"   data-title="<?php echo __( 'Subject','mass-email-to-users');?>" ><strong><?php echo $row->subject; ?></strong></td>  
                                <td class="alignCenter"   data-title="<?php echo __( 'Created On','mass-email-to-users');?>" ><strong><?php echo $row->createdon; ?></strong></td>  
                                <td class="alignCenter"   data-title="<?php echo __( 'Edit','mass-email-to-users');?>"><strong><a href='<?php echo $editlink; ?>' title="<?php echo __( 'Edit','mass-email-to-users');?>"><?php echo __( 'Edit','mass-email-to-users');?></a></strong></td>  
                                <td class="alignCenter"   data-title="<?php echo __( 'Delete','mass-email-to-users');?>"><strong><a href='<?php echo $deletelink; ?>' onclick="return confirmDelete();"  title="<?php echo __( 'Delete','mass-email-to-users');?>"><?php echo __( 'Delete','mass-email-to-users');?></a> </strong></td>  
                            </tr>
                          
                     <?php 
                             } 
                    }
                   else{
                       ?>
                       <tr valign="top" class="" id="">
                            <td colspan="6" data-title="<?php echo __( 'No Record','mass-email-to-users');?>" align="center"><strong><?php echo __( 'No Email Templates Found','mass-email-to-users');?></strong></td>  
                        </tr>
                  <?php 
                   } 
                 ?>      
        </tbody>
  </table>
         </div> 
  <?php
    if($rowsCount>0){
     echo "<div class='pagination' style='padding-top:10px'>";
     echo paginate_links($pagination_args);
     echo "</div>";
    }
  ?>
    <br/>
    <div class="alignleft actions">
        <select name="action" id="action_bottom">
            <option selected="selected" value="-1"><?php echo __( 'Bulk Actions','mass-email-to-users');?></option>
            <option value="delete"><?php echo __( 'Delete','mass-email-to-users');?></option>
        </select>
        <?php wp_nonce_field('action_newsletter_mass_delete','mass_delete_nonce'); ?>
        <input type="submit" value="<?php echo __( 'Apply','mass-email-to-users');?>" class="button-secondary action" id="deleteselected" name="deleteselected" onclick="return confirmDelete_bulk();">
    </div>

    </form>
        <script type="text/JavaScript">

        function  confirmDelete_bulk(){
                var topval=document.getElementById("action_bottom").value;
                var bottomVal=document.getElementById("action_upper").value;

                if(topval=='delete' || bottomVal=='delete'){


                    var agree=confirm("<?php echo __( 'Are you sure you want to delete selected email template?','mass-email-to-users');?>");
                    if (agree)
                        return true ;
                    else
                        return false;
                }
            }
            
        function  confirmDelete(){
                
            var agree=confirm("<?php echo __( 'Are you sure you want to delete this email template?','mass-email-to-users');?>");
            if (agree)
                 return true ;
            else
                 return false;
         }
     </script>

        <br class="clear">
        </div>
        <div style="clear: both;"></div>
        <?php $url = plugin_dir_url(__FILE__);  ?>
      </div>  
    </div>  
    <div class="clear"></div> 
     <?php  
      } 
      else if(strtolower($action)==strtolower('addedit')){
       
       $url = plugin_dir_url(__FILE__);
       if(isset($_POST['savenewsletter'])){
                  
            if ( !check_admin_referer( 'action_newsletter_add_edit','add_edit_template_nonce')){

                wp_die('Security check fail'); 
            }

            $subject=stripslashes($_POST['email_subject']);
            $subject=trim(htmlentities(sanitize_text_field($subject),ENT_QUOTES));
            $email_from_name=stripslashes(sanitize_text_field($_POST['email_From_name']));
            $email_from_name=trim(htmlentities(sanitize_text_field($email_from_name),ENT_QUOTES));
            $email_from=trim(htmlentities(sanitize_text_field($_POST['email_From']),ENT_QUOTES));
            $content=trim($_POST['txtArea']);
            $createdOn=current_time('mysql');
          
           
            
            
            global $wpdb;
            
            if(isset($_POST['id'])){
                                 
                
                  if ( ! current_user_can( 'wmeu_mass_email_edit_newsletter_templates' ) ) {

                        $location = "admin.php?page=mass_mail_email_template_management";
                        $mass_email_email_template = array ();
                        $mass_email_email_template ['type'] = 'err';
                        $mass_email_email_template ['message'] = __('Access Denied. Please contact your administrator','mass-email-to-users');
                        update_option ( 'mass_email_email_template', $mass_email_email_template );
                        echo "<script type='text/javascript'> location.href='$location';</script>";
                        exit ();
                  

                  }
                  
                  $data=array();
                  $data['subject']          =$subject;
                  $data['email_from_name']  =$email_from_name;
                  $data['email_from']       =$email_from;
                  $data['content']          =htmlentities($content);
                  $data['createdon']        =$createdOn;
                  
                    
                  $id=(int)$_POST['id'];
                  $where=array('id'=>$id);
                  $wpdb->update( $wpdb->prefix."massmail_e_template", $data, $where); 
                  
                  $mass_email_email_template=array();
                  $mass_email_email_template['type']='succ';
                  $mass_email_email_template['message']='Email template updated successfully.';
                  update_option('mass_email_email_template', $mass_email_email_template);
                                                      
                                                        
            }else{

                  
                  if ( ! current_user_can( 'wmeu_mass_email_add_newsletter_templates' ) ) {

                        $location = "admin.php?page=mass_mail_email_template_management";
                        $mass_email_email_template = array ();
                        $mass_email_email_template ['type'] = 'err';
                        $mass_email_email_template ['message'] = __('Access Denied. Please contact your administrator','mass-email-to-users');
                        update_option ( 'mass_email_email_template', $mass_email_email_template );
                        echo "<script type='text/javascript'> location.href='$location';</script>";
                        exit ();
                  

                   } 
                   
                   $data=array();
                   $data['subject']          =$subject;
                   $data['email_from_name']  =$email_from_name;
                   $data['email_from']       =$email_from;
                   $data['content']          =htmlentities($content);
                   $data['createdon']        =$createdOn;
                  
                   
                   $wpdb->insert( $wpdb->prefix."massmail_e_template", $data); 
                   $mass_email_email_template=array();
                   $mass_email_email_template['type']='succ';
                   $mass_email_email_template['message']='Email template added successfully.';
                   update_option('mass_email_email_template', $mass_email_email_template);
                   
            }                                                          
              
           
            $location='admin.php?page=mass_mail_email_template_management';
            echo "<script type='text/javascript'> location.href='$location';</script>";
            exit;
         
     }  
     
     if(isset($_GET['id'])){
         
         global $wpdb;
         $id= intval($_GET['id']);
         $query="SELECT * FROM ".$wpdb->prefix."massmail_e_template WHERE id=$id";
         $settings  = $wpdb->get_row($query,ARRAY_A);
        
          if ( ! current_user_can( 'wmeu_mass_email_edit_newsletter_templates' ) ) {

                $location = "admin.php?page=mass_mail_email_template_management";
                $mass_email_email_template = array ();
                $mass_email_email_template ['type'] = 'err';
                $mass_email_email_template ['message'] = __('Access Denied. Please contact your administrator','mass-email-to-users');
                update_option ( 'mass_email_email_template', $mass_email_email_template );
                echo "<script type='text/javascript'> location.href='$location';</script>";
                exit ();


           } 

         if(!is_array($settings)){
     
                
                $settings=array();
                $settings['subject']=null;
                $settings['email_from_name']=null;
                $settings['email_from']=null;
                $settings['content']="";
                
          }else{
              
             $settings['content']=stripcslashes($settings['content']); 
             $settings['subject']=$settings['subject']; 
             $settings['email_from_name']=$settings['email_from_name']; 
             $settings['content']=html_entity_decode($settings['content']); 
             
             
          }
         
     }else{
         
               if ( ! current_user_can( 'wmeu_mass_email_add_newsletter_templates' ) ) {

                        $location = "admin.php?page=mass_mail_email_template_management";
                        $mass_email_email_template = array ();
                        $mass_email_email_template ['type'] = 'err';
                        $mass_email_email_template ['message'] = __('Access Denied. Please contact your administrator','mass-email-to-users');
                        update_option ( 'mass_email_email_template', $mass_email_email_template );
                        echo "<script type='text/javascript'> location.href='$location';</script>";
                        exit ();
                  

                   } 
                   
                $settings=array();
                $settings['subject']=null;
                $settings['email_from_name']=null;
                $settings['email_from']=null;
                $settings['content']="";
            
          
     }
      
      
      
?>
<?php  
       $url = plugin_dir_url(__FILE__); 
       $imgDir = plugin_dir_url(__FILE__).'images/'; 
       $imgDir=str_replace("\\","/",$imgDir);
       $url = str_replace("\\","/",$url); 
       $tinymceJS=$url."/ckeditorReq/";
     
   
       
 ?>
 <div class="wrap">
     <?php if(isset($_GET['id']) and intval($_GET['id'])>0): ?>
        <h2><?php echo __( 'Update Email Template','mass-email-to-users');?></h2>
     <?php else: ?>
        <h2><?php echo __( 'Add Email Template','mass-email-to-users');?></h2>
     <?php endif; ?>   
   <form name="Newsletter_form" id='Newsletter_form' method="post" action=""> 
    <input type="hidden" value="addedit" name="action"> 
    <table class="form-table" style="width:100%" >
    <tbody>
      <tr valign="top" id="subject">
         <th scope="row" style="width:30%;text-align: right;"><?php echo __( 'Subject','mass-email-to-users');?> *</th>
         <td>    
            <input type="text" value="<?php echo $settings['subject'];?>" id="email_subject" name="email_subject"  class="valid" size="70">
            <div style="clear: both;"></div><div></div>
          </td>
       </tr>
       <tr valign="top" id="subject">
         <th scope="row" style="width:30%;text-align: right"><?php echo __( 'Email From Name','mass-email-to-users');?> *</th>
         <td>    
            <input type="text" value="<?php echo $settings['email_from_name'];?>" id="email_From_name" name="email_From_name"  class="valid" size="70">
             <br/><?php echo __( '(ex. admin)','mass-email-to-users');?>  
            <div style="clear: both;"></div><div></div>
           
          </td>
       </tr>
       <tr valign="top" id="subject">
         <th scope="row" style="width:30%;text-align: right"><?php echo __( 'Email From','mass-email-to-users');?> *</th>
         <td>    
            <input type="text" id="email_From" value="<?php echo $settings['email_from'];?>" name="email_From"  class="valid" size="70">
            <br/><?php echo __( '(ex. admin@yoursite.com)','mass-email-to-users');?> 
            <div style="clear: both;"></div><div></div>
      
          </td>
       </tr>
       <tr valign="top" id="subject">
         <th scope="row" style="width:30%;text-align: right"><?php echo __( 'Email Body','mass-email-to-users');?> *</th>
         <td>    
           <div class="wrap">
           <?php wp_editor( $settings['content'], 'txtArea' );?>    
            <input type="hidden" name="editor_val" id="editor_val" />  
            <div style="clear: both;"></div><div></div> 
            
            <?php echo __( 'you can use','mass-email-to-users');?> [username],[first_name],[last_name],[nickname],[user_email],[user_nicename],[display_name],[unsubscribe_link_plain],[unsubscribe_link_html] 
                
            <?php $selected=array();?>
            <?php $options=get_option('buddypress_fields');
            if($options!=false){

                $selected= json_decode($options,true);
            }

             if (function_exists('bp_is_active') && bp_is_active( 'xprofile' ) ){

                global $wpdb; 
                $query="SELECT * FROM ".$wpdb->prefix."bp_xprofile_groups";
                $results=$wpdb->get_results($query,ARRAY_A);

                if(is_array($results) and sizeof($results)>0 && is_array($selected) && sizeof($selected)>0){

                ?>
                <?php

                    foreach($results as $res){


                            ?>
                           <?php if (function_exists('bp_is_active') && bp_is_active( 'xprofile' ) ) : if ( bp_has_profile( array( 'profile_group_id' => $res['id'], 'fetch_field_data' => false ) ) ) : while ( bp_profile_groups() ) : bp_the_profile_group(); ?>

                                <?php while ( bp_profile_fields() ) : bp_the_profile_field(); ?>
                                    <?php global $field;?>


                                                 <?php if(isset($selected[$field->id]) && isset($selected[$field->id]['list']) && $selected[$field->id]['list']==1):?>
                                                   ,[<?php bp_the_profile_field_name(); ?>]
                                                 <?php endif;?>   


                            <?php endwhile; ?>


                           <?php endwhile; endif; endif; ?>

                    <?php }

                    }



                    }?>
                                                       
                <?php echo __( 'place holder into email content','mass-email-to-users');?>
           </div> 
          </td>
       </tr>
       <tr valign="top" id="subject">
         <th scope="row" style="width:30%"></th>
         <td> 
            <?php if(isset($_GET['id']) and intval($_GET['id'])>0): ?>
             <input type="hidden" name="id" value="<?php echo intval($_GET['id']);?>">
            <?php endif;?>
             
           <?php wp_nonce_field('action_newsletter_add_edit','add_edit_template_nonce'); ?>  
           <input type='submit'  value='<?php echo __( 'Save Email Template','mass-email-to-users');?>' name='savenewsletter' class='button-primary' id='savenewsletter' >  
          </td>
       </tr>
       
    </table>
    </form>
 </div>
<script type="text/javascript">

 
 jQuery(document).ready(function() {

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


   jQuery("#Newsletter_form").validate({
                    errorClass: "image_error",
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
                      

  });
 
 </script> 
 <?php
      }
     else if(strtolower($action)==strtolower('delete')){
               
               $retrieved_nonce = '';
            
                if(isset($_GET['nonce']) and $_GET['nonce']!=''){

                    $retrieved_nonce=$_GET['nonce'];

                }
                if (!wp_verify_nonce($retrieved_nonce, 'delete_template' ) ){


                    wp_die('Security check fail'); 
                }
                
                 if ( ! current_user_can( 'wmeu_mass_email_delete_newsletter_templates' ) ) {

                        $location = "admin.php?page=mass_mail_email_template_management";
                        $mass_email_email_template = array ();
                        $mass_email_email_template ['type'] = 'err';
                        $mass_email_email_template ['message'] = __('Access Denied. Please contact your administrator','mass-email-to-users');
                        update_option ( 'mass_email_email_template', $mass_email_email_template );
                        echo "<script type='text/javascript'> location.href='$location';</script>";
                        exit ();
                  

                   } 
                   
               global $wpdb;
               $location="admin.php?page=mass_mail_email_template_management";
               $deleteId=(int) htmlentities(sanitize_text_field($_GET['id']),ENT_QUOTES);
                    
                    try{
                             
                        
                            
                           $query = "delete from  ".$wpdb->prefix."massmail_e_template where id=$deleteId";
                           $wpdb->query($query); 
                       
                           $mass_email_email_template=array();
                           $mass_email_email_template['type']='succ';
                           $mass_email_email_template['message']=__( 'Email template deleted successfully.','mass-email-to-users');
                           update_option('mass_email_email_template', $mass_email_email_template);    

         
                     }
                   catch(Exception $e){
                   
                          $mass_email_email_template=array();
                          $mass_email_email_template['type']='err';
                          $mass_email_email_template['message']=__( 'Error while deleting email template.','mass-email-to-users');
                          update_option('mass_email_email_template', $mass_email_email_template);
                    }  
                              
              
              echo "<script type='text/javascript'> location.href='$location';</script>";
              exit;
                  
      }  
      else if(strtolower($action)==strtolower('deleteselected')){
          
              if(!check_admin_referer('action_newsletter_mass_delete','mass_delete_nonce')){

                    wp_die('Security check fail'); 
                }
            
                if ( ! current_user_can( 'wmeu_mass_email_delete_newsletter_templates' ) ) {

                        $location = "admin.php?page=mass_mail_email_template_management";
                        $mass_email_email_template = array ();
                        $mass_email_email_template ['type'] = 'err';
                        $mass_email_email_template ['message'] = __('Access Denied. Please contact your administrator','mass-email-to-users');
                        update_option ( 'mass_email_email_template', $mass_email_email_template );
                        echo "<script type='text/javascript'> location.href='$location';</script>";
                        exit ();
                  

                 }  
               global $wpdb; 
               $location="admin.php?page=mass_mail_email_template_management";
               if(isset($_POST) and isset($_POST['deleteselected']) and  ( $_POST['action']=='delete' or $_POST['action_upper']=='delete')){
              
                    if(is_array($_POST['newsletters']) && sizeof($_POST['newsletters']) >0){
                    
                            $deleteto=$_POST['newsletters'];
                            $implode=implode(',',$deleteto);   
                            
                            try{
                                    
                                   foreach($deleteto as $deleteId){ 
                                            
                                          $deleteId=intval($deleteId);
                                          $query = "delete from  ".$wpdb->prefix."massmail_e_template where id=$deleteId";
                                          $wpdb->query($query); 
                                      
                                   }
                                   $mass_email_email_template=array();
                                   $mass_email_email_template['type']='succ';
                                   $mass_email_email_template['message']=__( 'Selected email templates deleted successfully.','mass-email-to-users');
                                   update_option('mass_email_email_template', $mass_email_email_template);    
                 
                             }
                           catch(Exception $e){
                           
                                  $mass_email_email_template=array();
                                  $mass_email_email_template['type']='err';
                                  $mass_email_email_template['message']=__( 'Error while deleting email templates.','mass-email-to-users');
                                  update_option('mass_email_email_template', $mass_email_email_template);
                            }  
                                  
                           
                           echo "<script type='text/javascript'> location.href='$location';</script>";
                           exit;
                    
                    
                    }
                    else{
                    
                        
                        echo "<script type='text/javascript'> location.href='$location';</script>";   
                        exit;
                    }
                
               }
               else{
                     
                     echo "<script type='text/javascript'> location.href='$location';</script>";      
                     exit;
               }
         
          }      
      
    
}

function ms_cron_settings_func(){
    
    $imgUrl=plugin_dir_url(__FILE__)."images/";
    $ms_massmail_cron_settings=get_option('ms_massmail_cron_settings');
     $_POST = stripslashes_deep( $_POST );
     if(isset($_POST['btnsave'])){
         
          if(!check_admin_referer( 'action_settings_add_edit','add_edit_nonce' )){

                wp_die('Security check fail'); 
           }
           
        $ms_massmail_cron_settings=array();
        $ms_massmail_cron_settings['allowed_emails_per_hour']=intval(htmlentities(sanitize_text_field($_POST['allowed_emails_per_hour']),ENT_QUOTES));
        $ms_massmail_cron_settings['wait_time_between_two_emails']=trim(htmlentities(sanitize_text_field($_POST['wait_time_between_two_emails']),ENT_QUOTES));
      
        update_option('ms_massmail_cron_settings', $ms_massmail_cron_settings); 

         $mass_email_email_template=array();
         $mass_email_email_template['type']='succ';
         $mass_email_email_template['message']=__( 'Settings saved successfully.','mass-email-to-users');
         update_option('mass_email_email_template', $mass_email_email_template);

         
     }    
    
?>   
<?php  $url = plugin_dir_url(__FILE__);
       

 ?>
 <style type="">
    .fieldsetAdmin {
        margin: 10px 0px;
        padding: 10px;
        border: 1px solid rgb(221, 221, 221);
        font-size: 15px;
    }
        .fieldsetAdmin legend {
            font-weight: bold;
            color: #222222;
            
        }
    </style>    
 <div style="width: 100%;">  
        <div style="float:left;width:100%;">
            <div class="wrap">
                
              <?php
                    $messages=get_option('mass_email_email_template'); 
                    $type='';
                    $message='';
                    if(isset($messages['type']) and $messages['type']!=""){

                    $type=$messages['type'];
                    $message=$messages['message'];

                    }  


                      if(trim($type)=='err'){ echo "<div class='notice notice-error is-dismissible'><p>"; echo $message; echo "</p></div>";}
                      else if(trim($type)=='succ'){ echo "<div class='notice notice-success is-dismissible'><p>"; echo $message; echo "</p></div>";}



                    update_option('mass_email_email_template', array());     
              ?>      

                    <h2><?php echo __( 'Cronjob Settings','mass-email-to-users');?></h2>
            <br>
        
        <div id="poststuff">
              <div id="post-body" class="metabox-holder columns-2">
                <div id="post-body-content">
                  <form method="post" action="" id="subscriptionFrmsettiings" name="subscriptionFrmsettiings" >
                     <fieldset class="fieldsetAdmin">
                      <legend><?php echo __( 'Cronjob settings','mass-email-to-users');?></legend>
                      
                      <div class="stuffbox" id="namediv" style="min-width:550px;">
                         <h3><label><?php echo __( 'Allowed Emails Per Hours By Your Hosting','mass-email-to-users');?> </label></h3>
                        <div class="inside">
                             <table>
                               <tr>
                                 <td>
                                  <input type="text" id="allowed_emails_per_hour" size="50" name="allowed_emails_per_hour" value="<?php echo $ms_massmail_cron_settings['allowed_emails_per_hour'];?>" style="width:100px;">
                                 
                                   <div style="clear:both"></div>
                                   <div></div>
                                 </td>
                                
                               </tr>
                             </table>
                             <div style="clear:both"></div>
                         </div>
                      </div>
                      <div class="stuffbox" id="namediv" style="min-width:550px;">
                         <h3><label><?php echo __( 'Wait In Seconds Between Two Email','mass-email-to-users');?> </label></h3>
                        <div class="inside">
                             <table>
                               <tr>
                                 <td>
                                  <input type="text" id="wait_time_between_two_emails" size="50" name="wait_time_between_two_emails" value="<?php echo $ms_massmail_cron_settings['wait_time_between_two_emails'];?>" style="width:100px;">
                                 
                                   <div style="clear:both"><?php echo __( 'some host not allow continuous emails to send , So add wait between emails in seconds','mass-email-to-users');?></div>
                                   <div></div>
                                 </td>
                                
                               </tr>
                             </table>
                             <div style="clear:both"></div>
                         </div>
                      </div>
                      <div class="stuffbox" id="namediv" style="min-width:550px;">
                         <h3><label><?php echo __( 'Set bellow cronjob to run every 5 minute','mass-email-to-users');?> </label></h3>
                        <div class="inside">
                             <table>
                               <tr>
                                 <td>
                                     <h4 style="margin-top:0px" ><label><?php echo __( 'There are three ways to set cronjob.Please use only one','mass-email-to-users');?> </label></h4>
                                     <table>
                                         <tr>
                                             <td>
                                                 <b>   wget -q -O - <?php echo trim(get_site_url(),"/");?>/wp-cron.php?doing_wp_cron >/dev/null 2>&1 </b>
                                             </td>
                                         </tr>
                                         <tr>
                                             <td>
                                                 <br/>
                                                 <div><b><?php echo __( 'see example','mass-email-to-users');?></b></div>
                                                 <img src="<?php echo $imgUrl."cron1.png" ;?>" />
                                             </td>
                                         </tr>
                                     </table>
                                     <h1 style="left: 253px;margin-bottom: 0;margin-top: 0;position: relative;top: -23px;"><?php echo __( 'OR','mass-email-to-users');?></h1>
                                   
                                     <table>
                                         <tr>
                                             <td>
                                                 <b>   curl  <?php echo trim(get_site_url(),"/");?>/wp-cron.php?doing_wp_cron >/dev/null 2>&1 </b>
                                             </td>
                                         </tr>
                                         <tr>
                                             <td>
                                                 <br/>
                                                 <div><b><?php echo __( 'see example','mass-email-to-users');?></b></div>
                                                 <img src="<?php echo $imgUrl."cron2.png" ;?>" />
                                             </td>
                                         </tr>
                                     </table>
                                     <h1 style="left: 253px;margin-bottom: 0;margin-top: 0;position: relative;top: -23px;"><?php echo __( 'OR','mass-email-to-users');?></h1>
                                   
                                     <table>
                                         <tr>
                                             <td>
                                                 <b>  /usr/bin/php -f /home/user/public_html/wp-cron.php</b>
                                                 <br/>
                                                 <br/><b><?php echo __( 'It is just example.use your appropriate path','mass-email-to-users');?></b>
                                             </td>
                                         </tr>
                                         <tr>
                                             <td>
                                                 <br/>
                                                 <div><b><?php echo __( 'see example','mass-email-to-users');?></b></div>
                                                 <img src="<?php echo $imgUrl."cron3.png" ;?>" />
                                             </td>
                                         </tr>
                                     </table>
                                 </td>
                                
                               </tr>
                             </table>
                             <div style="clear:both"></div>
                         </div>
                      </div>
                     </fieldset>
                         <?php wp_nonce_field('action_settings_add_edit','add_edit_nonce'); ?>  
                          <input type="submit"  name="btnsave" id="btnsave" value="<?php echo __( 'Save Changes','mass-email-to-users');?>" class="button-primary">
                  
                  </form>
                    <script>    
                        
                        jQuery("#subscriptionFrmsettiings").validate({
                                           errorClass: "error_admin_massemail",
                                           rules: {
                                                          allowed_emails_per_hour: { 
                                                                required: true,
                                                                number:true
                                                          },
                                                           wait_time_between_two_emails: { 
                                                                required: true,
                                                                number:true
                                                          }

                                              }, 

                                                   errorPlacement: function(error, element) {
                                                   error.appendTo( element.next().next());
                                             }

                                        });




                        </script>  
                </div>
              </div>
            </div>
            </div>
        </div>
 </div>
<?php    
}

function ms_send_news_letter_func(){
    
    if(isset($_POST['savenewsletter'])){
            
            if ( !check_admin_referer( 'action_newsletter_add_edit','add_edit_template_nonce')){

                wp_die('Security check fail'); 
            }
            
            if ( ! current_user_can( 'wmeu_mass_email_send_newsletter' ) ) {

                wp_die( __( "Access Denied", "mass-email-to-users" ) );

             }
             
            $_POST = stripslashes_deep( $_POST );
            $subject=stripslashes($_POST['email_subject']);
            $subject=trim(htmlentities(sanitize_text_field($subject),ENT_QUOTES));
            $email_from_name=stripslashes($_POST['email_From_name']);
            $email_from_name=trim(htmlentities(sanitize_text_field($email_from_name),ENT_QUOTES));
            $email_from=trim(htmlentities(sanitize_text_field($_POST['email_From']),ENT_QUOTES));
            $content=trim($_POST['txtArea']);
            $createdOn=current_time('mysql');
           
            
            global $wpdb;
            $data=array();
            $data['subject']          =$subject;
            $data['email_from_name']  =$email_from_name;
            $data['email_from']       =$email_from;
            $data['content']          =htmlentities($content);
            $data['createdon']        =$createdOn;

            
            $wpdb->insert( $wpdb->prefix."sent_ms_newsletter", $data); 
            $inserted_id=$wpdb->insert_id;
            
            
            $query = 'SET SESSION group_concat_max_len=150000';
            $wpdb->query($query);

            $unscbscribersQuery="SELECT GROUP_CONCAT( user_id ) AS  `unsbscribers`
            FROM  $wpdb->usermeta
            WHERE  `meta_key` =  'is_unsubscibed' and meta_value='1'" ;

            $resultUnsb=$wpdb->get_results($unscbscribersQuery,'ARRAY_A');

            $unsubscriber_users=$resultUnsb[0]['unsbscribers'];

            if($unsubscriber_users=="" or $unsubscriber_users==null)
                   $unsubscriber_users=0;
            
            $queryStr='';
            if(isset($_POST['roles']) and $_POST['roles']!='' and $_POST['roles']!='null' and $_POST['roles']!=NULL and is_array($_POST['roles'])) {
                    $queryStr.=" and ( ";
                    $rolesArr=$_POST['roles'];
                    $count=1;
                    foreach($rolesArr as $rl){

                      $queryStr.=" t.meta_value like '%$rl%'   " ; 
                      if(is_array($rolesArr) && $count!=sizeof($rolesArr)){

                          $queryStr.=" or ";
                      }

                      $count++;
                    }

                $queryStr.="  ) ";

              }
              
            $QueryEmailQueue="insert into ".$wpdb->prefix."ms_email_log(news_letter_id,name,email,status,sent_on) "
                           . "select '$inserted_id',user_nicename as name,user_email as email,'1','0000-00-00' from ".$wpdb->prefix."users u ";
            
                
            if(isset($_POST['mlevels']) and $_POST['mlevels']!='' and $_POST['mlevels']!='null' and $_POST['mlevels']!=NULL){    

                $selectedMlevels=esc_sql(($_POST['mlevels']));
                $mlevels_comma= implode(",", $selectedMlevels);
        
              
                $QueryEmailQueue.=" join ".$wpdb->prefix."swpm_members_tbl mb on u.user_email=mb.email and mb.membership_level in($mlevels_comma) ";


              } 
                    
            $QueryEmailQueue.=" join $wpdb->usermeta t on u.id=t.user_id and t.meta_key='{$wpdb->prefix}capabilities' where ID NOT IN ($unsubscriber_users)";
            if($queryStr!=''){
                
                $QueryEmailQueue.=$queryStr;
            }
            $wpdb->query($QueryEmailQueue);
           
            $opt_activation_settings=get_option('ms_massmail_cron_settings'); 
            $allowed_emails_per_hour=$opt_activation_settings['allowed_emails_per_hour'];
            $how_many_emails=$allowed_emails_per_hour/12;
            $how_many_emails=intval($how_many_emails);
            
            $mass_email_email_template=array();
            $mass_email_email_template['type']='succ';
            $mass_email_email_template['message']=__( 'Sit back relax. All newsletter subscribers added into queue. Emails will be sent automatically via cronjob','mass-email-to-users');
            update_option('mass_email_email_template', $mass_email_email_template);
            
            $location='admin.php?page=ms_send_news_letter';
            echo "<script type='text/javascript'> location.href='$location';</script>";
            exit;
    }       
?>    
<h3><?php echo __( 'Send Email To Users','mass-email-to-users');?> </h3>  
<?php  $url = plugin_dir_url(__FILE__);    
 ?> 
 
 <form name="frmSendEmailsToUserSend" id='frmSendEmailsToUserSend' method="post" action="" >
<?php
    global $wpdb;            
    $messages=get_option('mass_email_email_template'); 
    $type='';
    $message='';
    if(isset($messages['type']) and $messages['type']!=""){

    $type=$messages['type'];
    $message=$messages['message'];

    }  

    if(trim($type)=='err'){ echo "<div class='notice notice-error is-dismissible'><p>"; echo $message; echo "</p></div>";}
    else if(trim($type)=='succ'){ echo "<div class='notice notice-success is-dismissible'><p>"; echo $message; echo "</p></div>";}


    update_option('mass_email_email_template', array());     
?> 
<style>
    .chosen-container{width: 240px !important;height: 36px}
</style>      
<table class="form-table" style="width:100%" >
<tbody>
    <tr valign="top" id="subject">
     <th scope="row" style="width:30%;text-align: right;"><?php echo __( 'Load Email Template','mass-email-to-users');?></th>
     <td>    
         <select name="loadtemplate" id="loadtemplate" >
             <option value=""></option>
             <?php
              global $wpdb;
                    $query="SELECT * FROM ".$wpdb->prefix."massmail_e_template order by createdon desc";
                    $rows=$wpdb->get_results($query);
                    $rowCount=sizeof($rows);
           
                    if($rowCount > 0){
                        
                        foreach ($rows as $row){ ?>
                            
                            <option value="<?php echo $row->id;?>"><?php echo $row->subject;?></option> 
                       <?php }
                        
                    }
             ?>       
         </select>   
         <?php
            $loadingUrl=plugins_url( 'images/ajax-loader.gif', __FILE__ ) ;
            
         ?>
         <img id="imgLoader" src="<?php echo $loadingUrl;?>" style="display:none" />
         <script>

            function stripslashes(str) {
               str=str.replace(/\\'/g,'\'');
               str=str.replace(/\\"/g,'"');
               str=str.replace(/\\0/g,'\0');
               str=str.replace(/\\\\/g,'\\');
              return str;
            }

        
        
         </script>
      </td>
   </tr> 
  <tr valign="top" id="subject">
     <th scope="row" style="width:30%;text-align: right;"><?php echo __( 'Role(s)','mass-email-to-users');?> *</th>
     <td>    
        <select data-placeholder="<?php echo __('All Roles','mass-email-to-users');?>" multiple=""  name="roles[]" id="roles" style="vertical-align:baseline">
           <?php $roles=i13_mass_email_get_editable_roles();?> 
           <?php foreach($roles as $k=>$role):?>
                <option  value="<?php echo $k;?>"><?php echo $role['name'];?></option> 
            <?php endforeach;?>
        </select>
        <div style="clear: both;"></div><div></div>
      </td>
   </tr>
   
   <?php if(i13_mass_email_check_simple_membership_plugin_active() && sizeof(i13_mass_email_check_simple_membership_get_levels())>0):?>
    <?php $Mlevels=i13_mass_email_check_simple_membership_get_levels();?>
    <tr valign="top" id="mlevels_tr">
        <th scope="row" style="width:30%;text-align: right;"><?php echo __( 'Membership Level(s)','mass-email-to-users');?> </th>
    
     <td>
         <select data-placeholder="<?php echo __('All Membership Levels','mass-email-to-users');?>" multiple=""  name="mlevels[]" id="mlevels" style="vertical-align:baseline"><?php foreach($Mlevels as $l=>$lvl):?><option value="<?php echo $l;?>"><?php echo $lvl;?></option> <?php endforeach;?></select>&nbsp;
     </td>
    </tr>
<?php endif;?>
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
     <th scope="row" style="width:30%;text-align: right"><?php echo __( 'Email Body','mass-email-to-users');?> *</th>
     <td>    
       
       <div class="wrap">
       <?php
            // wp_editor('',"email_body", array('textarea_rows'=>12, 'editor_class'=>'ckeditor'));
         wp_editor( '', 'txtArea' );

         ?> 
       <input type="hidden" name="editor_val" id="editor_val" />  
        <div style="clear: both;"></div><div></div> 
        <?php echo __( 'You can use [user_full_name],[user_email],[unsubscribe_link_plain],[unsubscribe_link_html]','mass-email-to-users');?> 
        <?php $selected=array();?>
                <?php $options=get_option('buddypress_fields');
                if($options!=false){
                    
                    $selected= json_decode($options,true);
                }
                  
                 if (function_exists('bp_is_active') && bp_is_active( 'xprofile' ) ){
                     
                    $query="SELECT * FROM ".$wpdb->prefix."bp_xprofile_groups";
                    $results=$wpdb->get_results($query,ARRAY_A);
                    
                    if(is_array($results) && sizeof($results)>0 && is_array($selected) && sizeof($selected)>0){
                        
                    ?>
                    <?php

                        foreach($results as $res){


                                ?>
                               <?php if (function_exists('bp_is_active') && bp_is_active( 'xprofile' ) ) : if ( bp_has_profile( array( 'profile_group_id' => $res['id'], 'fetch_field_data' => false ) ) ) : while ( bp_profile_groups() ) : bp_the_profile_group(); ?>

                                    <?php while ( bp_profile_fields() ) : bp_the_profile_field(); ?>
                                        <?php global $field;?>

                                      
                                                     <?php if(isset($selected[$field->id]) && isset($selected[$field->id]['list']) && $selected[$field->id]['list']==1):?>
                                                       ,[<?php bp_the_profile_field_name(); ?>]
                                                     <?php endif;?>   
                                        

                                <?php endwhile; ?>


                               <?php endwhile; endif; endif; ?>

                        <?php }
                        
                        }
                       
                        
                
                        }?>
                        <?php echo __( ' place holder into email content','mass-email-to-users');?> 
       </div>
      </td>
   </tr>
 
   <tr valign="top" id="subject">
     <th scope="row" style="width:30%"></th>
     <td> 
        <?php wp_nonce_field('action_newsletter_add_edit','add_edit_template_nonce'); ?>  
       <input type='submit'  value='<?php echo __( 'Send Newsletter','mass-email-to-users');?>' name='savenewsletter' class='button-primary' id='savenewsletter' >  
      </td>
   </tr>
   
</table>
</form>
<script type="text/javascript">

 
 jQuery(document).ready(function() {

jQuery.validator.addMethod("chkCont", function(value, element) {
                                            
                                              

              var editorcontent=tinyMCE.get('txtArea').getContent();

              if (editorcontent.length){
                return true;
              }
              else{
                 return false;
              }
         

        },
             "Please enter email content"
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
                                editor_val:{
                                    chkCont: true 
                                 }  
                            
                       }, 
      
                            errorPlacement: function(error, element) {
                            error.appendTo( element.next().next());
                      }
                      
                 });
                      
   jQuery(function () {
        jQuery("#roles").chosen();
        if(jQuery("#mlevels").length>0){
            jQuery("#mlevels").chosen();
        }
    });                      
  });
  
  
   jQuery(document).ready(function() {
            
          // tinymce.on('addeditor', function( event ) {


            jQuery( "#loadtemplate" ).change(function() {
                
               
                 var data = {
                                'action': 'getEmailTemplate_massmail',
                                'templateId':jQuery( "#loadtemplate" ).val() 
                        };


                      if(jQuery( "#loadtemplate" ).val()!=''){
                        
                        jQuery("#imgLoader").show();
                        jQuery("#txtArea-tmce").trigger('click');
                        setTimeout(function(){ 
                                jQuery.ajax({
                                   type: "GET",
                                   dataType: "json",
                                   url: ajaxurl, 
                                   data: data,
                                   success: function(response) {


                                      obj = jQuery.parseJSON(JSON.stringify(response));
                                      decoded_sub = jQuery("<div/>").html(obj.subject).text();
                                      decoded_email_from_name = jQuery("<div/>").html(obj.email_from_name).text();

                                       jQuery("#email_subject").val(decoded_sub);
                                       jQuery("#email_From_name").val(decoded_email_from_name);

                                       jQuery("#email_From").val(obj.email_from);

                                       var decoded = stripslashes(jQuery('<div/>').html(obj.content).text());
                                       jQuery( "#txtArea-html" ).trigger( "click" );
                                       jQuery(".wp-editor-area").val(obj.content);
                                     
                                     //  tinyMCE.activeEditor.setContent(decoded);
                                      // jQuery( "#txtArea-html" ).trigger( "click" );
                                      // jQuery('#txtArea').html(decoded);
                                       jQuery( "#txtArea-tmce" ).trigger( "click" );

                                     //  CKEDITOR.instances['txtArea'].setData(decoded);

                                       jQuery("#imgLoader").hide();

                                   }
                                 });
                      
                              }, 1000);
                         
                     }
                     else{
                         
                          jQuery("#email_subject").val('');
                          jQuery("#email_From_name").val('');
                          jQuery("#email_From").val('');
                          jQuery("#email_From").val('');
                          jQuery("#txtArea").val('');
                     }
            
                });
            
             //}, true );
        });    
 
 </script> 
<?php
}
function mass_mail_newsletters_log_func(){
    
     if ( ! current_user_can( 'wmeu_mass_email_view_newsletter_log' ) ) {

        wp_die( __( "Access Denied", "email-subscribe" ) );

     }
     
     $action='gridview';
      if(isset($_GET['action']) and $_GET['action']!=''){
        
         $action=trim($_GET['action']);       
      }                    
      if(strtolower($action)==strtolower('gridview')){ 
      
      
      ?>
      <div class="wrap">
       <div style="width: 100%;">  
        <div style="float:left;width:90%;" >
       <?php
                
                $messages=get_option('mass_email_email_template'); 
                $type='';
                $message='';
                if(isset($messages['type']) and $messages['type']!=""){

                $type=$messages['type'];
                $message=$messages['message'];

                }  

                if(trim($type)=='err'){ echo "<div class='notice notice-error is-dismissible'><p>"; echo $message; echo "</p></div>";}
                else if(trim($type)=='succ'){ echo "<div class='notice notice-success is-dismissible'><p>"; echo $message; echo "</p></div>";}


                update_option('mass_email_email_template', array());     
          ?>    
        <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
        <h2><?php echo __( 'Newsletter Log','mass-email-to-users');?> </h2>
        <br/>    
         <?php

            $setacrionpage='admin.php?page=mass_mail_newsletters_log';

            if(isset($_GET['order_by']) and $_GET['order_by']!=""){
             $setacrionpage.='&order_by='.$_GET['order_by'];   
            }

            if(isset($_GET['order_pos']) and $_GET['order_pos']!=""){
             $setacrionpage.='&order_pos='.$_GET['order_pos'];   
            }

            $seval="";
            if(isset($_GET['search_term']) and $_GET['search_term']!=""){
             $seval=trim($_GET['search_term']);   
            }

        ?>
        <form method="POST" action="admin.php?page=mass_mail_newsletters_log&action=deleteselected"  id="posts-filter" onkeypress="return event.keyCode != 13;">
              <div class="alignleft actions">
                <select name="action_upper" id="action_upper">
                    <option selected="selected" value="-1"><?php echo __( 'Bulk Actions','mass-email-to-users');?></option>
                    <option value="delete"><?php echo __( 'delete','mass-email-to-users');?></option>
                </select>
                <input type="submit" value="<?php echo __( 'Apply','mass-email-to-users');?>" class="button-secondary action" id="deleteselected" name="deleteselected" onclick="return confirmDelete_bulk();">
            </div>
         <br/>
         <br/>
         <br class="clear">
         <?php
            global $wpdb;

            $order_by='id';
            $order_pos="asc";

            if(isset($_GET['order_by'])){

               $order_by=trim($_GET['order_by']); 
            }

            if(isset($_GET['order_pos'])){

               $order_pos=trim($_GET['order_pos']); 
            }
             $search_term='';
            if(isset($_GET['search_term'])){

               $search_term= sanitize_text_field(esc_sql($_GET['search_term']));
            }

            $search_term_='';
             if(isset($_GET['search_term'])){

                $search_term_='&search_term='.urlencode(sanitize_text_field($_GET['search_term']));
             }


            $query = "SELECT * FROM " . $wpdb->prefix . "sent_ms_newsletter ";
            $queryCount = "SELECT count(*) FROM " . $wpdb->prefix . "sent_ms_newsletter ";
            if($search_term!=''){
               $query.=" where id like '%$search_term%' or subject like '%$search_term%' "; 
               $queryCount.=" where id like '%$search_term%' or subject like '%$search_term%' "; 
            }


            $order_by=sanitize_text_field(sanitize_sql_orderby($order_by));
            $order_pos=sanitize_text_field(sanitize_sql_orderby($order_pos));

            $query.=" order by $order_by $order_pos";

            $rowsCount=$wpdb->get_var($queryCount);



            ?>
            <div style="padding-top:5px;padding-bottom:5px">
               <b><?php echo __( 'Search','mass-email-to-users');?> : </b>
                 <input type="text" value="<?php echo $seval;?>" id="search_term" name="search_term">&nbsp;
                 <input type='button'  value='<?php echo __( 'Search','mass-email-to-users');?>' name='searchusrsubmit' class='button-primary' id='searchusrsubmit' onclick="SearchredirectTO();" >&nbsp;
                 <input type='button'  value='<?php echo __( 'Reset Search','mass-email-to-users');?>' name='searchreset' class='button-primary' id='searchreset' onclick="ResetSearch();" >
           </div>  
           <script type="text/javascript" >
              
               jQuery('#search_term').on("keyup", function(e) {
                      if (e.which == 13) {

                          SearchredirectTO();
                      }
                 });   
            function SearchredirectTO(){
              var redirectto='<?php echo $setacrionpage; ?>';
              var searchval=jQuery('#search_term').val();
              redirectto=redirectto+'&search_term='+jQuery.trim(encodeURIComponent(searchval));  
              window.location.href=redirectto;
            }
           function ResetSearch(){

                var redirectto='<?php echo $setacrionpage; ?>';
                window.location.href=redirectto;
                exit;
           }
           </script>
         <div id="no-more-tables">
              <table cellspacing="0" id="gridTbl" class="table-bordered table-striped table-condensed cf" >
            <thead>
                <tr>
                    <th class="manage-column column-cb check-column" scope="col"><input type="checkbox"></th>
                     <?php if($order_by=="id" and $order_pos=="asc"):?>
                        <th><a href="<?php echo $setacrionpage;?>&order_by=id&order_pos=desc<?php echo $search_term_;?>"><?php echo __('Id','mass-email-to-users');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/desc.png', __FILE__); ?>"/></a></th>
                   <?php else:?>
                       <?php if($order_by=="id"):?>
                            <th><a href="<?php echo $setacrionpage;?>&order_by=id&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Id','mass-email-to-users');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/asc.png', __FILE__); ?>"/></a></th>
                       <?php else:?>
                           <th><a href="<?php echo $setacrionpage;?>&order_by=id&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Id','mass-email-to-users');?></a></th>
                       <?php endif;?>    
                   <?php endif;?> 

                   <?php if($order_by=="subject" and $order_pos=="asc"):?>
                        <th><a href="<?php echo $setacrionpage;?>&order_by=subject&order_pos=desc<?php echo $search_term_;?>"><?php echo __('Subject','mass-email-to-users');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/desc.png', __FILE__); ?>"/></a></th>
                   <?php else:?>
                       <?php if($order_by=="subject"):?>
                            <th><a href="<?php echo $setacrionpage;?>&order_by=subject&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Subject','mass-email-to-users');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/asc.png', __FILE__); ?>"/></a></th>
                       <?php else:?>
                           <th><a href="<?php echo $setacrionpage;?>&order_by=subject&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Subject','mass-email-to-users');?></a></th>
                       <?php endif;?>    
                   <?php endif;?> 
                    <?php if($order_by=="createdon" and $order_pos=="asc"):?>
                        <th><a href="<?php echo $setacrionpage;?>&order_by=createdon&order_pos=desc<?php echo $search_term_;?>"><?php echo __('Created On','mass-email-to-users');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/desc.png', __FILE__); ?>"/></a></th>
                    <?php else:?>
                        <?php if($order_by=="createdon"):?>
                    <th><a href="<?php echo $setacrionpage;?>&order_by=createdon&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Created On','mass-email-to-users');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/asc.png', __FILE__); ?>"/></a></th>
                        <?php else:?>
                            <th><a href="<?php echo $setacrionpage;?>&order_by=createdon&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Created On','mass-email-to-users');?></a></th>
                        <?php endif;?>    
                    <?php endif;?>
                            
                    <th><span><?php echo __( 'Email Log','mass-email-to-users');?></span></th>
                    <th><span><?php echo __( 'Delete','mass-email-to-users');?></span></th>
                </tr>  
           </thead>
            <tbody id="the-list">
                   <?php
                   
                    if($rowsCount > 0){
                    
                            global $wp_rewrite;
                            $rows_per_page = 10;
                            
                            $current = (isset($_GET['paged'])) ? (intval($_GET['paged'])) : 1;
                            $pagination_args = array(
                            'base' => @add_query_arg('paged','%#%'),
                            'format' => '',
                            'total' => ceil($rowsCount/$rows_per_page),
                            'current' => $current,
                            'show_all' => false,
                            'type' => 'plain',
                           );
                            
                          
                           $offset = ($current - 1) * $rows_per_page;
                           $query.=" limit $offset, $rows_per_page";
                           $rows = $wpdb->get_results ( $query);
                         
                           $delRecNonce=wp_create_nonce('delete_template');           
                           foreach($rows as $row ) {
                               
                               $id=$row->id;
                               $editlink="admin.php?page=mass_mail_newsletters_log&action=email_log&id=$id";
                               $deletelink="admin.php?page=mass_mail_newsletters_log&action=delete&id=$id&nonce=$delRecNonce";
                               
                            ?>
                              <tr valign="top" >
                                <td class="alignCenter check-column"   data-title="<?php echo __( 'Select Record','mass-email-to-users');?>" ><input type="checkbox" value="<?php echo $row->id ?>" name="newsletters[]"></td>
                                <td class="alignCenter"   data-title="<?php echo __( 'Id','mass-email-to-users');?>"><?php echo $row->id; ?></td>
                                <td class="alignCenter"   data-title="<?php echo __( 'Subject','mass-email-to-users');?>" ><strong><?php echo $row->subject; ?></strong></td>  
                                <td class="alignCenter"   data-title="<?php echo __( 'Created On','mass-email-to-users');?>" ><strong><?php echo $row->createdon; ?></strong></td>  
                                <td class="alignCenter"   data-title="<?php echo __( 'Click To View Log','mass-email-to-users');?>"><strong><a href='<?php echo $editlink; ?>' title="<?php echo __( 'Click To View Log','mass-email-to-users');?>"><?php echo __( 'Click To View Log','mass-email-to-users');?></a></strong></td>  
                                <td class="alignCenter"   data-title="<?php echo __( 'Delete','mass-email-to-users');?>"><strong><a href='<?php echo $deletelink; ?>' onclick="return confirmDelete();"  title="<?php echo __( 'Delete','mass-email-to-users');?>"><?php echo __( 'Delete','mass-email-to-users');?></a> </strong></td>  
                            </tr>
                          
                     <?php 
                             } 
                    }
                   else{
                       ?>
                       <tr valign="top" class="" id="">
                            <td colspan="6" data-title="<?php echo __( 'No Records','mass-email-to-users');?>" align="center"><strong><?php echo __( 'No Newsletter Logs','mass-email-to-users');?></strong></td>  
                        </tr>
                  <?php 
                   } 
                 ?>      
        </tbody>
  </table>
         </div> 
  <?php
    if($rowsCount>0){
     echo "<div class='pagination' style='padding-top:10px'>";
     echo paginate_links($pagination_args);
     echo "</div>";
    }
  ?>
    
    <div class="alignleft actions">
        <select name="action" id="action_bottom">
            <option selected="selected" value="-1"><?php echo __( 'Bulk Actions','mass-email-to-users');?></option>
            <option value="delete"><?php echo __( 'Delete','mass-email-to-users');?></option>
        </select>
        <?php wp_nonce_field('action_newsletter_mass_delete','mass_delete_nonce'); ?>
        <input type="submit" value="<?php echo __( 'Apply','mass-email-to-users');?>" class="button-secondary action" id="deleteselected" name="deleteselected" onclick="return confirmDelete_bulk();">
    </div>

    </form>
        <script type="text/JavaScript">

        function  confirmDelete_bulk(){
                var topval=document.getElementById("action_bottom").value;
                var bottomVal=document.getElementById("action_upper").value;

                if(topval=='delete' || bottomVal=='delete'){


                    var agree=confirm("<?php echo __( 'Are you sure you want to delete selected newsletter ? It will also delete email log for selected newsletters','mass-email-to-users');?>");
                    if (agree)
                        return true ;
                    else
                        return false;
                }
            }
            
        function  confirmDelete(){
                
            var agree=confirm("<?php echo __( 'Are you sure you want to delete this newsletter ? It will also delete email log for this newsletters','mass-email-to-users');?>");
            if (agree)
                 return true ;
            else
                 return false;
         }
     </script>

        <br class="clear">
        </div>
        <div style="clear: both;"></div>
        <?php $url = plugin_dir_url(__FILE__);  ?>
      </div>  
    </div>  
    <div class="clear"></div> 
     <?php  
      } 
      else if(strtolower($action)==strtolower('email_log')){ ?>
    <div class="wrap">
        <?php
        $url = plugin_dir_url(__FILE__); 
        $url = str_replace("\\","/",$url); 
       ?>       
                                                                                
       
          
       <div style="width: 100%;">  
        <div style="float:left;width:90%;" >
       <?php
                
                $messages=get_option('mass_email_email_template'); 
                $type='';
                $message='';
                if(isset($messages['type']) and $messages['type']!=""){

                $type=$messages['type'];
                $message=$messages['message'];

                }  

                 if(trim($type)=='err'){ echo "<div class='notice notice-error is-dismissible'><p>"; echo $message; echo "</p></div>";}
                else if(trim($type)=='succ'){ echo "<div class='notice notice-success is-dismissible'><p>"; echo $message; echo "</p></div>";}


                update_option('mass_email_email_template', array());  
                
                
                global $wpdb;  
                $newsletterId=(int) htmlentities(sanitize_text_field($_GET['id']),ENT_QUOTES);
                $query = 'SELECT * FROM '.$wpdb->prefix."sent_ms_newsletter where id=$newsletterId"; 
                $myrow  = $wpdb->get_row($query);
                
                
                
          ?>  
            
        <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
        <h2><?php echo __( 'Email Log For : ','mass-email-to-users');?><?php echo $myrow->subject;?></h2>
        <?php if(is_object($myrow)){ 
        
         $setacrionpage='admin.php?page=mass_mail_newsletters_log&action=email_log&id='.$myrow->id;
        
         
           if(isset($_GET['entrant']) and $_GET['entrant']!=""){
               $setacrionpage.='&entrant='.$_GET['entrant'];   
           }

           if(isset($_GET['setPerPage']) and $_GET['setPerPage']!=""){
               $setacrionpage.='&setPerPage='.$_GET['setPerPage'];   
           }

           $seval="";
           if(isset($_GET['searchstatus']) and $_GET['searchstatus']!=""){
               $seval=trim($_GET['searchstatus']);   
           }

            $order_by='id';
            $order_pos="asc";

            if(isset($_GET['order_by'])){

               $order_by=trim($_GET['order_by']); 
            }

            if(isset($_GET['order_pos'])){

               $order_pos=trim($_GET['order_pos']); 
            }
            
            $search_term_='';
            if(isset($_GET['searchstatus'])){

               $search_term_='&searchstatus='.urlencode(sanitize_text_field($_GET['searchstatus']));
            }
       ?>  
        <div style="padding-top:5px;padding-bottom:5px"><b><?php echo __( 'Filter By Status','mass-email-to-users');?> : </b>
            <select type="text" id="searchstatus" name="searchstatus">
                <option value=""><?php echo __( 'Select ...','mass-email-to-users');?></option>
                <option value="1" <?php if($seval=='1'):?> selected="selected"<?php endif;?> ><?php echo __( 'In Queue','mass-email-to-users');?></option>
                <option value="2" <?php if($seval=='2'):?> selected="selected"<?php endif;?> ><?php echo __( 'Sent Successfully','mass-email-to-users');?></option>
                <option value="3" <?php if($seval=='3'):?> selected="selected"<?php endif;?> ><?php echo __( 'Fail','mass-email-to-users');?></option>
            </select>
            &nbsp;<input type='submit'  value='<?php echo __( 'Filter By Status','mass-email-to-users');?>' name='searchusrsubmit' class='button-primary' id='searchusrsubmit' onclick="SearchredirectTO();" >&nbsp;<input type='submit'  value='<?php echo __( 'Reset Search','mass-email-to-users');?>' name='searchreset' class='button-primary' id='searchreset' onclick="ResetSearch();" ></div>  
        <script type="text/javascript" >
         function SearchredirectTO(){
           var redirectto='<?php echo $setacrionpage; ?>';
           var searchval=jQuery('#searchstatus').val();
           redirectto=redirectto+'&searchstatus='+jQuery.trim(encodeURIComponent(searchval));    
           window.location.href=redirectto;
         }
        function ResetSearch(){

             var redirectto='<?php echo $setacrionpage; ?>';
             window.location.href=redirectto;
             exit;
        }
        </script>
                   
        <form method="POST" action="admin.php?page=mass_mail_newsletters_log&action=deleteselected"  id="posts-filter">
             
         <br class="clear">
         <div id="no-more-tables">
              <table cellspacing="0" id="gridTbl" class="table-bordered table-striped table-condensed cf" >
            <thead>
                <tr>
                   <?php if($order_by=="id" and $order_pos=="asc"):?>
                        <th><a href="<?php echo $setacrionpage;?>&order_by=id&order_pos=desc<?php echo $search_term_;?>"><?php echo __('Id','mass-email-to-users');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/desc.png', __FILE__); ?>"/></a></th>
                   <?php else:?>
                       <?php if($order_by=="id"):?>
                            <th><a href="<?php echo $setacrionpage;?>&order_by=id&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Id','mass-email-to-users');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/asc.png', __FILE__); ?>"/></a></th>
                       <?php else:?>
                           <th><a href="<?php echo $setacrionpage;?>&order_by=id&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Id','mass-email-to-users');?></a></th>
                       <?php endif;?>    
                   <?php endif;?> 
                    
                   <?php if($order_by=="name" and $order_pos=="asc"):?>
                        <th><a href="<?php echo $setacrionpage;?>&order_by=name&order_pos=desc<?php echo $search_term_;?>"><?php echo __('Name','mass-email-to-users');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/desc.png', __FILE__); ?>"/></a></th>
                   <?php else:?>
                       <?php if($order_by=="name"):?>
                            <th><a href="<?php echo $setacrionpage;?>&order_by=name&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Name','mass-email-to-users');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/asc.png', __FILE__); ?>"/></a></th>
                       <?php else:?>
                           <th><a href="<?php echo $setacrionpage;?>&order_by=name&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Name','mass-email-to-users');?></a></th>
                       <?php endif;?>    
                   <?php endif;?> 
                           
                    <?php if($order_by=="email" and $order_pos=="asc"):?>
                        <th><a href="<?php echo $setacrionpage;?>&order_by=email&order_pos=desc<?php echo $search_term_;?>"><?php echo __('Name','mass-email-to-users');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/desc.png', __FILE__); ?>"/></a></th>
                   <?php else:?>
                       <?php if($order_by=="email"):?>
                            <th><a href="<?php echo $setacrionpage;?>&order_by=email&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Name','mass-email-to-users');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/asc.png', __FILE__); ?>"/></a></th>
                       <?php else:?>
                           <th><a href="<?php echo $setacrionpage;?>&order_by=email&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Name','mass-email-to-users');?></a></th>
                       <?php endif;?>    
                   <?php endif;?> 
                           
                    <?php if($order_by=="status" and $order_pos=="asc"):?>
                        <th><a href="<?php echo $setacrionpage;?>&order_by=status&order_pos=desc<?php echo $search_term_;?>"><?php echo __('Status','mass-email-to-users');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/desc.png', __FILE__); ?>"/></a></th>
                   <?php else:?>
                       <?php if($order_by=="status"):?>
                            <th><a href="<?php echo $setacrionpage;?>&order_by=status&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Status','mass-email-to-users');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/asc.png', __FILE__); ?>"/></a></th>
                       <?php else:?>
                           <th><a href="<?php echo $setacrionpage;?>&order_by=status&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Status','mass-email-to-users');?></a></th>
                       <?php endif;?>    
                   <?php endif;?> 
                           
                    <?php if($order_by=="sent_on" and $order_pos=="asc"):?>
                        <th><a href="<?php echo $setacrionpage;?>&order_by=sent_on&order_pos=desc<?php echo $search_term_;?>"><?php echo __('Sent On','mass-email-to-users');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/desc.png', __FILE__); ?>"/></a></th>
                   <?php else:?>
                       <?php if($order_by=="sent_on"):?>
                            <th><a href="<?php echo $setacrionpage;?>&order_by=sent_on&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Sent On','mass-email-to-users');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/asc.png', __FILE__); ?>"/></a></th>
                       <?php else:?>
                           <th><a href="<?php echo $setacrionpage;?>&order_by=sent_on&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Sent On','mass-email-to-users');?></a></th>
                       <?php endif;?>    
                   <?php endif;?> 
                           
                
                    
                </tr>  
           </thead>
            <tbody id="the-list">
                   <?php
                    global $wpdb;
                    if($seval!=''){
                         $seval=(int) $seval;
                         $query="SELECT * FROM ".$wpdb->prefix."ms_email_log where news_letter_id=$newsletterId and status=$seval ";
                         $queryCount="SELECT count(*) FROM ".$wpdb->prefix."ms_email_log where news_letter_id=$newsletterId and status=$seval ";
                    }
                    else{
                        
                         $query="SELECT * FROM ".$wpdb->prefix."ms_email_log where news_letter_id=$newsletterId ";
                         $queryCount="SELECT count(*) FROM ".$wpdb->prefix."ms_email_log where news_letter_id=$newsletterId ";
                    }
                   
                    $order_by=sanitize_text_field(sanitize_sql_orderby($order_by));
                    $order_pos=sanitize_text_field(sanitize_sql_orderby($order_pos));

                    $query.=" order by $order_by $order_pos";

                    $rowsCount=$wpdb->get_var($queryCount);

           
                    if($rowsCount > 0){
                    
                            global $wp_rewrite;
                            $rows_per_page = 50;
                            
                            $current = (isset($_GET['paged'])) ? (intval($_GET['paged'])) : 1;
                            $pagination_args = array(
                            'base' => @add_query_arg('paged','%#%'),
                            'format' => '',
                            'total' => ceil($rowsCount/$rows_per_page),
                            'current' => $current,
                            'show_all' => false,
                            'type' => 'plain',
                           );
                            
                          
                            $offset = ($current - 1) * $rows_per_page;
                                            
                            $query.=" limit $offset, $rows_per_page";
                            $rows = $wpdb->get_results ( $query);
                         
                           foreach($rows as $row ) {
                               
                               $id=$row->id;
                               
                            ?>
                              <tr valign="top" >
                                <td class="alignCenter"   data-title="<?php echo __( 'Id','mass-email-to-users');?>"><?php echo $row->id; ?></td>
                                <td class="alignCenter"   data-title="<?php echo __( 'Name','mass-email-to-users');?>" ><strong><?php echo $row->name; ?></strong></td>  
                                <td class="alignCenter"   data-title="<?php echo __( 'Email','mass-email-to-users');?>" ><strong><?php echo $row->email; ?></strong></td>  
                                <td class="alignCenter"   data-title="<?php echo __( 'Status','mass-email-to-users');?>"><strong><?php if($row->status==1){ echo __( 'In Queue','mass-email-to-users'); }else if($row->status==2){ echo __( 'Sent Successfully','mass-email-to-users');}else if($row->status==3){ echo __( 'Fail','mass-email-to-users');} ?></strong></td>  
                                <td class="alignCenter"   data-title="<?php echo __( 'Sent On','mass-email-to-users');?>"><strong><?php if(strtotime($row->sent_on) == strtotime('0000-00-00 00:00:00')){ echo "-"; }else{ echo $row->sent_on;} ?></strong></td>  
                              
                            </tr>
                          
                     <?php 
                             } 
                    }
                   else{
                       ?>
                       <tr valign="top" class="" id="">
                            <td colspan="6" data-title="<?php echo __( 'No Records','mass-email-to-users');?>" align="center"><strong><?php echo __( 'No Newsletter Logs','mass-email-to-users');?></strong></td>  
                        </tr>
                  <?php 
                   } 
                 ?>      
        </tbody>
  </table>
         </div> 
  <?php
    if($rowsCount>0){
     echo "<div class='pagination' style='padding-top:10px'>";
     echo paginate_links($pagination_args);
     echo "</div>";
    }
  ?>
   
    </form>
        <script type="text/JavaScript">

        function  confirmDelete_bulk(){
                var topval=document.getElementById("action_bottom").value;
                var bottomVal=document.getElementById("action_upper").value;

                if(topval=='delete' || bottomVal=='delete'){


                    var agree=confirm("<?php echo __( 'Are you sure you want to delete selected newsletter ? It will also delete email log for selected newsletters','mass-email-to-users');?>");
                    if (agree)
                        return true ;
                    else
                        return false;
                }
            }
            
        function  confirmDelete(){
                
            var agree=confirm("<?php echo __( 'Are you sure you want to delete this newsletter ? It will also delete email log for this newsletters','mass-email-to-users');?>");
            if (agree)
                 return true ;
            else
                 return false;
         }
     </script>

        <br class="clear">
        <?php }?>
        </div>
        <div style="clear: both;"></div>
        <?php $url = plugin_dir_url(__FILE__);  ?>
      </div>  
    </div>  
    <div class="clear"></div> 
 <?php
      }
     else if(strtolower($action)==strtolower('delete')){
               
               $retrieved_nonce = '';
            
                if(isset($_GET['nonce']) and $_GET['nonce']!=''){

                    $retrieved_nonce=$_GET['nonce'];

                }
                if (!wp_verify_nonce($retrieved_nonce, 'delete_template' ) ){


                    wp_die('Security check fail'); 
                }
                
               global $wpdb;
               $location="admin.php?page=mass_mail_newsletters_log";
               $deleteId=(int) htmlentities(strip_tags($_GET['id']),ENT_QUOTES);
                    
                    try{
                             
                        
                            
                        
                        
                           $query = "delete from  ".$wpdb->prefix."ms_email_log where news_letter_id=$deleteId";
                           $wpdb->query($query); 
                       
                           $query = "delete from  ".$wpdb->prefix."sent_ms_newsletter where id=$deleteId";
                           $wpdb->query($query); 
                       
                           $mass_email_email_template=array();
                           $mass_email_email_template['type']='succ';
                           $mass_email_email_template['message']=__( 'Newsletter and email log deleted successfully.','mass-email-to-users');
                           update_option('mass_email_email_template', $mass_email_email_template);    

         
                     }
                   catch(Exception $e){
                   
                          $mass_email_email_template=array();
                          $mass_email_email_template['type']='err';
                          $mass_email_email_template['message']=__( 'Error while deleting Newsletter.','mass-email-to-users');
                          update_option('mass_email_email_template', $mass_email_email_template);
                    }  
                              
              
              echo "<script type='text/javascript'> location.href='$location';</script>";
              exit;
                  
      }  
      else if(strtolower($action)==strtolower('deleteselected')){
          
              if(!check_admin_referer('action_newsletter_mass_delete','mass_delete_nonce')){

                    wp_die('Security check fail'); 
                }
            
               global $wpdb; 
               $location="admin.php?page=mass_mail_newsletters_log";
               if(isset($_POST) and isset($_POST['deleteselected']) and  ( $_POST['action']=='delete' or $_POST['action_upper']=='delete')){
              
                    if(is_array($_POST['newsletters']) && sizeof($_POST['newsletters']) >0){
                    
                            $deleteto=$_POST['newsletters'];
                            $implode=implode(',',$deleteto);   
                            
                            try{
                                    
                                   foreach($deleteto as $deleteId){ 
                                            
                                       $deleteId=intval($deleteId);
                                        $query = "delete from  ".$wpdb->prefix."ms_email_log where news_letter_id=$deleteId";
                                        $wpdb->query($query); 

                                        $query = "delete from  ".$wpdb->prefix."sent_ms_newsletter where id=$deleteId";
                                        $wpdb->query($query); 

                                      
                                   }
                                   $mass_email_email_template=array();
                                   $mass_email_email_template['type']='succ';
                                   $mass_email_email_template['message']=__( 'Selected newsletter and its email logs deleted successfully.','mass-email-to-users');
                                   update_option('mass_email_email_template', $mass_email_email_template);    
                 
                             }
                           catch(Exception $e){
                           
                                  $mass_email_email_template=array();
                                  $mass_email_email_template['type']='err';
                                  $mass_email_email_template['message']=__( 'Error while deleting newsletter.','mass-email-to-users');
                                  update_option('mass_email_email_template', $mass_email_email_template);
                            }  
                                  
                           
                           echo "<script type='text/javascript'> location.href='$location';</script>";
                           exit;
                    
                    
                    }
                    else{
                    
                        
                        echo "<script type='text/javascript'> location.href='$location';</script>";   
                        exit;
                    }
                
               }
               else{
                     
                     echo "<script type='text/javascript'> location.href='$location';</script>";      
                     exit;
               }
         
          }      
      
    
}

function i13_buddypress_fieldslist(){
   
    global $wpdb;
    
    if(isset($_POST) && sizeof($_POST)>0 && isset($_POST['field'])){
        
      if(isset($_POST) && sizeof($_POST)>0 && isset($_POST['grp'])){
           
          $options=json_encode($_POST['grp'])  ;
          update_option( 'buddypress_groups', $options);
      } 
      else{
          
          $options=json_encode(array())  ;
          update_option( 'buddypress_groups', $options);
      }
      
      $options=json_encode($_POST['field'])  ;
      update_option( 'buddypress_fields', $options);
      update_option( 'mass_email_succ', __( 'Selected options updated successfully.','mass-email-to-users') );
        
    }
    else if(isset($_POST) && sizeof($_POST)>0 && isset($_POST['grp'])){
           
          $options=json_encode($_POST['grp'])  ;
          update_option( 'buddypress_groups', $options);
          
          $options=json_encode(array())  ;
         update_option( 'buddypress_fields', $options);
   
    } 
    else if(isset($_POST) && sizeof($_POST)>0){
        
        $options=json_encode(array())  ;
        update_option( 'buddypress_fields', $options);
        
        $options=json_encode(array())  ;
        update_option( 'buddypress_groups', $options);
   
    }
    
?>
<br/>    
<br/>    
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
<h3><?php echo __( 'Select BuddyPress Fields you want to show in filters and list','mass-email-to-users');?></h3>    
<form method="post" action="" id="sendemail" name="sendemail">

          
          <table class="widefat fixed" cellspacing="0" style="width:97% !important" >
            <thead>
            <tr>

                    <th><?php echo __( 'Field','mass-email-to-users');?></th>
                    <th><input  type="checkbox" name="chkallList" id='chkallList'>&nbsp; <?php echo __( 'Show in List','mass-email-to-users');?></th>
                    <th><input  type="checkbox"  name="chkallFilter" id='chkallFilter'>&nbsp; <?php echo __( 'Show in Filter','mass-email-to-users');?></th>
            </tr>
            </thead>

            <tfoot>
            <tr>
                
                    <th><?php echo __( 'Field Name','mass-email-to-users');?></th>
                    <th><?php echo __( 'Show in List','mass-email-to-users');?></th>
                    <th><?php echo __( 'Show in Filter','mass-email-to-users');?></th>
                    
                    
            </tr>
            </tfoot>

            <tbody id="the-list" class="list:cat">
                 
                <?php $selected_grp=array();?>
                <?php $options=get_option('buddypress_groups');
                if($options!=false){
                    
                    $selected_grp= json_decode($options,true);
                    
                }?>
                 <tr class="iedit alternate">
                        <td class="name column-name" style="border:1px solid #DBDBDB;padding-left:13px;">
                          <?php echo __( 'BuddyPress User Groups','mass-email-to-users'); ?>
                        </td>
                        <td class="name column-name" style="border:1px solid #DBDBDB;">  &nbsp; &nbsp; <input value="1" class="chkallList" <?php if(isset($selected_grp) && is_array($selected_grp) && isset($selected_grp['list']) && $selected_grp['list']==1):?> checked="" <?php endif;?>  type="checkbox" name="grp[list]"> </td>
                        <td class="name column-name" style="border:1px solid #DBDBDB;">  &nbsp; &nbsp;  <input value="1" class="chkallFilter"  <?php if(isset($selected_grp) && is_array($selected_grp) &&  isset($selected_grp['filter']) && $selected_grp['filter']==1):?> checked="" <?php endif;?> type="checkbox" name="grp[filter]"></td>
                   </tr>

                <?php $selected=array();?>
                <?php $options=get_option('buddypress_fields');
                if($options!=false){
                    
                    $selected= json_decode($options,true);
                }
                  
                 if (function_exists('bp_is_active') && bp_is_active( 'xprofile' ) ){
                     
                    $query="SELECT * FROM ".$wpdb->prefix."bp_xprofile_groups";
                    $results=$wpdb->get_results($query,ARRAY_A);
                    
                    if(is_array($results) and sizeof($results)>0){


                        foreach($results as $res){


                                ?>
                               <?php if (function_exists('bp_is_active') && bp_is_active( 'xprofile' ) ) : if ( bp_has_profile( array( 'profile_group_id' => $res['id'], 'fetch_field_data' => false ) ) ) : while ( bp_profile_groups() ) : bp_the_profile_group(); ?>

                                    <?php while ( bp_profile_fields() ) : bp_the_profile_field(); ?>
                                        <?php global $field;?>

                                        <tr class="iedit alternate">
                                                     <td class="name column-name" style="border:1px solid #DBDBDB;padding-left:13px;">
                                                       <?php bp_the_profile_field_name(); ?><?php echo '('.$res['name'].')'; ?>
                                                     </td>
                                                     <td class="name column-name" style="border:1px solid #DBDBDB;">  &nbsp; &nbsp; <input value="1" class="chkallList" <?php if(isset($selected[$field->id]) && isset($selected[$field->id]['list']) && $selected[$field->id]['list']==1):?> checked="" <?php endif;?>  type="checkbox" name="field[<?php echo $field->id;?>][list]"> </td>
                                                     <td class="name column-name" style="border:1px solid #DBDBDB;">  &nbsp; &nbsp;  <input value="1" class="chkallFilter"  <?php if(isset($selected[$field->id]) && isset($selected[$field->id]['filter']) && $selected[$field->id]['filter']==1):?> checked="" <?php endif;?> type="checkbox" name="field[<?php echo $field->id;?>][filter]"></td>
                                        </tr>

                                <?php endwhile; ?>


                               <?php endwhile; endif; endif; ?>

                        <?php }
                        
                        }
                       
                        
                
                        }?>             
          
            </table>
            <script>
                    jQuery("body").on('click', '#chkallList', function() {

                       if(jQuery(this).is(':checked')){

                            jQuery('.chkallList').each(function(){
                                 jQuery(this).prop("checked" , true);
                            }) 
                       }
                       else{

                           jQuery('.chkallList').each(function(){
                                 jQuery(this).prop("checked" , false);
                            }) 

                       }
                    });
                    
                    jQuery("body").on('click', '#chkallFilter', function() {

                       if(jQuery(this).is(':checked')){

                            jQuery('.chkallFilter').each(function(){
                                 jQuery(this).prop("checked" , true);
                            }) 
                       }
                       else{

                           jQuery('.chkallFilter').each(function(){
                                 jQuery(this).prop("checked" , false);
                            }) 

                       }
                    });
                            
            </script>
    <br/>
    <br/>
    
    <input type='submit'  value='<?php echo __( 'Save','mass-email-to-users');?>' name='btnsave' class='button-primary' id='btnsave' >  
</form>
<?php    
    
}

function i13_format_xprofile_field_for_display( $value ) {
        if ( is_array( $value ) ) {
                $value = array_map( 'i13_format_xprofile_field_for_display', $value );
                $value = implode( ', ', $value );
        } else {
                $value = stripslashes( $value );
                $value = esc_html( $value );
        }

        return $value;
}

function i13_bp_xprofile_maybe_format_datebox_post_data( $field_id ) {
	if ( ! isset( $_GET['field_' . $field_id] ) ) {
            
		if ( ! empty( $_GET['field_' . $field_id . '_day'] ) && ! empty( $_GET['field_' . $field_id . '_month'] ) && ! empty( $_GET['field_' . $field_id . '_year'] ) ) {
			// Concatenate the values.
			$date_value = $_GET['field_' . $field_id . '_day'] . ' ' . $_GET['field_' . $field_id . '_month'] . ' ' . $_GET['field_' . $field_id . '_year'];
                        $_POST['field_' . $field_id . '_day']=$_GET['field_' . $field_id . '_day'];
                        $_POST['field_' . $field_id . '_month']=$_GET['field_' . $field_id . '_month'];
                        $_POST['field_' . $field_id . '_year']=$_GET['field_' . $field_id . '_year'];
                        // Check that the concatenated value can be turned into a timestamp.
			if ( $timestamp = strtotime( $date_value ) ) {
                            
				// Add the timestamp to the global $_POST that should contain the datebox data.
				$_GET['field_' . $field_id] = date( 'Y-m-d', $timestamp );
                                
			}
		}
	}
}



add_shortcode( 'mass_email_user_unsubscriber_link', 'mass_email_get_user_unsubscriber_link' );
function mass_email_get_user_unsubscriber_link() {
    
    if(is_user_logged_in()){
     
        $uerIdunsbs=base64_encode(get_current_user_id());
        $url = get_home_url();
        $unsubs=$url.'?action=nks_unsubscribeuser_mass_mail&unsc_mass_mail='.$uerIdunsbs;  
        return $unsubs;
    }
    else{
        
	 return '';
    }
}

add_filter( 'nav_menu_link_attributes', 'i13_mass_email_nav_menu_link_attributes', 10, 3 ); 
function i13_mass_email_nav_menu_link_attributes( $atts, $item, $args ) {
	if ( false !== strpos( $atts[ 'href' ], '[mass_email_user_unsubscriber_link]' ) ) {
		
            $atts[ 'href' ] = do_shortcode('[mass_email_user_unsubscriber_link]');
	
	}

	return $atts;
}

?>