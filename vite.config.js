import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import manifestSRI from 'vite-plugin-manifest-sri';

export default defineConfig({
  plugins: [
    laravel(['resources/js/app.js', 'resources/sass/app.scss']),
    manifestSRI(),
  ],
});
