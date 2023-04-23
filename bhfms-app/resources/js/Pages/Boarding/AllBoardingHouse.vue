<script setup>
import Header from "../../Shared/Header.vue";
import Footer from "../../Shared/Footer.vue";
import { Link } from "@inertiajs/inertia-vue3";

defineProps({
    allBoardingHouse: Object,
});
</script>

<template>
    <Header />
    <section class="mx-2 my-2 space-y-2">
        <div class="text-2xl font-semibold">Showing All Boarding House</div>
        <div class="text-md text-gray-600">
            List of all of our registered boarding house
        </div>
        <div class="flex flex-wrap">
            <div
                v-for="boardingHouse in allBoardingHouse.data"
                class="px-1 my-2 w-1/6 h-1/3"
            >
                <div class="bg-gray-200">
                    <img
                        :src="boardingHouse.imageUrl"
                        class="w-full h-80 object-cover"
                        alt="No Image"
                    />
                    <div class="h-2/3 space-y-1 p-2">
                        <div class="text-xs text-gray-600">
                            {{ boardingHouse.address }}
                        </div>
                        <div class="font-semibold">
                            {{ boardingHouse.name }}
                        </div>
                        <div class="text-sm box-content truncate">
                            {{ boardingHouse.description }}
                        </div>
                        <Link
                            href="/boarding/detail"
                            :data="{ id: boardingHouse.id }"
                            class="text-xs flex items-center font-semibold"
                        >
                            VIEW MORE DETAIL
                            <div class="ml-1 text-sm">>></div>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
        <div class="my-4 flex justify-center">
            <Link
                :href="allBoardingHouse.prev_page_url"
                v-if="allBoardingHouse.prev_page_url"
                class="px-2 py-1 bg-gray-300 rounded mr-2"
            >
                Previous
            </Link>
            <Link
                :href="allBoardingHouse.next_page_url"
                v-if="allBoardingHouse.next_page_url"
                class="px-2 py-1 bg-gray-300 rounded ml-2"
            >
                Next
            </Link>
        </div>
    </section>
    <Footer />
</template>
