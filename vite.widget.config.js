import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";
import path from "path";
import laravel from "laravel-vite-plugin";

export default defineConfig({
  plugins: [
    vue(),
    laravel({
      input: "resources/js/embed-widget.js",  // your entry
      buildDirectory: "widget",               // must match outDir
      refresh: true,
    }),
  ],

  resolve: {
    alias: {
      "@": path.resolve(__dirname, "resources"),
    },
  },

  base: "/widget/",
  publicDir: false,

  build: {
    outDir: "public/widget",
    emptyOutDir: true,
    cssCodeSplit: true,
    assetsDir: "assets",
    rollupOptions: {
      output: {
        entryFileNames: "bot-widget.js",
        assetFileNames: (assetInfo) => {
          if (assetInfo.name && assetInfo.name.endsWith(".css")) {
            return "assets/style.css";
          }
          return "assets/[name]-[hash][extname]";
        },
      },
    },
  },
});
