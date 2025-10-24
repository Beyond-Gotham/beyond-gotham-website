<?php
/**
 * Base implementation for Beyond Gotham Customizer modules.
 *
 * @package beyond_gotham
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Provides sane defaults for module implementations.
 */
abstract class Beyond_Gotham_Abstract_Customizer_Module implements Beyond_Gotham_Customizer_Module_Interface {
    /**
     * {@inheritdoc}
     */
    public function get_priority() {
        return 10;
    }

    /**
     * {@inheritdoc}
     */
    public function boot() {
        // Default implementation does nothing.
    }
}
