# Weather and Posts Block

Custom Gutenberg block for displaying selected WordPress posts with a custom layout and a live weather snippet powered by OpenWeatherMap.

## Features

* Dynamic Gutenberg block
* Select featured posts directly in block settings
* Server-side rendering with PHP
* Live weather widget via OpenWeatherMap API
* Weather data cached for 1 hour per location
* Toggle visibility of individual weather fields in block settings
* API key stored securely in WordPress options — never exposed to frontend
* Admin settings page for API key management
* WP-CLI command to clear weather cache
* Custom frontend styles
* Template-based architecture
* Modern block.json support
* Built with `@wordpress/scripts`

---

# Installation

## Install dependencies

```bash
npm install
```

---

## Start development mode

```bash
npm run start
```

This watches JavaScript changes and rebuilds files automatically.

---

## Create production build

```bash
npm run build
```

Compiled files will be generated inside:

```bash
/build
```

---

# Configuration

## OpenWeatherMap API Key

1. Register at [openweathermap.org](https://openweathermap.org)
2. Go to `My Profile → My API Keys` and copy your key
3. In WordPress admin go to `Settings → Weather Posts`
4. Paste your API key and save

> ⚠️ A newly created API key may take up to 10 minutes to activate.

---

# Block Registration

The block is registered automatically using:

```php
register_block_type(__DIR__, [
    'render_callback' => 'weather_posts_block_render',
]);
```

Block metadata is loaded from:

```bash
block.json
```

---

# Weather Widget

The weather snippet loads automatically on the frontend using the visitor's geolocation.

## How it works

1. Browser requests user's geolocation
2. Coordinates are sent to a WordPress AJAX endpoint
3. Server fetches weather from OpenWeatherMap using the stored API key
4. Result is cached for 1 hour per latitude/longitude
5. Clean structured JSON is returned to the frontend

## AJAX Endpoint

Works for both logged-in and logged-out users:

```
GET /wp-admin/admin-ajax.php?action=wpb_get_weather&lat={lat}&lon={lon}
```

## Weather Fields (toggleable in block settings)

| Field | Default |
|---|---|
| Location name | ✅ on |
| Temperature | ✅ on |
| Feels-like temperature | ✅ on |
| Weather condition | ✅ on |
| Humidity | ✅ on |
| Pressure | ❌ off |
| Wind speed | ✅ on |
| Sunrise | ❌ off |
| Sunset | ❌ off |

---

# Admin Settings

Navigate to:

```
WordPress Admin → Settings → Weather Posts
```

Enter and save your OpenWeatherMap API key. The key is sanitized and stored using WordPress options API.

---

# WP-CLI

Clear all cached weather data manually:

```bash
wp weather clear_cache
```

> Run this command from the WordPress root directory (where `wp-config.php` is located).
> In LocalWP use **Open Site Shell** to get the correct terminal context.

---

# Styling

Frontend styles:

```bash
assets/styles/frontend.css
```

---

# Templates

Block markup is rendered using PHP templates:

```bash
templates/featured-posts.php
templates/post-item.php
templates/weather-snippet.php
```

This keeps rendering logic separated from business logic.

---

# File Structure

```
weather-posts-block/
├── assets/
│   └── styles/
│       └── frontend.css
├── build/
│   ├── index.asset.php
│   └── index.js
├── includes/
│   ├── ajax.php
│   ├── cli.php
│   ├── render.php
│   └── settings.php
├── src/
│   ├── edit.js
│   ├── index.js
│   └── save.js
├── templates/
│   ├── featured-posts.php
│   ├── post-item.php
│   └── weather-snippet.php
├── .gitignore
├── block.json
├── composer.json
├── index.php
├── package.json
└── README.md
```

---

# Development Notes

## JavaScript

Uses:

* React-style Gutenberg components
* `@wordpress/scripts`
* ESNext modules

Main entry:

```bash
src/index.js
```

---

## PHP

Server-side rendering is handled in:

```bash
includes/render.php
```

AJAX weather handler:

```bash
includes/ajax.php
```

Admin settings page:

```bash
includes/settings.php
```

WP-CLI command:

```bash
includes/cli.php
```

---

# Requirements

* WordPress 6+
* PHP 7.4+
* Node.js 18+
* OpenWeatherMap API key (free tier sufficient)

---

# Author

Oleh Kachmar
