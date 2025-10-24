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
        $this->load_support_files();
        $this->discover_modules();

        add_action( 'customize_register', array( $this, 'register_modules' ), 1 );
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

        foreach ( $module_files as $file ) {
            $this->load_module_file( $file );
        }
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
