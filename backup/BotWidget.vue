<template>
  <div>
    <!-- 💬 Floating Icon -->
    <div class="chat-fab" @click="toggleChat">💬</div>

    <!-- 🧠 Chat Widget -->
    <div v-if="open" class="chat-wrap">
      <div class="chat">
        <!-- 🟪 Header -->
        <div class="head">
          <img :src="orgBrand.logo" alt="Org Logo" />

          <span class="close" @click="toggleChat">✖</span>
        </div>

        <!-- 💬 Chat Body -->
        <div class="body" ref="chatBody">
          <transition-group name="fade" tag="div">
            <div
              v-for="(msg, i) in messages"
              :key="i"
              class="msg"
              :class="msg.sender"
            >
              {{ msg.text }}
            </div>
          </transition-group>

          <div v-if="isTyping" class="typing">...</div>
          
          <!-- <transition name="fade">
            <div
              v-if="conversationEnded"
              class="restart-icon"
              title="Restart Chat"
              @click="restartChat"
            >
              🔄
            </div>
          </transition> -->
        </div>

        <!-- ⌨️ Footer -->
        <div class="foot" v-if="!conversationEnded">
          <div v-if="options.length" class="options">
            <button
              v-for="(opt, i) in options"
              :key="i"
              @click="selectOption(opt)"
            >
              {{ opt.label }}
            </button>
          </div>

          <div v-else-if="showInput" class="input-wrapper">
            <input
              v-model="userInput"
              type="text"
              placeholder="Type your answer..."
              @keyup.enter="sendInput"
            />
            <button @click="sendInput">Send</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, nextTick, watch } from "vue";
import leolusLogo from "@/images/logo.png";

const open = ref(false);
const messages = ref([]);
const options = ref([]);
const isTyping = ref(false);
const userInput = ref("");
const currentQuestion = ref(null);
const chatBody = ref(null);
const showInput = ref(false);
const conversationEnded = ref(false); // 👈 new flag
const ORG_ID = 1;
const leadData = ref({
  name: "",
  email: "",
  phone: "",
  company: "",
  interest: "",
  conversation: [],
});

const orgBrand = ref({
  logo: null,
  theme_color: "#1e3a8a",
  welcome_text: "Hello! How may I assist you?"
});

async function loadOrganizationBranding() {
  const res = await fetch(`/api/bot/org/${ORG_ID}`);
  const data = await res.json();

  orgBrand.value.logo = `/storage/${data.logo}`;
  orgBrand.value.theme_color = data.theme_color;
  orgBrand.value.welcome_text = data.welcome_text;
}


const delay = (ms) => new Promise((r) => setTimeout(r, ms));
const toggleChat = () => (open.value = !open.value);

const validators = {
  name: (val) => val.trim().length >= 2,
  email: (val) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val),
  phone: (val) => /^\+?\d{7,15}$/.test(val),
};

async function fetchQuestion(parent_id = null) {
  isTyping.value = true;
  let url = `/api/bot/questions?org_id=${ORG_ID}`;
  if (parent_id) url += `&parent_id=${parent_id}`;

  const res = await fetch(url);

  const data = await res.json();
  isTyping.value = false;

  if (data.length) {
    const q = data[0];
    currentQuestion.value = q;
    options.value = q.options || [];
    showInput.value = q.type === "text" || !q.options || q.options.length === 0;
    await showMessage("bot", q.question_text);
  } else {
    // last bot message — hide input after showing message
    await showMessage("bot", "✅ Your details have been saved. Thank you!");
    await saveLead();
    conversationEnded.value = true; // 👈 disable footer
  }
}

async function showMessage(sender, text) {
  isTyping.value = true;
  await delay(400);
  isTyping.value = false;
  messages.value.push({ sender, text });
  leadData.value.conversation.push({ sender, text });
  await nextTick();
  if (chatBody.value) chatBody.value.scrollTop = chatBody.value.scrollHeight;
}

async function selectOption(opt) {
  await showMessage("user", opt.label);
  const lastBotMsg = messages.value.at(-2)?.text?.toLowerCase() || "";
  if (lastBotMsg.includes("interest")) leadData.value.interest = opt.label;
  await fetchQuestion(currentQuestion.value.id);
}

async function sendInput() {
  if (!userInput.value.trim()) return;

  const answer = userInput.value.trim();
  const field = currentQuestion.value?.field_name || null;

  if (!field) {
    await showMessage("user", answer);
    userInput.value = "";
    await fetchQuestion(currentQuestion.value.id);
    return;
  }

  // 🔍 Dynamic validation based on field_name
  if (field === "email") {
    if (!validators.email(answer)) {
      await showMessage("bot", "❌ Please enter a valid email address (e.g. example@email.com).");
      return;
    }
  } else if (field === "phone") {
    if (!validators.phone(answer)) {
      await showMessage("bot", "❌ Invalid phone number. Example: +91 9876543210");
      return;
    }
  } else if (field === "name") {
    if (!validators.name(answer)) {
      await showMessage("bot", "❌ Please enter your full name (min. 2 characters).");
      return;
    }
  } else if (field === "company") {
    if (answer.trim().length < 2) {
      await showMessage("bot", "❌ Please enter a valid company name.");
      return;
    }
  }

  // ✅ Save in leadData dynamically
  leadData.value[field] = answer;

  await showMessage("user", answer);
  userInput.value = "";

  saveUserData();
  await fetchQuestion(currentQuestion.value.id);
}

