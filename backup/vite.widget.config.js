import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";
import path from "path";

export default defineConfig({
  plugins: [vue()],
  resolve: {
    alias: {
      "@": path.resolve(__dirname, "resources"),
    },
  },
  base: "https://shotechsolutions.com/widget/",
  publicDir: false,
  build: {
    outDir: "public/widget",
    emptyOutDir: true,
    cssCodeSplit: true,  // ✅ extract CSS
    assetsDir: "assets",
    rollupOptions: {
      input: "resources/js/embed-widget.js",
      output: {
        entryFileNames: "bot-widget.js",
        assetFileNames: (assetInfo) => {
          // // ✅ Fix CSS filename to style.css
          if (assetInfo.name && assetInfo.name.endsWith(".css")) {
            return "assets/style.css";
          }
          return "assets/[name]-[hash][extname]";
        },
      },
    },
  },
});
