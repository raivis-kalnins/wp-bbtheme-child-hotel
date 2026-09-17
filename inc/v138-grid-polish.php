<?php
/**
 * WP BBTheme child suite 3.8.11.38 - hotel grid and component polish.
 */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'wpbb_child_v138_enqueue' ) ) {
    function wpbb_child_v138_enqueue() {
        $dir = get_stylesheet_directory();
        $uri = get_stylesheet_directory_uri();
        $css = '/assets/suite-v138.css';
        $js  = '/assets/suite-v138.js';

        $style_deps = ( wp_style_is( 'wpbb-suite-v137', 'registered' ) || wp_style_is( 'wpbb-suite-v137', 'enqueued' ) )
            ? array( 'wpbb-suite-v137' )
            : array();
        $script_deps = ( wp_script_is( 'wpbb-suite-v136', 'registered' ) || wp_script_is( 'wpbb-suite-v136', 'enqueued' ) )
            ? array( 'wpbb-suite-v136' )
            : array();

        if ( is_readable( $dir . $css ) ) {
            wp_enqueue_style(
                'wpbb-suite-v138',
                $uri . $css,
                $style_deps,
                (string) filemtime( $dir . $css )
            );
        }

        if ( is_readable( $dir . $js ) ) {
            wp_enqueue_script(
                'wpbb-suite-v138',
                $uri . $js,
                $script_deps,
                (string) filemtime( $dir . $js ),
                true
            );
        }
    }
}
add_action( 'wp_enqueue_scripts', 'wpbb_child_v138_enqueue', PHP_INT_MAX );

if ( ! function_exists( 'wpbb_child_v138_body_class' ) ) {
    function wpbb_child_v138_body_class( $classes ) {
        $classes[] = 'wpbb-v138';
        return array_values( array_unique( $classes ) );
    }
}
add_filter( 'body_class', 'wpbb_child_v138_body_class', PHP_INT_MAX );

/* Render the three imported placeholder cards with sector-specific hotel copy
 * on the front page. The JS repair remains as a fallback for late-rendered or
 * client-mutated BBuilder markup. */
if ( ! function_exists( 'wpbb_child_v138_front_card_copy' ) ) {
    function wpbb_child_v138_front_card_copy( $content ) {
        if ( is_admin() || ! is_front_page() || ! in_the_loop() || ! is_main_query() ) {
            return $content;
        }

        $cards = array(
            array(
                'Room discovery',
                'Compare room types, capacity, amenities and practical stay details in one clear journey.',
            ),
            array(
                'Stay planning',
                'Bring dining, local recommendations and useful arrival information into the booking experience.',
            ),
            array(
                'Direct enquiries',
                'Capture dates, guest needs and special requests so the hotel team can respond with the right context.',
            ),
        );

        foreach ( $cards as $card ) {
            $content = preg_replace( '/Card title/i', esc_html( $card[0] ), $content, 1 );
            $content = preg_replace( '/Add a short description\.?/i', esc_html( $card[1] ), $content, 1 );
        }
        return $content;
    }
}
add_filter( 'the_content', 'wpbb_child_v138_front_card_copy', PHP_INT_MAX );
