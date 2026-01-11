import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['"GRIFTER"', 'Outfit', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    dark: '#002B5B', // Deep Navy
                    primary: '#0F62FE', // Vibrant Blue
                    secondary: '#60A5FA',
                    accent: '#F59E0B',
                    surface: '#F1F6FA', // Slightly darker cool grey/blue for contrast with white cards
                    white: '#FFFFFF',
                    text: '#1E293B',
                    heroFrom: '#8FB8FF',
                    heroVia: '#D1E5FF',
                    heroTo: '#F1F6FA',
                    border: '#2B5F8C',
                    panel: '#F0F7FF',
                    panelBorder: '#BFDBFE',
                }
            },
            boxShadow: {
                'card': '0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03)',
                'card-hover': '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)',
                'strong': '0 0 20px rgba(0, 43, 91, 0.15)',
            },
            animation: {
                'fade-in': 'fadeIn 0.5s ease-out',
                'slide-up': 'slideUp 0.5s ease-out',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                slideUp: {
                    '0%': { transform: 'translateY(20px)', opacity: '0' },
                    '100%': { transform: 'translateY(0)', opacity: '1' },
                }
            }
        },
    },
    plugins: [],
};
