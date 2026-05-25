<?php
$weather_config = [
    'ajaxUrl'         => admin_url( 'admin-ajax.php' ),
    'showLocation'    => ! empty( $attributes['showLocation'] ),
    'showTemperature' => ! empty( $attributes['showTemperature'] ),
    'showFeelsLike'   => ! empty( $attributes['showFeelsLike'] ),
    'showCondition'   => ! empty( $attributes['showCondition'] ),
    'showHumidity'    => ! empty( $attributes['showHumidity'] ),
    'showPressure'    => ! empty( $attributes['showPressure'] ),
    'showWindSpeed'   => ! empty( $attributes['showWindSpeed'] ),
    'showSunrise'     => ! empty( $attributes['showSunrise'] ),
    'showSunset'      => ! empty( $attributes['showSunset'] ),
];
?>

<div class="weather-snippet" id="wpb-weather-widget" data-config="<?php echo esc_attr( json_encode( $weather_config ) ); ?>">
    <div class="weather-snippet__loading">Loading weather...</div>
</div>

<script>
    (function () {
        const widget = document.getElementById('wpb-weather-widget');
        if (!widget) return;

        const config = JSON.parse(widget.dataset.config);

        if (!navigator.geolocation) {
            widget.innerHTML = '<p class="weather-snippet__error">Geolocation not supported.</p>';
            return;
        }

        navigator.geolocation.getCurrentPosition(
            function (position) {
                const lat = position.coords.latitude;
                const lon = position.coords.longitude;

                fetch(`${config.ajaxUrl}?action=wpb_get_weather&lat=${lat}&lon=${lon}`)
                    .then(res => res.json())
                    .then(json => {
                        if (!json.success) {
                            widget.innerHTML = '<p class="weather-snippet__error">Could not load weather.</p>';
                            return;
                        }

                        const w = json.data;
                        const rows = [];

                        if (config.showLocation    && w.location)    rows.push(`<div class="weather-snippet__location">${w.location}</div>`);
                        if (config.showTemperature && w.temperature !== null) rows.push(`<div class="weather-snippet__row"><span>Temperature:</span> <span>${w.temperature}°C</span></div>`);
                        if (config.showFeelsLike   && w.feels_like !== null)  rows.push(`<div class="weather-snippet__row"><span>Feels like:</span> <span>${w.feels_like}°C</span></div>`);
                        if (config.showCondition   && w.condition)   rows.push(`<div class="weather-snippet__row"><span>Condition:</span> <span>${w.condition}</span></div>`);
                        if (config.showHumidity    && w.humidity !== null)    rows.push(`<div class="weather-snippet__row"><span>Humidity:</span> <span>${w.humidity}%</span></div>`);
                        if (config.showPressure    && w.pressure !== null)    rows.push(`<div class="weather-snippet__row"><span>Pressure:</span> <span>${w.pressure} hPa</span></div>`);
                        if (config.showWindSpeed   && w.wind_speed !== null)  rows.push(`<div class="weather-snippet__row"><span>Wind:</span> <span>${w.wind_speed} m/s</span></div>`);
                        if (config.showSunrise     && w.sunrise)     rows.push(`<div class="weather-snippet__row"><span>Sunrise:</span> <span>${w.sunrise}</span></div>`);
                        if (config.showSunset      && w.sunset)      rows.push(`<div class="weather-snippet__row"><span>Sunset:</span> <span>${w.sunset}</span></div>`);

                        widget.innerHTML = `<div class="weather-snippet__body">${rows.join('')}</div>`;
                    })
                    .catch(() => {
                        widget.innerHTML = '<p class="weather-snippet__error">Network error.</p>';
                    });
            },
            function () {
                widget.innerHTML = '<p class="weather-snippet__error">Location access denied.</p>';
            }
        );
    })();
</script>