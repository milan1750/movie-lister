<?php

namespace movielister\includes;

defined( 'ABSPATH' ) || exit;

class MlCustomPost {

    function craete_ml_custom_post () {
        add_action( 'init', array( $this, 'create_custom_taxonomy' ) );
        add_action( 'init', array( $this, 'create_custom_post' ) , 0);
        add_shortcode( 'ml_movies_list', array($this, 'ml_movies_short_code') );
        add_action( 'init', array( $this, 'create_ml_block' ) );

        add_filter( 'save_post', array( $this, 'flush_permalink' ) );
        add_filter( 'enter_title_here',function ( $title ){
            $screen = get_current_screen();
            if  ( 'movies' == $screen->post_type ) {
                 $title = 'Enter the movie Name';
            }
            return $title;
        });
        // add_action( 'pre_get_posts', array( $this, 'add_my_post_types_to_query' ) );
    }

    function create_ml_block () {
        if (!function_exists('register_block_type')) {
            return;
        }
        $dir = dirname(__FILE__);
    
        wp_register_script(
            'ml-blocks-list-movie',
            plugin_dir_path('assets/scripts/block.js', ML_PLUGIN_FILE),
            array(
                'wp-blocks',
                'wp-i18n',
                'wp-element',
                'wp-components'
            ),
            filemtime(plugin_dir_path('assets/scripts/block.js', ML_PLUGIN_FILE))
        );
    
        register_block_type('ml-blocks/list-movie', array(
            'editor_script' => 'ml-blocks-list-movie',
            'render_callback' => 'ml_blocks_list_movie_callback',
            'attributes' => [
                'per_page' => [
                    'default' => 1
                ]
            ]
        ));
    }

    function ml_blocks_list_movie_callback($atts) {
	    return $this->ml_block_core($atts[ 'per_page'] );
    }

    function ml_block_core($per_page)
    {
        return "[ml_movies_list per_page=$per_page]";
    }

    
    function create_custom_post() {
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
    }

    function flush_permalink( $post ) {
        if($post->post_type == 'movies') {
            flush_rewrite_rules();
        }
    }

    function ml_movies_short_code($atts) {

        $atts = shortcode_atts(array('per_page' => 2), $atts);

        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
        $query = array (
            'post_type' => 'movies',
            'posts_per_page' => $atts['per_page'],
            'paged' => $paged
        );
        $posts = new \WP_Query($query);
        $output = '';
        while ( $posts->have_posts() ) {
            $posts->the_post();
            $output .= '
                <div class="entry-content"><h1>'
                .get_the_title()
                .'</h1>'
                .get_the_post_thumbnail( get_the_ID(), 'post-thumbnail', array( 'class' => 'movie-img' ) )
                .'<p>'
                .get_the_content()
                .'</p></div>';
                
        }
        $big = 999999999; // need an unlikely integer
        $output .= paginate_links( array(
            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format' => '?paged=%#%',
            'current' => max( 1, $paged ),
            'total' => $posts->max_num_pages //$q is your custom query
        ) );
        
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
    }

    function ml_movies_block () {
        register_block_type_from_metadata( __DIR__ );
    }

    function create_block_gutenpride_block_init() {
        register_block_type_from_metadata( __DIR__ );
    }
}