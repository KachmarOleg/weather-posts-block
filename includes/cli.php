<?php

if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
    return;
}

class WPB_Weather_CLI {

    /**
     * Clears all cached weather transients from the database.
     *
     * ## EXAMPLES
     *
     *     wp weather clear_cache
     *
     * @when after_wp_load
     */
    public function clear_cache() {
        global $wpdb;

        $like = $wpdb->esc_like( '_transient_wpb_weather_' ) . '%';

        $deleted = $wpdb->query(
            $wpdb->prepare(
                "DELETE FROM {$wpdb->options} WHERE option_name LIKE %s",
                $like
            )
        );

        if ( $deleted ) {
            WP_CLI::success( "Cleared {$deleted} weather cache entries." );
        } else {
            WP_CLI::line( 'No weather cache found. Nothing to clear.' );
        }
    }
}

WP_CLI::add_command( 'weather', 'WPB_Weather_CLI' );