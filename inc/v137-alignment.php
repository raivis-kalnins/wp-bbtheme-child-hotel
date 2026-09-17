<?php
/**
 * WP BBTheme child suite 3.8.11.37 - canonical alignment hotfix.
 */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'wpbb_child_v137_enqueue' ) ) {
    function wpbb_child_v137_enqueue() {
        $dir = get_stylesheet_directory();
        $uri = get_stylesheet_directory_uri();
        $css = '/assets/suite-v137.css';

        if ( ! is_readable( $dir . $css ) ) {
            return;
        }

        $deps = ( wp_style_is( 'wpbb-suite-v136', 'registered' ) || wp_style_is( 'wpbb-suite-v136', 'enqueued' ) )
            ? array( 'wpbb-suite-v136' )
            : array();

        wp_enqueue_style(
            'wpbb-suite-v137',
            $uri . $css,
            $deps,
            (string) filemtime( $dir . $css )
        );
    }
}
add_action( 'wp_enqueue_scripts', 'wpbb_child_v137_enqueue', PHP_INT_MAX );
