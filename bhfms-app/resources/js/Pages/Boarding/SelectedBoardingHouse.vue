<script setup>
import Header from "../../Shared/Header.vue";
import Footer from "../../Shared/Footer.vue";
import Carousel from "../../Shared/Carousel/Carousel.vue";

defineProps({
    boardingHouseDetail: Object,
    images: Array,
});
</script>

<template>
    <Header />
    <section>
        <Carousel :slides="images" controls indicators interval size="800" />
    </section>
    <Footer />
</template>
