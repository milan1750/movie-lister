<?php

namespace movielister\includes;

defined( 'ABSPATH' ) || exit;

class MovieLister {

    function __construct() {
        $this->includes();  
        $this->init(); 
        add_action( 'init', array( $this, 'load') );
    }

    protected function includes() {
        include ( ML_PLUGIN_PATH. '/includes/ml-custom-post.php');
        include ( ML_PLUGIN_PATH. '/includes/shortcodes.php');
        include ( ML_PLUGIN_PATH. '/includes/taxonomies.php');
    }

    public function init () {
        ShortCodes::createShortCode();
        MlCustomPost::craete_ml_custom_post();
        MlCustomPost::flush_link();
        MlCustomPost::change_title_place();
        Taxonomies::create_custom_taxonomy();
    }

    public function load() {
        wp_enqueue_style('ml_styles',  ML_PLUGIN_URL. 'assets/css/style.css', '1.0', []);
    }
}