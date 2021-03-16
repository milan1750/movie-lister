<?php

namespace movielister\includes;

defined( 'ABSPATH' ) || exit;

class Taxonomies {
    
    public static function create_custom_taxonomy() {
        add_action( 'init', function () {
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
                'menu_name'         => __( 'Movie Categories' ),
            );
            $args   = array(
                'hierarchical'      => true, // make it hierarchical (like categories)
                'labels'            => $labels,
                'show_ui'           => true,
                'show_admin_column' => true,
                'show_in_rest' => true,
                'query_var'         => true,
                'rewrite'           => [ 'slug' => 'movie-category' ],
            );
            
            register_taxonomy( 'movie_category', [ 'movies' ], $args );
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
                'menu_name'         => __( 'Movie Tags' ),
            );
            $args   = array(
                'hierarchical'      => true, // make it hierarchical (like categories)
                'labels'            => $labels,
                'show_ui'           => true,
                'show_admin_column' => true,
                'show_in_rest' => true,
                'query_var'         => true,
                'rewrite'           => [ 'slug' => 'movie-tags' ],
            );
            register_taxonomy( 'movie_tags', [ 'movies' ], $args );
        });
    }
}