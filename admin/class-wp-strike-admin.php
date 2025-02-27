<?php

class Wp_Strike_Admin {

    private $plugin_name;
    private $version;

    public function __construct( $plugin_name, $version ) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;

        add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        add_action( 'admin_init', array( $this, 'register_settings' ) );
        add_action( 'update_option_wp_strike_options_group', array( $this, 'delete_wp_strike_purged_transient' ) );
    }

    public function enqueue_styles() {
        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-strike-admin.css', array(), $this->version, 'all' );
    }

    public function enqueue_scripts() {
        wp_enqueue_script( 'wp-color-picker' );
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_media();
        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-strike-admin.js', array( 'jquery', 'wp-color-picker' ), $this->version, false );
    }

    public function add_plugin_admin_menu() {
        add_menu_page(
            __( 'Generalni Štrajk', 'wp-strike' ),
            __( 'Generalni Štrajk', 'wp-strike' ),
            'manage_options',
            $this->plugin_name,
            array( $this, 'display_plugin_admin_page' ),
            'dashicons-groups',
            6
        );
    }

    public function display_plugin_admin_page() {
        include_once 'partials/wp-strike-admin-display.php';
    }

    public function register_settings() {
        add_option( 'wp_strike_title', '' );
        add_option( 'wp_strike_bg_color', '#ffffff' );
        add_option( 'wp_strike_image', '' );
        add_option( 'wp_strike_text', '' );
        add_option( 'wp_strike_text_color', '#000000' );
        add_option( 'wp_strike_type', 'recurring' );
        add_option( 'wp_strike_recurring', 'daily' );
        add_option( 'wp_strike_specific_date', '' );
        add_option( 'wp_strike_time_from', '11:52' );
        add_option( 'wp_strike_time_to', '12:07' );
        add_option( 'wp_strike_timezone', 'Europe/Belgrade' );
        add_option( 'wp_strike_enabled', '1' );

        register_setting( 'wp_strike_options_group', 'wp_strike_title' );
        register_setting( 'wp_strike_options_group', 'wp_strike_bg_color' );
        register_setting( 'wp_strike_options_group', 'wp_strike_image' );
        register_setting( 'wp_strike_options_group', 'wp_strike_text' );
        register_setting( 'wp_strike_options_group', 'wp_strike_text_color' );
        register_setting( 'wp_strike_options_group', 'wp_strike_type' );
        register_setting( 'wp_strike_options_group', 'wp_strike_recurring' );
        register_setting( 'wp_strike_options_group', 'wp_strike_specific_date' );
        register_setting( 'wp_strike_options_group', 'wp_strike_time_from' );
        register_setting( 'wp_strike_options_group', 'wp_strike_time_to' );
        register_setting( 'wp_strike_options_group', 'wp_strike_timezone' );
        register_setting( 'wp_strike_options_group', 'wp_strike_enabled' );
    }

    public function delete_wp_strike_purged_transient() {
        delete_transient('wp_strike_purged');
    }
}