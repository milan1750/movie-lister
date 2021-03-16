<?php
namespace movielister\includes;

class Scripts {
    public static function add_scrtipts() {
        add_action( 'init', function () {
            wp_enqueue_style('ml_styles',  ML_PLUGIN_URL. 'assets/css/style.css', '1.0', []);
        });
    }
}