/** @type { import('tailwindcss').Config } */
module.exports = {
    content: [
        './**/*.html',
        './**/*.blade.php',
    ],
    theme: {
        extend: {
            'colors': {
                gray: {
                    dark: '#181818',
                    warm: '#2c2c2c',
                },
            }
        }
    },
    plugins: [
        //
    ],
}
