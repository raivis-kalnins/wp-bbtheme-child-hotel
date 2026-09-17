<?php
/**
 * WP BBTheme Child Hotel 3.8.11.39.
 *
 * Final Hotel grid + WooCommerce ownership layer:
 * - one 1320px content edge for homepage, inner pages and WooCommerce;
 * - Hotel-green controls/pagination;
 * - reliable three-card Hotel demo row copy;
 * - canonical Woo page mapping, public demo visibility and account endpoints.
 */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'wpbb_child_v139_enqueue' ) ) {
    function wpbb_child_v139_enqueue() {
        $dir = get_stylesheet_directory();
        $uri = get_stylesheet_directory_uri();
        $css = '/assets/suite-v139.css';
        $js  = '/assets/suite-v139.js';

        if ( is_readable( $dir . $css ) ) {
            wp_enqueue_style(
                'wpbb-suite-v139',
                $uri . $css,
                ( wp_style_is( 'wpbb-suite-v138', 'registered' ) || wp_style_is( 'wpbb-suite-v138', 'enqueued' ) ) ? array( 'wpbb-suite-v138' ) : array(),
                (string) filemtime( $dir . $css )
            );
        }

        if ( is_readable( $dir . $js ) ) {
            wp_enqueue_script(
                'wpbb-suite-v139',
                $uri . $js,
                ( wp_script_is( 'wpbb-suite-v138', 'registered' ) || wp_script_is( 'wpbb-suite-v138', 'enqueued' ) ) ? array( 'wpbb-suite-v138' ) : array(),
                (string) filemtime( $dir . $js ),
                true
            );
        }
    }
}
add_action( 'wp_enqueue_scripts', 'wpbb_child_v139_enqueue', PHP_INT_MAX );

if ( ! function_exists( 'wpbb_child_v139_body_class' ) ) {
    function wpbb_child_v139_body_class( $classes ) {
        $classes[] = 'wpbb-v139';
        return array_values( array_unique( $classes ) );
    }
}
add_filter( 'body_class', 'wpbb_child_v139_body_class', PHP_INT_MAX );

/**
 * Replace the three imported placeholder cards wherever the front page is
 * rendered. This deliberately does not depend on the main-loop state because
 * managed BBuilder pages can render their sections outside the normal loop.
 */
if ( ! function_exists( 'wpbb_child_v139_replace_hotel_placeholders' ) ) {
    function wpbb_child_v139_replace_hotel_placeholders( $html ) {
        if ( is_admin() || ! is_front_page() || ! is_string( $html ) || '' === $html ) {
            return $html;
        }

        static $title_index = 0;
        static $copy_index  = 0;

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

        $html = preg_replace_callback(
            '/>\s*Card\s+title\s*</i',
            function( $match ) use ( $cards, &$title_index ) {
                if ( $title_index >= count( $cards ) ) return $match[0];
                $replacement = '>' . esc_html( $cards[ $title_index ][0] ) . '<';
                $title_index++;
                return $replacement;
            },
            $html
        );

        $html = preg_replace_callback(
            '/>\s*Add\s+a\s+short\s+description\.?\s*</i',
            function( $match ) use ( $cards, &$copy_index ) {
                if ( $copy_index >= count( $cards ) ) return $match[0];
                $replacement = '>' . esc_html( $cards[ $copy_index ][1] ) . '<';
                $copy_index++;
                return $replacement;
            },
            $html
        );

        return $html;
    }
}
add_filter( 'the_content', 'wpbb_child_v139_replace_hotel_placeholders', PHP_INT_MAX );
add_filter( 'render_block', 'wpbb_child_v139_replace_hotel_placeholders', PHP_INT_MAX );

