<?php
/*
Plugin Name: Clearfix shortcode
Plugin URI: https://reliti.net/clearfix
Description: Adds a shortcode so you can insert float clears into your posts and pages
Version: 1.0.0
Author: Reliti.com
Author URI: https://reliti.com
*/

namespace Reliti;

Clearfix::init();

class Clearfix {
    public static function init()     {
        add_action('admin_menu', '\Reliti\Clearfix::init_autoupdate');
        add_action('network_admin_menu', '\Reliti\Clearfix::init_autoupdate');
        add_shortcode('clearfix', '\Reliti\Clearfix::shortcode');
    }

    /**
     * Shortcode callback
     * @param  array  $args
     * @return void
     */
    public static function shortcode($args = [])    {
        $args_lc = array_map('strtolower', (array)$args);
        if (array_search('left', $args_lc) !== false) {
            $direction = 'left';
        }
        else if (array_search('right', $args_lc) !== false) {
            $direction = 'right';
        }
        else {
            $direction = 'both';
        }
        return '<div style="display:block;visibility:hidden;height:0;clear:' . $direction . ';"></div>';
    }

    /**
     * Setup the auto updater
     * @return void
     */
    public static function init_autoupdate()     {
        if (!class_exists('\WP_AutoUpdate')) {
            require(__DIR__ . '/wp_auto_update.php');
        }

        $slug = basename(dirname(__DIR__)) . '/reliti-clearfix.php';

        $plugin_data = get_plugin_data(__DIR__ . '/reliti-clearfix.php');
        $version = $plugin_data[ 'Version' ];

        new \WP_AutoUpdate($version, add_query_arg(array(
            'slug' => $slug ), 'https://reliti.com/updateCheck/'), $slug);
    }
}