async function showInvalid(type) {
  let msg = "Invalid input.";
  if (type === "email") msg = "❌ Invalid email. Please try again.";
  if (type === "phone") msg = "❌ Invalid phone (e.g. +91 9876543210).";
  if (type === "name") msg = "Please enter your full name.";
  await showMessage("bot", msg);
  showInput.value = true;
}
async function saveLead() {
 // 🧾 Ensure latest answers are captured
  const dataToSave = {
    name: leadData.value.name || "",
    email: leadData.value.email || "",
    phone: leadData.value.phone || "",
    company: leadData.value.company || "",
    interest: leadData.value.interest || "",
    conversation: leadData.value.conversation || [],
  };
  if (!dataToSave.name && !dataToSave.email && !dataToSave.phone && !dataToSave.company) return;

  try {
    const res = await fetch("/api/bot/lead", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      
      body: JSON.stringify({
        org_id: ORG_ID,
        ...dataToSave
      }),

    });

    const data = await res.json();

    if (data.success) {
      await showMessage("bot", "✅ Lead saved successfully!");
    } else {
      await showMessage("bot", "⚠️ Could not save your details. Please try again.");
    }
  } catch (err) {
    console.error("❌ Error saving lead:", err);
    await showMessage("bot", "⚠️ Network error while saving your details.");
  }
  saveUserData();
}

// async function saveLead() {
//   await fetch("/api/bot/lead", {
//     method: "POST",
//     headers: { "Content-Type": "application/json" },
//     body: JSON.stringify(leadData.value),
//   });
//   await showMessage("bot", "✅ Lead saved successfully!");
//   saveUserData();
// }

function saveUserData() {
  localStorage.setItem("leolusUser", JSON.stringify(leadData.value));
}
function loadUserData() {
  const data = localStorage.getItem("leolusUser");
  if (data) Object.assign(leadData.value, JSON.parse(data));
}

// 🔄 Smart Restart — keep last 5 messages
async function restartChat() {
  if (messages.value.length > 5) {
    messages.value = messages.value.slice(-5); // keep last 5
  }
  options.value = [];
  userInput.value = "";
  conversationEnded.value = false;
  leadData.value.conversation = [];

  await showMessage("bot", "🔄 Restarting conversation...");
  await delay(600);
  await fetchQuestion(null);
}

onMounted(() => {
  loadUserData();
  loadOrganizationBranding();

  showMessage("bot", orgBrand.value.welcome_text);
  //showMessage("bot", "Looking for something? Let me help you!");
  delay(700).then(() => fetchQuestion());
});
watch(
  () => orgBrand.value.theme_color,
  (color) => {
    document.documentElement.style.setProperty("--theme-color", color);
  }
);

</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap");
:root {
  --theme-color: #1e3a8a;
}

.chat-fab {
  position: fixed;
  bottom: 25px;
  right: 25px;
 background: var(--theme-color);
  color: white;
  font-size: 26px;
  border-radius: 50%;
  width: 60px;
  height: 60px;
  text-align: center;
  line-height: 60px;
  cursor: pointer;
  box-shadow: 0 8px 22px rgba(0, 0, 0, 0.2);
  transition: all 0.25s ease;
}
.chat-fab:hover {
  transform: scale(1.1);
}

.chat-wrap {
  position: fixed;
  bottom: 90px;
  right: 25px;
  z-index: 9999;
}

.chat {
  width: 400px;
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 10px 26px rgba(0, 0, 0, 0.15);
  overflow: hidden;
  display: flex;
  flex-direction: column;
  font-family: "Poppins", sans-serif;
  border: 2px solid var(--theme-color);
  height: 450px;
}

/* Header */
.head {
  padding: 4px 8px;
  background: var(--theme-color);
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.head img {
  width: 70px;
  height: auto;
  margin-left: 8px;
}
.close {
  cursor: pointer;
  font-size: 16px;
  margin-right: 10px;
}

/* Body */
.body {
  flex: 1;
  padding: 14px 16px;
  overflow-y: auto;
  background: #fafafa;
}
.msg {
  margin: 6px 0;
  padding: 8px 12px;
  border-radius: 10px;
  max-width: 80%;
}
.bot {
  background: #e0e7ff;
  color: #1e3a8a;
  float: left;
}
.user {
  background: #4338ca;
  color: #fff;
  float: right;
}
.typing {
  font-style: italic;
  color: #888;
}

/* Footer */
.foot {
  padding: 8px 10px;
  background: #fff;
  border-top: 1px solid #eee;
}
.input-wrapper {
  display: flex;
  gap: 6px;
}
input {
  flex: 1;
  padding: 10px;
  border: 1px solid var(--theme-color);
  border-radius: 10px;
}
button {
  background: #1e3a8a;
  color: #fff;
  border: none;
  padding: 8px 12px;
  border-radius: 10px;
  cursor: pointer;
  font-weight: 600;
}
button:hover {
  background: var(--theme-color);;
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.4s;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
