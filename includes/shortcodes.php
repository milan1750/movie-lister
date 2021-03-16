<?php

namespace movielister\includes;

defined( 'ABSPATH' ) || exit;

class ShortCodes {
    
    public static function createShortCode() {
        add_shortcode( 'ml_movies_list', function ( $atts ) {
            $atts = shortcode_atts(array( 'per_page' => 2), $atts );
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
        });
    }
}