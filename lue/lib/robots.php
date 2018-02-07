<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class LUE_Robots {

  public function __construct() {
    add_action( 'do_robots',      array($this, 'lue_block_robots') );
  }

  /**
   * Adds the LUE_ASSETS_URL to the virtual robots.txt restricted list.
   * Fired when the template loader determines a robots.txt request.
   *
   * @access public
   * @static
   * @return void
   */
  public static function lue_block_robots() {
    $blocked_asset_path = str_ireplace(site_url(), '', LUE_ASSETS_URL);
    echo 'Disallow: '.$blocked_asset_path."\n";
  }

}
