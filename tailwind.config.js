import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Manrope', 'Inter', ...defaultTheme.fontFamily.sans],
                display: ['Space Grotesk', 'Manrope', 'sans-serif'],
            },
            colors: {
                cm: {
                    dark: '#0B132B',
                    darkSoft: '#1C2541',
                    bg: '#F1F5F9',
                    bgSoft: '#E2E8F0',
                    surface: '#FFFFFF',
                    ink: '#090D16',
                    text: '#0F172A',
                    textSecondary: '#475467',
                    textMuted: '#64748B',
                    border: '#E2E8F0',
                    borderSoft: '#F1F5F9',
                    primary: '#0F172A',
                    primaryHover: '#1E293B',
                    emerald: '#059669',
                    emeraldHover: '#047857',
                    emeraldSoft: '#ECFDF5',
                    emeraldBorder: '#A7F3D0',
                    rose: '#E11D48',
                    roseHover: '#BE123C',
                    roseSoft: '#FFF1F2',
                    roseBorder: '#FECDD3',
                    amber: '#D97706',
                    amberSoft: '#FEF3C7',
                    amberBorder: '#FDE68A',
                }
            },
            boxShadow: {
                'cm-card': '0 4px 20px -2px rgba(15, 23, 42, 0.06), 0 2px 6px -1px rgba(15, 23, 42, 0.04)',
                'cm-glow': '0 0 25px -5px rgba(5, 150, 105, 0.25)',
                'cm-dark-glow': '0 10px 30px -10px rgba(11, 19, 43, 0.5)',
            }
        },
    },

    plugins: [forms],
};
