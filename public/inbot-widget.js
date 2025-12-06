(function() {
    if (window.BotWidgetLoaded) return;
    window.BotWidgetLoaded = true;

    window.loadBotWidget = function(options = {}) {
        document.addEventListener("DOMContentLoaded", function () {

            // Expect encrypted org
            window.CHATBOT_ORG_ENC = options.encrypted_org || null;

            // Create widget container AFTER body exists
            const container = document.createElement("div");
            container.id = "bot-widget-container";
            document.body.appendChild(container);

            // Load Vue widget JS file
            const script = document.createElement("script");
            script.src = options.widget_js_url;
            script.defer = true;
            document.body.appendChild(script);

        });
    };
})();
