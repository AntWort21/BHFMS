<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import Carousel from "../../Carousel/Carousel.vue";
defineProps({
    slides: Object,
    slides: Array,
});
// import Header from "../Shared/Header.vue";
</script>

<template>
    <h1>test 123</h1>
    <span class="align-middle">
        <carousel
            :slides="slides"
            controls
            indicators
            interval
            size="1200"
        ></carousel>
    </span>
</template>