/** Return WooCommerce endpoint keys and the active endpoint slugs. */
if ( ! function_exists( 'wpbb_child_v139_account_endpoint_map' ) ) {
    function wpbb_child_v139_account_endpoint_map() {
        $map = array(
            'orders'                    => 'orders',
            'view-order'                => 'view-order',
            'downloads'                 => 'downloads',
            'edit-address'              => 'edit-address',
            'payment-methods'           => 'payment-methods',
            'add-payment-method'         => 'add-payment-method',
            'delete-payment-method'      => 'delete-payment-method',
            'set-default-payment-method' => 'set-default-payment-method',
            'edit-account'              => 'edit-account',
            'lost-password'             => 'lost-password',
            'customer-logout'            => 'customer-logout',
        );

        if ( function_exists( 'WC' ) && WC() && isset( WC()->query ) && is_object( WC()->query ) && method_exists( WC()->query, 'get_query_vars' ) ) {
            $vars = (array) WC()->query->get_query_vars();
            foreach ( $map as $key => $fallback ) {
                if ( isset( $vars[ $key ] ) && '' !== trim( (string) $vars[ $key ] ) ) {
                    $map[ $key ] = sanitize_title( (string) $vars[ $key ] );
                }
            }
        }

        return array_filter( $map, 'strlen' );
    }
}

/**
 * Cloned demos can keep stale page IDs, and newer WooCommerce stores can keep
 * Site Visibility in Coming Soon. Repair those values once per site/version;
 * admins can still change them afterwards.
 */
if ( ! function_exists( 'wpbb_child_v139_repair_woocommerce_options' ) ) {
    function wpbb_child_v139_repair_woocommerce_options() {
        if ( ! class_exists( 'WooCommerce' ) && ! function_exists( 'WC' ) ) return;

        $version  = '3.8.11.39';
        $site_key = substr( md5( home_url( '/' ) ), 0, 12 );
        $done_key = 'wpbb_child_hotel_v139_woo_' . $site_key;
        if ( $version === (string) get_option( $done_key ) ) return;

        $page_map = array(
            'woocommerce_shop_page_id'      => 'shop',
            'woocommerce_cart_page_id'      => 'cart',
            'woocommerce_checkout_page_id'  => 'checkout',
            'woocommerce_myaccount_page_id' => 'my-account',
        );

        foreach ( $page_map as $option => $slug ) {
            $page = get_page_by_path( $slug, OBJECT, 'page' );
            if ( $page && 'publish' === $page->post_status && (int) get_option( $option ) !== (int) $page->ID ) {
                update_option( $option, (int) $page->ID, false );
            }
        }

        if ( 'yes' === (string) get_option( 'woocommerce_coming_soon', 'no' ) ) {
            update_option( 'woocommerce_coming_soon', 'no', false );
        }

        update_option( $done_key, $version, false );
    }
}
add_action( 'init', 'wpbb_child_v139_repair_woocommerce_options', 95 );

/** Register explicit My Account endpoint rules as a stale-rewrite fallback. */
if ( ! function_exists( 'wpbb_child_v139_account_rewrites' ) ) {
    function wpbb_child_v139_account_rewrites() {
        if ( ! function_exists( 'WC' ) && ! class_exists( 'WooCommerce' ) ) return;
        foreach ( wpbb_child_v139_account_endpoint_map() as $slug ) {
            $slug = sanitize_title( (string) $slug );
            if ( '' === $slug ) continue;
            add_rewrite_endpoint( $slug, EP_PAGES );
            add_rewrite_rule(
                '^my-account/' . preg_quote( $slug, '~' ) . '/?$',
                'index.php?pagename=my-account&' . $slug . '=',
                'top'
            );
            add_rewrite_rule(
                '^my-account/' . preg_quote( $slug, '~' ) . '/([^/]+)/?$',
                'index.php?pagename=my-account&' . $slug . '=$matches[1]',
                'top'
            );
        }
    }
}
add_action( 'init', 'wpbb_child_v139_account_rewrites', 120 );

