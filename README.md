# Weather and Posts Block

Custom Gutenberg block for displaying selected WordPress posts with a custom layout and weather section support.

## Features

* Dynamic Gutenberg block
* Select featured posts directly in block settings
* Server-side rendering with PHP
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

# Styling

Frontend styles:

```bash
assets/styles/frontend.css
```

---

# Templates

Block markup is rendered using PHP templates:

```bash
templates/post-item.php
```

This keeps rendering logic separated from business logic.

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

---

# Requirements

* WordPress 6+
* PHP 7.4+
* Node.js 18+

---

# Author

Oleh Kachmar
