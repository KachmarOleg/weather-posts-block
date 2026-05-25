<?php

add_action( 'wp_ajax_wpb_get_weather', 'wpb_get_weather_handler' );
add_action( 'wp_ajax_nopriv_wpb_get_weather', 'wpb_get_weather_handler' );

function wpb_get_weather_handler() {
    // Coordinates
    $lat = isset( $_GET['lat'] ) ? (float) $_GET['lat'] : null;
    $lon = isset( $_GET['lon'] ) ? (float) $_GET['lon'] : null;

    if ( $lat === null || $lon === null ) {
        wp_send_json_error( [ 'message' => 'Missing coordinates' ], 400 );
    }

    if ( $lat < -90 || $lat > 90 || $lon < -180 || $lon > 180 ) {
        wp_send_json_error( [ 'message' => 'Invalid coordinates' ], 400 );
    }

    $lat = round( $lat, 2 );
    $lon = round( $lon, 2 );

    $cache_key = 'wpb_weather_' . str_replace( [ '.', '-' ], '_', "{$lat}_{$lon}" );
    $cached    = get_transient( $cache_key );

    if ( $cached !== false ) {
        wp_send_json_success( $cached );
    }

    $api_key = get_option( 'wpb_openweather_api_key', '' );

    if ( empty( $api_key ) ) {
        wp_send_json_error( [ 'message' => 'API key not configured' ], 500 );
    }

    $url = add_query_arg( [
        'lat'   => $lat,
        'lon'   => $lon,
        'appid' => $api_key,
        'units' => 'metric',
    ], 'https://api.openweathermap.org/data/2.5/weather' );

    $response = wp_remote_get( $url, [ 'timeout' => 10 ] );

    if ( is_wp_error( $response ) ) {
        wp_send_json_error( [ 'message' => 'Failed to reach weather service' ], 502 );
    }

    $status = wp_remote_retrieve_response_code( $response );
    $body   = wp_remote_retrieve_body( $response );
    $data   = json_decode( $body, true );

    if ( $status !== 200 || empty( $data ) ) {
        wp_send_json_error( [ 'message' => 'Weather service error' ], 502 );
    }

    $weather = [
        'location' => $data['name'] ?? '',
        'temperature' => $data['main']['temp'] ?? null,
        'feels_like' => $data['main']['feels_like'] ?? null,
        'condition' => $data['weather'][0]['description'] ?? '',
        'humidity' => $data['main']['humidity'] ?? null,
        'pressure' => $data['main']['pressure'] ?? null,
        'wind_speed' => $data['wind']['speed'] ?? null,
        'sunrise' => isset( $data['sys']['sunrise'], $data['timezone'] ) ? gmdate( 'H:i', $data['sys']['sunrise'] + $data['timezone'] ) : null,
        'sunset' => isset( $data['sys']['sunset'], $data['timezone'] ) ? gmdate( 'H:i', $data['sys']['sunset'] + $data['timezone'] ) : null,
    ];

    // Cache for 1 hour
    set_transient( $cache_key, $weather, HOUR_IN_SECONDS );

    wp_send_json_success( $weather );
}