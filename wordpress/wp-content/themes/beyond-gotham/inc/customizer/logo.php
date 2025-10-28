<?php
/**
 * Legacy logo customizer compatibility layer.
 *
 * @deprecated 0.3.0 Use branding.php instead.
 */
require_once __DIR__ . '/branding.php';

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound
if ( ! function_exists( 'beyond_gotham_register_logo_customizer' ) ) {
        /**
         * Register logo controls (legacy wrapper).
         *
         * @deprecated 0.3.0 Use beyond_gotham_register_branding_customizer() instead.
         *
         * @param WP_Customize_Manager $wp_customize Customizer instance.
         * @return void
         */
        function beyond_gotham_register_logo_customizer( WP_Customize_Manager $wp_customize ) {
                _deprecated_function( __FUNCTION__, '0.3.0', 'beyond_gotham_register_branding_customizer' );

                beyond_gotham_register_branding_customizer( $wp_customize );
        }
}

if ( ! function_exists( 'beyond_gotham_get_logo_defaults' ) ) {
        /**
         * Retrieve logo defaults (legacy wrapper).
         *
         * @deprecated 0.3.0 Use beyond_gotham_get_branding_defaults() instead.
         *
         * @return array
         */
        function beyond_gotham_get_logo_defaults() {
                _deprecated_function( __FUNCTION__, '0.3.0', 'beyond_gotham_get_branding_defaults' );

                return beyond_gotham_get_branding_defaults();
        }
}

if ( ! function_exists( 'beyond_gotham_get_logo_settings' ) ) {
        /**
         * Retrieve logo settings (legacy wrapper).
         *
         * @deprecated 0.3.0 Use beyond_gotham_get_branding_settings() instead.
         *
         * @return array
         */
        function beyond_gotham_get_logo_settings() {
                _deprecated_function( __FUNCTION__, '0.3.0', 'beyond_gotham_get_branding_settings' );

                return beyond_gotham_get_branding_settings();
        }
}

if ( ! function_exists( 'beyond_gotham_is_logo_text_only' ) ) {
        /**
         * Determine whether branding is text-only (legacy wrapper).
         *
         * @deprecated 0.3.0 Use beyond_gotham_is_branding_text_only() instead.
         *
         * @return bool
         */
        function beyond_gotham_is_logo_text_only() {
                _deprecated_function( __FUNCTION__, '0.3.0', 'beyond_gotham_is_branding_text_only' );

                return beyond_gotham_is_branding_text_only();
        }
}

if ( ! function_exists( 'beyond_gotham_get_logo_id' ) ) {
        /**
         * Retrieve the logo attachment id (legacy wrapper).
         *
         * @deprecated 0.3.0 Use beyond_gotham_get_brand_logo_id() instead.
         *
         * @param string $variant Logo variant.
         * @return int
         */
        function beyond_gotham_get_logo_id( $variant = 'primary' ) {
                _deprecated_function( __FUNCTION__, '0.3.0', 'beyond_gotham_get_brand_logo_id' );

                return beyond_gotham_get_brand_logo_id( $variant );
        }
}

if ( ! function_exists( 'beyond_gotham_get_logo_size_settings' ) ) {
        /**
         * Retrieve logo size settings (legacy wrapper).
         *
         * @deprecated 0.3.0 Use beyond_gotham_get_brand_logo_dimensions() instead.
         *
         * @return array
         */
        function beyond_gotham_get_logo_size_settings() {
                _deprecated_function( __FUNCTION__, '0.3.0', 'beyond_gotham_get_brand_logo_dimensions' );

                return beyond_gotham_get_brand_logo_dimensions();
        }
}

if ( ! function_exists( 'beyond_gotham_render_logo_favicon' ) ) {
        /**
         * Render favicon fallback (legacy wrapper).
         *
         * @deprecated 0.3.0 Use beyond_gotham_render_brand_favicon() instead.
         *
         * @return void
         */
        function beyond_gotham_render_logo_favicon() {
                _deprecated_function( __FUNCTION__, '0.3.0', 'beyond_gotham_render_brand_favicon' );

                beyond_gotham_render_brand_favicon();
        }
}

if ( ! function_exists( 'beyond_gotham_get_logo_preview_data' ) ) {
        /**
         * Retrieve preview data for the customizer (legacy wrapper).
         *
         * @deprecated 0.3.0 Use beyond_gotham_get_branding_preview_data() instead.
         *
         * @return array
         */
        function beyond_gotham_get_logo_preview_data() {
                _deprecated_function( __FUNCTION__, '0.3.0', 'beyond_gotham_get_branding_preview_data' );

                return beyond_gotham_get_branding_preview_data();
        }
}
// phpcs:enable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound

