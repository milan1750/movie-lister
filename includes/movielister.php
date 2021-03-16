<?php

namespace movielister\includes;

defined( 'ABSPATH' ) || exit;

class MovieLister {

    function __construct() {
        $this->includes();  
        $this->init(); 
    }

    protected function includes() {
        include ( ML_PLUGIN_PATH. '/includes/ml-custom-post.php');
        include ( ML_PLUGIN_PATH. '/includes/shortcodes.php');
        include ( ML_PLUGIN_PATH. '/includes/taxonomies.php');
        include ( ML_PLUGIN_PATH. '/includes/scripts.php');
    }

    public function init () {
        ShortCodes::createShortCode();
        MlCustomPost::craete_ml_custom_post();
        MlCustomPost::flush_link();
        MlCustomPost::change_title_place();
        Taxonomies::create_custom_taxonomy();
        Scripts::add_scrtipts();
    }
}