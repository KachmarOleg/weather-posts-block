<?php

function wpb_register_settings_page() {
    add_options_page(
        'Weather Posts Settings',
        'Weather Posts',
        'manage_options',
        'weather-posts-settings',
        'wpb_render_settings_page'
    );
}
add_action( 'admin_menu', 'wpb_register_settings_page' );

function wpb_register_settings() {
    register_setting( 'wpb_settings_group', 'wpb_openweather_api_key', [
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => '',
    ] );
}
add_action( 'admin_init', 'wpb_register_settings' );

function wpb_render_settings_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'Weather Posts Settings', 'weather-posts-block' ); ?></h1>
        <form method="post" action="options.php">
            <?php
            settings_fields( 'wpb_settings_group' );
            do_settings_sections( 'wpb_settings_group' );
            ?>
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="wpb_openweather_api_key">OpenWeatherMap API Key</label>
                    </th>
                    <td>
                        <input
                            type="password"
                            id="wpb_openweather_api_key"
                            name="wpb_openweather_api_key"
                            value="<?php echo esc_attr( get_option( 'wpb_openweather_api_key', '' ) ); ?>"
                            class="regular-text"
                        />
                        <p class="description">
                            Get your key at <a href="https://openweathermap.org/api" target="_blank">openweathermap.org</a>
                        </p>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}