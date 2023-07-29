## SSG (Static Site Generator)

Simplest SSG for your sites using **Blade** & **Vite**.

### Features:
1. Generation from **JSON files**
2. **Blade** template engine from Laravel
3. **Vite** CSS & JS compiler
4. **Sharing custom data** between pages

### Requirements
- PHP 7.4 or higher
- Recent versions of Node JS + yarn (or npm, pnpm etc.)

### Installation:
1. Clone this repo or run `composer create-project twent/ssg YOUR_SITE_NAME`
2. Install deps `make install`
3. Make testing build `make`

### How to use: 
1. Views in `resources/views` 
2. Pages JSONs in `resources/pages` folder
3. CSS & JS assets in `resources/assets`

> Inspired by [Cleaver](https://github.com/aschmelyun/cleaver)