if ( ! function_exists( 'wpbb_child_v139_query_vars' ) ) {
    function wpbb_child_v139_query_vars( $vars ) {
        foreach ( wpbb_child_v139_account_endpoint_map() as $slug ) {
            if ( ! in_array( $slug, $vars, true ) ) $vars[] = $slug;
        }
        return $vars;
    }
}
add_filter( 'query_vars', 'wpbb_child_v139_query_vars', PHP_INT_MAX );

/** Resolve /my-account/<endpoint>/ directly before WordPress can turn it 404. */
if ( ! function_exists( 'wpbb_child_v139_account_request' ) ) {
    function wpbb_child_v139_account_request( $query_vars ) {
        if ( is_admin() || ( function_exists( 'wp_doing_ajax' ) && wp_doing_ajax() ) ) return $query_vars;

        $request_path = (string) wp_parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH );
        $home_path    = (string) wp_parse_url( home_url( '/' ), PHP_URL_PATH );
        if ( $home_path && '/' !== $home_path && 0 === strpos( $request_path, $home_path ) ) {
            $request_path = substr( $request_path, strlen( $home_path ) );
        }
        $path = trim( $request_path, '/' );
        if ( 'my-account' === $path || 0 !== strpos( $path, 'my-account/' ) ) return $query_vars;

        $parts = array_values( array_filter( explode( '/', substr( $path, strlen( 'my-account/' ) ) ), 'strlen' ) );
        if ( empty( $parts ) ) return $query_vars;

        $requested_slug = sanitize_title( rawurldecode( (string) $parts[0] ) );
        $map = wpbb_child_v139_account_endpoint_map();
        if ( ! in_array( $requested_slug, $map, true ) ) return $query_vars;

        $query_vars['pagename'] = 'my-account';
        $query_vars[ $requested_slug ] = isset( $parts[1] ) ? sanitize_text_field( rawurldecode( (string) $parts[1] ) ) : '';
        unset( $query_vars['error'], $query_vars['name'] );
        return $query_vars;
    }
}
add_filter( 'request', 'wpbb_child_v139_account_request', 1 );

/** Build account endpoint URLs from the real published My Account page. */
if ( ! function_exists( 'wpbb_child_v139_endpoint_url' ) ) {
    function wpbb_child_v139_endpoint_url( $url, $endpoint, $value, $permalink ) {
        $page = get_page_by_path( 'my-account', OBJECT, 'page' );
        if ( ! $page || 'publish' !== $page->post_status ) return $url;

        $map  = wpbb_child_v139_account_endpoint_map();
        $slug = isset( $map[ $endpoint ] ) ? $map[ $endpoint ] : ( in_array( $endpoint, $map, true ) ? $endpoint : '' );
        if ( '' === $slug ) return $url;

        $target = trailingslashit( get_permalink( $page ) ) . trailingslashit( $slug );
        if ( '' !== (string) $value ) $target .= trailingslashit( rawurlencode( (string) $value ) );
        return $target;
    }
}
add_filter( 'woocommerce_get_endpoint_url', 'wpbb_child_v139_endpoint_url', PHP_INT_MAX, 4 );

/** Refresh rewrites once for this release after canonical Woo pages are mapped. */
if ( ! function_exists( 'wpbb_child_v139_flush_rewrites_once' ) ) {
    function wpbb_child_v139_flush_rewrites_once() {
        if ( ! function_exists( 'WC' ) && ! class_exists( 'WooCommerce' ) ) return;
        $version  = '3.8.11.39';
        $site_key = substr( md5( home_url( '/' ) ), 0, 12 );
        $key      = 'wpbb_child_hotel_v139_rewrites_' . sanitize_key( get_stylesheet() ) . '_' . $site_key;
        if ( $version === (string) get_option( $key ) ) return;
        flush_rewrite_rules( false );
        update_option( $key, $version, false );
    }
}
add_action( 'wp_loaded', 'wpbb_child_v139_flush_rewrites_once', PHP_INT_MAX );
