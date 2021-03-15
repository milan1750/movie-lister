<?php

namespace movielister;

use movielister\includes\MovieLister;

/**
 * Plugin Name: Movie Lister
 * Plugin URI: https://wpeverest.com/wordpress-plugins/movie-lister/
 * Description: Easy movie lister with custom categories and tags. Preety listing and detail page
 * Version: 1.0
 * Author: MovieLister
 * Author URI: https://wpeverest.com
 * Domain Path: /languages/
 */

defined( 'ABSPATH' ) || exit;

if( !defined( 'ML_PLUGIN_FILE' ) ) {
    define( 'ML_PLUGIN_FILE', __FILE__ );
}

if( !defined( 'ML_PLUGIN_PATH' ) ) {
    define( 'ML_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
}

if( !defined( 'ML_PLUGIN_URL' ) ) {
    define( 'ML_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

if ( !class_exists( 'MovieLister' ) ) {
    include( ML_PLUGIN_PATH. '/includes/movielister.php' );
}

new MovieLister();


