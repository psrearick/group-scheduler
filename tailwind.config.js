const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');

module.exports = {
    mode: 'jit',
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        colors: {
            transparent: 'transparent',
            current: 'currentColor',
            gray: colors.trueGray,
            white: colors.white,
            black: colors.black,
            red: colors.red,
            emerald: colors.emerald,
            success: colors.emerald,
            primary: colors.teal,
            secondary: colors.orange,
            warning: colors.amber,
            danger: colors.red,
        },
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            // colors: {
                // rose: colors.rose,
                // fuchsia: colors.fuchsia,
                // indigo: colors.indigo,
                // teal: colors.teal,
                // lime: colors.lime,
                // orange: colors.orange,
                // amber: colors.amber,
            //     primary: {
            //         '50': colors.emerald['50'],
            //         '100': colors.emerald['100'],
            //         '200': colors.emerald['200'],
            //         '300': colors.emerald['300'],
            //         '400': colors.emerald['400'],
            //         '500': colors.emerald['500'],
            //         '600': colors.emerald['600'],
            //         '700': colors.emerald['700'],
            //         '800': colors.emerald['800'],
            //         '900': colors.emerald['900'],
            //     },
            //     secondary: {
            //         '50': colors.cyan['50'],
            //         '100': colors.cyan['100'],
            //         '200': colors.cyan['200'],
            //         '300': colors.cyan['300'],
            //         '400': colors.cyan['400'],
            //         '500': colors.cyan['500'],
            //         '600': colors.cyan['600'],
            //         '700': colors.cyan['700'],
            //         '800': colors.cyan['800'],
            //         '900': colors.cyan['900'],
            //     },
            //     warning: {
            //         '50': colors.amber['50'],
            //         '100': colors.amber['100'],
            //         '200': colors.amber['200'],
            //         '300': colors.amber['300'],
            //         '400': colors.amber['400'],
            //         '500': colors.amber['500'],
            //         '600': colors.amber['600'],
            //         '700': colors.amber['700'],
            //         '800': colors.amber['800'],
            //         '900': colors.amber['900'],
            //     },
            //     danger: {
            //         '50': colors.red['50'],
            //         '100': colors.red['100'],
            //         '200': colors.red['200'],
            //         '300': colors.red['300'],
            //         '400': colors.red['400'],
            //         '500': colors.red['500'],
            //         '600': colors.red['600'],
            //         '700': colors.red['700'],
            //         '800': colors.red['800'],
            //         '900': colors.red['900'],
            //     }
            // }
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
