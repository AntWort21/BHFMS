<script setup>
import Pusher from "pusher-js";
import { onMounted, reactive } from "vue";
import { Inertia } from "@inertiajs/inertia";

const props = defineProps({
    messages: Array,
});

const data = reactive({
    messages: [],
    newMessage: "",
    pusher: null,
    channel: null,
});

const sendMessage = () => {
    Inertia.post("/chat", { message: data.newMessage });
    data.newMessage = "";
};

const initializeMessages = () => {
    data.pusher = new Pusher(process.env.MIX_PUSHER_APP_KEY, {
        cluster: process.env.MIX_PUSHER_APP_CLUSTER,
        encrypted: true,
    });

    data.messages = props.messages

    data.channel = data.pusher.subscribe("my-channel");
    data.channel.bind("my-event", (incomingData) => {
        data.messages.push(incomingData.chat);
    });
};

onMounted(() => {
    initializeMessages();
});
</script>

<template>
    <div>
        <div v-for="(message, key) in data.messages" :key="key">
            <strong>{{ message.sender_id }}:</strong> {{ message.message }}
        </div>
        <input v-model="data.newMessage" type="text" placeholder="enter your message here"/>
        <form @submit.prevent="sendMessage()">
            <button>Send</button>
        </form>
    </div>
</template>
