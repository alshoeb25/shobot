import { createApp } from "vue";
import BotWidget from "./components/BotWidget.vue";

// Auto-inject CSS (if built separately)
(function () {
  const scriptSrc = document.currentScript?.src || "";
  const base = scriptSrc.substring(0, scriptSrc.lastIndexOf("/") + 1);
  const link = document.createElement("link");
  link.rel = "stylesheet";
  link.href = base + "assets/style.css";
  document.head.appendChild(link);
})();

(function () {
  if (document.getElementById("leolus-chat")) return;
  const el = document.createElement("div");
  el.id = "leolus-chat";
  document.body.appendChild(el);

  const app = createApp(BotWidget);
  app.mount("#leolus-chat");
})();
console.log("✅ Leolus Chat Widget initializednnnclear");