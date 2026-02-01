import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class', // Vamos forçar o dark mode via classe ou apenas assumir o tema escuro como padrão
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            
            
            fontFamily: {
                // Fontes do Projeto Ellas
                sans: ['"Sedan SC"', ...defaultTheme.fontFamily.serif], // Usando como padrão
                orbitron: ['"Orbitron"', 'sans-serif'], // Para Títulos
                biorhyme: ['"BioRhyme"', 'serif'], // Para parágrafos
            },
            colors: {
                // Paleta "Ellas" extraída do CSS
                ellas: {
                    dark: '#04030c',      // Fundo Principal
                    card: '#1a1a2e',      // Fundo dos Cards/Menu
                    purple: '#a504aa',    // Gradiente 1
                    pink: '#e31475',      // Gradiente 2
                    cyan: '#04cbef',      // Gradiente 3
                    nav: '#250b3c',       // Borda sutil
                },
            },
            backgroundImage: {
                // Gradiente padrão dos botões e detalhes
                'ellas-gradient': 'linear-gradient(45deg, #a504aa, #e31475, #04cbef)',
                'ellas-text': 'linear-gradient(180deg, #a504aa, #e31475, #04cbef)',
            }
        },
    },

    plugins: [forms, typography],
};