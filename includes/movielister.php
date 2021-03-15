<?php

namespace movielister\includes;

defined( 'ABSPATH' ) || exit;

class MovieLister {

    function __construct() {
        $this->includes();  
        $this->init(); 
        add_action('admin_init', array($this, 'load_scripts') );
    }

    protected function includes() {
        include ( ML_PLUGIN_PATH. '/includes/ml-custom-post.php');
    }

    public function init () {
        $customPost = new MlCustomPost();
        $customPost->craete_ml_custom_post();
    }

    public function load_scripts() {
        wp_enqueue_style('ml_styles', ML_PLUGIN_PATH. '/assets/css/style.css', '1.0');
        wp_enqueue_script('ml_scripts', ML_PLUGIN_PATH. '/assets/js/script.js', [], '1.0', true);
    }
}