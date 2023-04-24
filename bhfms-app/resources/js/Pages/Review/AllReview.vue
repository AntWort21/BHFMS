<script setup>
import Footer from '../../Shared/Footer.vue';
import Header from '../../Shared/Header.vue';

defineProps({
    boardingHouseList: Array,
})
</script>

<template>
    <Header />
    <section class="h-[60vh]">
        <div v-for="(boarding,key) in boardingHouseList" :key="key">
            {{ boarding }}
        </div>
    </section>
    <Footer />
</template>
