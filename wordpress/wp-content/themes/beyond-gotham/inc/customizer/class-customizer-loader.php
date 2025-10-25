<?php
/**
 * Customizer module loader for Beyond Gotham theme.
 *
 * @package beyond_gotham
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once __DIR__ . '/class-customizer-module-interface.php';
require_once __DIR__ . '/class-customizer-module-base.php';

/**
 * Loads and bootstraps customizer modules from the customizer directory.
 */
final class Beyond_Gotham_Customizer_Loader {
    /**
     * Singleton instance.
     *
     * @var Beyond_Gotham_Customizer_Loader|null
     */
    private static $instance = null;

    /**
     * Registered module instances keyed by module id.
     *
     * @var Beyond_Gotham_Customizer_Module_Interface[]
     */
    private $modules = array();

    /**
     * Absolute path to the customizer directory.
     *
     * @var string
     */
    private $base_dir;

    /**
     * Returns singleton instance of the loader.
     *
     * @return Beyond_Gotham_Customizer_Loader
     */
    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Constructor.
     */
    private function __construct() {
        $this->base_dir = trailingslashit( get_template_directory() ) . 'inc/customizer/';

        add_action( 'after_setup_theme', array( $this, 'boot' ), 5 );
    }

    /**
     * Boots the loader and registers module hooks.
     *
     * @return void
     */
    public function boot() {
        if ( ! $this->should_boot() ) {
            return;
        }

        $this->load_support_files();
        $this->discover_modules();

        add_action( 'customize_register', array( $this, 'register_modules' ), 1 );
    }

    /**
     * Determine whether the loader should initialise for the current request.
     *
     * @return bool
     */
    private function should_boot() {
        if ( defined( 'WP_INSTALLING' ) && WP_INSTALLING ) {
            return false;
        }

        if ( function_exists( 'wp_doing_cron' ) && wp_doing_cron() ) {
            return false;
        }

        if ( defined( 'REST_REQUEST' ) && REST_REQUEST && ! $this->is_customizer_request() ) {
            return false;
        }

        if ( function_exists( 'wp_doing_ajax' ) && wp_doing_ajax() && ! $this->is_customizer_request() ) {
            return false;
        }

        return true;
    }

    /**
     * Detect if the current request is for the customizer preview or API.
     *
     * @return bool
     */
    private function is_customizer_request() {
        if ( function_exists( 'is_customize_preview' ) && is_customize_preview() ) {
            return true;
        }

        $request_keys = array(
            'customize_changeset_uuid',
            'customize_theme',
            'customize_messenger_channel',
        );

        foreach ( $request_keys as $key ) {
            if ( isset( $_REQUEST[ $key ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
                return true;
            }
        }

        if ( isset( $_REQUEST['action'] ) && is_string( $_REQUEST['action'] ) && 0 === strpos( $_REQUEST['action'], 'customize_' ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
            return true;
        }

        return false;
    }

    /**
     * Ensures helper and control files are loaded prior to module registration.
     *
     * @return void
     */
    private function load_support_files() {
        $helpers  = $this->base_dir . 'helpers.php';
        $controls = $this->base_dir . 'controls.php';

        if ( file_exists( $helpers ) ) {
            require_once $helpers;
        }

        if ( file_exists( $controls ) ) {
            require_once $controls;
        }
    }

    /**
     * Discovers module classes within the customizer directory.
     *
     * @return void
     */
    private function discover_modules() {
        $module_files = glob( $this->base_dir . 'modules/*.php' );

        if ( empty( $module_files ) ) {
            $module_files = glob( $this->base_dir . '*.module.php' );
        }

        if ( empty( $module_files ) ) {
            return;
        }

        $module_files = $this->sort_module_files( $module_files );

        foreach ( $module_files as $file ) {
            $this->load_module_file( $file );
        }
    }

    /**
     * Sort module file paths so provider modules are loaded before consumers.
     *
     * @param array $files List of module file paths.
     * @return array
     */
    private function sort_module_files( array $files ) {
        if ( empty( $files ) ) {
            return $files;
        }

        $priority_map = array(
            'class-customizer-module-colors.php'      => 10,
            'class-customizer-module-branding.php'    => 15,
            'class-customizer-module-typography.php'  => 20,
            'class-customizer-module-layout.php'      => 30,
            'class-customizer-module-navigation.php'  => 40,
            'class-customizer-module-performance.php' => 70,
            'class-customizer-module-seo.php'         => 80,
            'class-customizer-module-styles.php'      => 90,
        );

        usort(
            $files,
            function ( $a, $b ) use ( $priority_map ) {
                $a_basename = basename( (string) $a );
                $b_basename = basename( (string) $b );

                $a_priority = isset( $priority_map[ $a_basename ] ) ? $priority_map[ $a_basename ] : 50;
                $b_priority = isset( $priority_map[ $b_basename ] ) ? $priority_map[ $b_basename ] : 50;

                if ( $a_priority === $b_priority ) {
                    return strcmp( $a_basename, $b_basename );
                }

                return $a_priority <=> $b_priority;
            }
        );

        return $files;
    }

    /**
     * Loads a module file and registers discovered module classes.
     *
     * @param string $file File path to load.
     * @return void
     */
    private function load_module_file( $file ) {
        $before = get_declared_classes();

        require_once $file;

        $after    = get_declared_classes();
        $new      = array_diff( $after, $before );
        $abstract = array( 'Beyond_Gotham_Abstract_Customizer_Module' );

        foreach ( $new as $class ) {
            if ( in_array( $class, $abstract, true ) ) {
                continue;
            }

            if ( ! is_subclass_of( $class, 'Beyond_Gotham_Customizer_Module_Interface' ) ) {
                continue;
            }

            $instance = new $class();
            $module_id = $instance->get_id();

            if ( isset( $this->modules[ $module_id ] ) ) {
                continue;
            }

            $this->modules[ $module_id ] = $instance;
            $instance->boot();
        }
    }

    /**
     * Registers all discovered modules with the customizer.
     *
     * @param WP_Customize_Manager $wp_customize Customizer manager instance.
     * @return void
     */
    public function register_modules( WP_Customize_Manager $wp_customize ) {
        if ( empty( $this->modules ) ) {
            return;
        }

        $modules = $this->modules;

        uasort(
            $modules,
            function ( Beyond_Gotham_Customizer_Module_Interface $a, Beyond_Gotham_Customizer_Module_Interface $b ) {
                return $a->get_priority() <=> $b->get_priority();
            }
        );

        foreach ( $modules as $module ) {
            $module->register( $wp_customize );
        }

        /**
         * Fires after all customizer modules have been registered.
         *
         * @param WP_Customize_Manager                     $wp_customize Customizer instance.
         * @param Beyond_Gotham_Customizer_Module_Interface[] $modules Registered module instances.
         */
        do_action( 'beyond_gotham_customizer_modules_registered', $wp_customize, $modules );
    }
}

// Bootstrap the loader as soon as the file is loaded.
Beyond_Gotham_Customizer_Loader::instance();
