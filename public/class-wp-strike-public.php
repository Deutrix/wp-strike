<?php

class Wp_Strike_Public {

    private $plugin_name;
    private $version;

    public function __construct( $plugin_name, $version ) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;

        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        add_action( 'template_redirect', array( $this, 'replace_homepage' ) );
    }

    public function enqueue_styles() {
        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-strike-public.css', array(), $this->version, 'all' );
    }

    public function enqueue_scripts() {
        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-strike-public.js', array( 'jquery' ), $this->version, false );
    }

    public function replace_homepage() {
            $type = get_option( 'wp_strike_type', 'recurring' );

            $timezone = get_option( 'wp_strike_timezone', 'UTC' );
            $date = new DateTime('now', new DateTimeZone($timezone));
            $current_time = $date->format('H:i');
            $current_date = $date->format( 'Y-m-d' );
            $time_from = get_option( 'wp_strike_time_from', '00:00' );
            $time_to = get_option( 'wp_strike_time_to', '23:59' );

            $show_page = false;

            // var_dump( "Current Time: $current_time, Current Date: $current_date, Time From: $time_from, Time To: $time_to, Type: $type, Timezone: $timezone" );

            if ( $type === 'recurring' ) {
                $recurring = get_option( 'wp_strike_recurring', 'daily' );
                if ( $recurring === 'daily' || ( $recurring === 'friday' && date( 'N' ) == 5 ) ) {
                    if ( $current_time >= $time_from && $current_time <= $time_to ) {
                        $show_page = true;
                    }
                }
            } elseif ( $type === 'specific' ) {
                $specific_date = get_option( 'wp_strike_specific_date', '' );
                if ( $current_date === $specific_date ) {
                    if ( $current_time >= $time_from && $current_time <= $time_to ) {
                        $show_page = true;
                    }
                }
            }

            if ( $show_page ) {
                add_filter( 'template_include', function() {
                    return plugin_dir_path( __FILE__ ) . 'templates/strike-page.php';
                });
            }
        }
}