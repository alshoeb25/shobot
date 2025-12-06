import { createApp } from "vue";
import BotWidget from "./components/BotWidget.vue";

(function () {
  const el = document.createElement("div");
  el.id = "leolus-chat";
  document.body.appendChild(el);

  const app = createApp(BotWidget);
  app.mount("#leolus-chat");

  console.log("✅ Leolus Chat Widget initialized");
})();
