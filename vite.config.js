import { defineConfig } from 'vite';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
  plugins: [
    tailwindcss(),
  ],
  build: {
    // Output to styles/dist
    outDir: 'styles/dist',
    // Clean the directory before building
    emptyOutDir: true,
    rollupOptions: {
      // Use styles/main.css as the entry point
      input: 'styles/main.css',
      output: {
        // Output assets (CSS) directly to the outDir with the name main.css
        // [name] will be the filename of the input (main)
        // [ext] will be css
        assetFileNames: '[name].[ext]',
        
        // If any JS is generated, name it main.js (though we mostly care about CSS)
        entryFileNames: '[name].js',
        chunkFileNames: '[name].js',
      },
    },
  },
});

