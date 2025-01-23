<?php

use Jaybizzle\CrawlerDetect\CrawlerDetect;

class Wp_Strike_Public
{
    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;

        add_action('wp_enqueue_scripts', array($this, 'enqueue_styles'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('template_redirect', array($this, 'replace_homepage'));
    }

    public function enqueue_styles()
    {
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wp-strike-public.css', array(), $this->version, 'all');
    }

    public function enqueue_scripts()
    {
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/wp-strike-public.js', array('jquery'), $this->version, false);
    }

    public function clear_cache()
    {
        if (class_exists('\LiteSpeed\Purge')) {
            \LiteSpeed\Purge::purge_all();
        }
        if (function_exists('rocket_clean_domain')) {
            rocket_clean_domain();
        }
    }

    public function replace_homepage()
    {
        $CrawlerDetect = new CrawlerDetect;

        if ($CrawlerDetect->isCrawler() || get_option('wp_strike_enabled', '1') !== '1') {
            return;
        }

        $type = get_option('wp_strike_type', 'recurring');
        $timezone = get_option('wp_strike_timezone', 'UTC');
        $date = new DateTime('now', new DateTimeZone($timezone));
        $current_time = $date->format('H:i');
        $current_date = $date->format('Y-m-d');
        $time_from = get_option('wp_strike_time_from', '00:00');
        $time_to = get_option('wp_strike_time_to', '23:59');

        $show_page = false;

        if ($type === 'recurring') {
            $recurring = get_option('wp_strike_recurring', 'daily');
            if ($recurring === 'daily' || ($recurring === 'friday' && date('N') == 5)) {
                $show_page = $current_time >= $time_from && $current_time <= $time_to;
            }
        } elseif ($type === 'specific') {
            $specific_date = get_option('wp_strike_specific_date', '');
            if ($current_date === $specific_date) {
                $show_page = $current_time >= $time_from && $current_time <= $time_to;
            }
        }

        if ($show_page) {
            $this->clear_cache();
            set_transient('wp_strike_purged', true, 12 * HOUR_IN_SECONDS);
            add_filter('nocache_headers', '__return_true');
            add_filter('template_include', function () {
                return plugin_dir_path(__FILE__) . 'templates/strike-page.php';
            });
        } elseif (get_transient('wp_strike_purged') && $current_time > $time_to) {
            $this->clear_cache();
            delete_transient('wp_strike_purged');
        }
    }
}