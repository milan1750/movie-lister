<?php

namespace movielister\includes;

defined( 'ABSPATH' ) || exit;

class CustomPosts {

    public static function craete_custom_post () {

        add_action( 'init',  function () {
            $labels = array (
                'title' => _x('Add Movie', 'movie'),
                'name'                     => _x( 'Movies', 'movie type general name' ),
                'singular_name'            => _x( 'Movie', 'movie type singular name' ),
                'add_new'                  => _x( 'Add New', 'movie' ),
                'add_new_item'             => __( 'Add New Movie' ),
                'edit_item'                => __( 'Edit Movie' ),
                'new_item'                 => __( 'New movie' ),
                'view_item'                => __( 'View movie' ),
                'view_items'               => __( 'View movies' ),
                'search_items'             => __( 'Search movies' ),
                'not_found'                => __( 'No MOVIES found.' ),
                'not_found_in_trash'       => __( 'No MOVIES found in Trash.' ),
                'parent_item_colon'        => null,
                'all_items'                => __( 'All movies' ),
                'archives'                 => __( 'movie Archives' ),
                'attributes'               => __( 'movie Attributes' ),
                'insert_into_item'         => __( 'Insert into post' ),
                'uploaded_to_this_item'    => __( 'Uploaded to this post' ),
                'featured_image'           => _x( 'Featured image', 'post' ),
                'set_featured_image'       => _x( 'Set featured image', 'post' ),
                'remove_featured_image'    => _x( 'Remove featured image', 'post' ),
                'use_featured_image'       => _x( 'Use as featured image', 'post' ),
                'filter_items_list'        => __( 'Filter MOVIES list' ),
                'filter_by_date'           => __( 'Filter by date' ),
                'items_list_navigation'    => __( 'movies list navigation' ),
                'items_list'               => __( 'movies list' ),
                'item_published'           => __( 'movie published.' ),
                'item_published_privately' => __( 'movie published privately.' ),
                'item_reverted_to_draft'   => __( 'movie reverted to draft.' ),
                'item_scheduled'           => __( 'movie scheduled.' ),
                'item_updated'             => __( 'movie updated.' ),
    
            );           
            $args = array(
                'label'               => __( 'movies', 'twentythirteen' ),
                'description'         => __( 'Movie news and reviews', 'twentythirteen' ),
                'labels'              => $labels,
                'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
                'hierarchical'        => false,
                'public'              => true,
                'show_ui'             => true,
                'show_in_menu'        => true,
                'show_in_nav_menus'   => true,
                'show_in_admin_bar'   => true,
                'menu_position'       => 5,
                'can_export'          => true,
                'has_archive'         => true,
                'exclude_from_search' => false,
                'publicly_queryable'  => true,
                'capability_type'     => 'page',
                'show_in_rest'        => true,
                'taxonomies' => array('movie_category', 'movie_tags' ),
                // This is where we add taxonomies to our CPT
            );
            register_post_type( 'movies', $args);
        } , 0);      
    }

    public static function change_title_place() {
        add_filter( 'enter_title_here',function ( $title ){
            $screen = get_current_screen();
            if  ( 'movies' == $screen->post_type ) {
                 $title = 'Enter the movie Name';
            }
            return $title;
        });
    }

    public static function flush_link() {
        add_filter( 'save_post', function ( $post ) {
            if($post->post_type == 'movies') {
                flush_rewrite_rules();
            }
        } );
    }
}