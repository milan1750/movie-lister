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
    }

    public function init () {
        $customPost = new MlCustomPost();
        $customPost->craete_ml_custom_post();
    }

    public function load() {
        wp_enqueue_style('ml_styles',  ML_PLUGIN_URL. 'assets/css/style.css', '1.0', []);
    }
}