<?php

namespace movielister\includes;

defined( 'ABSPATH' ) || exit;

class MlCustomPost {

    function craete_ml_custom_post () {
        add_action( 'init', array( $this, 'create_custom_post' ) );
        add_action( 'init', array( $this, 'create_custom_taxonomy' ) );
        add_shortcode( 'ml_movies_list', array($this, 'ml_movies_short_code') );
        add_action( 'init', array($this, 'ml_movies_block') );

        add_filter( 'save_post', array( $this, 'flush_permalink' ) );

        add_action( 'init', array($this, 'create_block_gutenpride_block_init' ) );

        // add_action( 'pre_get_posts', array( $this, 'add_my_post_types_to_query' ) );
    }
    
    function create_custom_post() {
        register_post_type( 'movies', array (
            'labels' => array (
                'name' => __( 'Movies', 'mlister' ),
                'singular_name' => __( 'Movie', 'mlister' ),
            ),
            'public' =>true,
            'has_archieve' => true,
            'show_in_rest' => true,
            'supports' => array( 'editor' )
        ));
    }

    function flush_permalink( $post ) {
        if($post->post_type == 'movies') {
            flush_rewrite_rules();
        }
    }

    function ml_movies_short_code($atts) {
        $query = array (
            'post_type' => 'movies',
            'posts_per_page' => 10

        );
        $posts = new \WP_Query($query);
        while ( $posts->have_posts() ) {
            $posts->the_post();
            $output = '<div class="entry-content">'.get_the_title().'<br>'.get_the_content();
        }
        return $output;
    }



    function create_custom_taxonomy() {
            $labels = array(
                'name'              => _x( 'Movie Categories', 'taxonomy general name' ),
                'singular_name'     => _x( 'Category', 'taxonomy singular name' ),
                'search_items'      => __( 'Search Categories' ),
                'all_items'         => __( 'All Categories' ),
                'parent_item'       => __( 'Parent Category' ),
                'parent_item_colon' => __( 'Parent Category:' ),
                'edit_item'         => __( 'Edit Category' ),
                'update_item'       => __( 'Update Category' ),
                'add_new_item'      => __( 'Add New Category' ),
                'new_item_name'     => __( 'New Category Name' ),
                'menu_name'         => __( 'Categories' ),
            );
            $args   = array(
                'hierarchical'      => true, // make it hierarchical (like categories)
                'labels'            => $labels,
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'rewrite'           => [ 'slug' => 'movie-category' ],
            );
            
            register_taxonomy( 'movie-category', [ 'movies' ], $args );
            $labels = array(
                'name'              => _x( 'Movie Tags', 'taxonomy general name' ),
                'singular_name'     => _x( 'Tags', 'taxonomy singular name' ),
                'search_items'      => __( 'Search Tags' ),
                'all_items'         => __( 'All Tags' ),
                'parent_item'       => __( 'Parent Tags' ),
                'parent_item_colon' => __( 'Parent Tags:' ),
                'edit_item'         => __( 'Edit Tags' ),
                'update_item'       => __( 'Update Tags' ),
                'add_new_item'      => __( 'Add New Tags' ),
                'new_item_name'     => __( 'New Tags Name' ),
                'menu_name'         => __( 'Tags' ),
            );
            $args   = array(
                'hierarchical'      => true, // make it hierarchical (like categories)
                'labels'            => $labels,
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'rewrite'           => [ 'slug' => 'movie-tags' ],
            );
            register_taxonomy( 'movie-tags', [ 'movies' ], $args );
    }

    // function add_my_post_types_to_query( $query ) {
    //     if ( is_home() && $query->is_main_query() )
    //         $query->set( 'post_type', array( 'post', 'movies' ) );
    //     return $query;
    // }

    function ml_movies_block () {
        register_block_type_from_metadata( __DIR__ );
    }

    function create_block_gutenpride_block_init() {
        register_block_type_from_metadata( __DIR__ );
    }
}