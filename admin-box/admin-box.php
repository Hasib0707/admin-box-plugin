<?php

/**
 * Plugin Name: Admin Box
 * Plugin URI:
 * Author: Hasib
 * Author URI: https://github.com/Hasib0707/
 * description: This is a admin box plugin where using shortcode you can show admin 
 * information in post or pages. Use [admbox] shortcode to display admin box content.
 * Version: 1.0.0
 * Text Domain: admbox
 */

 if( ! defined('ABSPATH') ) {
  exit;
 }

 if( ! defined('_P_VERSION')) {
  define( '_P_VERSION', '1.0.1' );
 }

 function admbox_assets() {
  wp_enqueue_style( 'adminbox-plugin-style', plugin_dir_url(__FILE__).'assets/css/admin-box-admbox.css', array(), _P_VERSION, 'all' );
 }
 add_action( 'wp_enqueue_scripts', 'admbox_assets' );

 function display_admin_box_admbox() {
  $current_user = wp_get_current_user();
  $user_name = esc_html( $current_user->display_name );
  $user_avater = get_avatar( $current_user->ID, 150 );  

  function userBio($user_id) {
    $user_bio = get_the_author_meta( 'description', $user_id );
    if(! empty( $user_bio )) {
      return esc_html( $user_bio );
    } else {
      return 'No bio found for this user.';
    }
  }

  $user_description = userBio($current_user->ID);
  
  $html = <<<html
  <div class="admn-box-info">
    <div class="admin-left">
      <div class="admin-image">
      $user_avater
      </div>      
    </div>
    <div class="admin_right">
      <h3 class="adminbox-heading">$user_name</h3>
      <p>$user_description</p>
    </div>
  </div>

  html;
  return wp_kses_post( $html );
 }

 function register_admbox_shortcode() {
  add_shortcode( 'admbox', 'display_admin_box_admbox' );
 }
 add_action( 'init', 'register_admbox_shortcode' );