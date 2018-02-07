<?php
/*
Plugin Name: lue
Plugin URI: https://fixsociety.tech
Description: Fix Society customizations for WordPress
Version: 1.0.0
Author: Jared Mock
Author URI: https://fixsociety.tech
License: GPL3
Text Domain: lue
*/

function lue_the_permalink( $permalink ) {
    $key_to_check   = '_different_url';
    $only_on_single = false; // override on single post pages only
    if( is_single()  || (false == $only_on_single) ) {
        global $post;
        $permalink_replacement = get_post_meta($post->ID, $key_to_check, true);
        $permalink = ($permalink_replacement) ? $permalink_replacement : $permalink;
    }
    return $permalink;
}

function lue_enqueue_css() {
    wp_enqueue_style( 'lue-css--core', plugin_dir_url( __FILE__ ) . 'css/core.css', true );
}

function lue_enqueue_js() {
    wp_enqueue_script( 'lue-js--loaded',                   plugin_dir_url( __FILE__ ) . 'js/loaded.js',                   array( 'jquery' ), '1.1',                                     true);
    wp_enqueue_script( 'lue-js--cookie',                   plugin_dir_url( __FILE__ ) . 'js/cookie.js',                   array( 'jquery' ), '1.1',                                     true);
    wp_enqueue_script( 'lue-js--track-referral-campaigns', plugin_dir_url( __FILE__ ) . 'js/track-referral-campaigns.js', array( 'jquery', 'lue-js--cookie' ), '1.1',                   true);
}

function lue_woocommerce_reordered_tabs( $tabs ) {
    $tabs['description']['priority'] = 5;
    $tabs['specifications']['priority'] = 10;
    $tabs['additional_information']['priority'] = 15;
    return $tabs;
}

function wpdb_user_last_login_column($columns){
    $columns['lastlogin'] = __('Last Login', 'lastlogin');
    return $columns;
}

function wpdb_add_user_last_login_column($value, $column_name, $user_id ) {
    if ( 'lastlogin' != $column_name )
        return $value;
    return get_user_last_login($user_id,false);
}

function get_user_last_login($user_id,$echo = true){
    $date_format = get_option('date_format') . ' ' . get_option('time_format');
    $last_login = get_user_meta($user_id, 'last_login', true);
    $login_time = 'Never logged in';
    if(!empty($last_login)){
       if(is_array($last_login)){
            $login_time = mysql2date($date_format, array_pop($last_login), false);
        }
        else{
            $login_time = mysql2date($date_format, $last_login, false);
        }
    }
    if($echo){
        echo $login_time;
    }
    else{
        return $login_time;
    }
}

/* scripts */
add_action( 'wp_enqueue_scripts', 'lue_enqueue_css' );
add_action( 'wp_enqueue_scripts', 'lue_enqueue_js' );

/* misc fixes */
// add_filter( 'the_permalink', 'lue_the_permalink' );
add_filter( 'woocommerce_product_tabs', 'lue_woocommerce_reordered_tabs', 98 );
add_filter( 'manage_users_columns', 'wpdb_user_last_login_column' );
add_action( 'manage_users_custom_column', 'wpdb_add_user_last_login_column', 10, 3 );
remove_filter( 'the_content', 'wptexturize' );

?>
