<script setup>
import { Link } from "@inertiajs/inertia-vue3";

defineProps({
    hover_owner: Boolean,
});
</script>

<template>
    <div
        @mouseover="hover_owner = true"
        @mouseleave="hover_owner = false"
        class="h-10 w-full items-center text-center border-solid border-white"
    >
        <div v-if="hover_owner == false" class="py-2">
            Tenant Management
            <!-- <Link href="/boardingAdmin"> Boarding Admin </Link> -->
        </div>
        <div
            v-if="hover_owner == true"
            class="border-solid border-b-4 border-indigo-900 py-2 bg-indigo-900"
        >
            Tenant Management<!-- <Link href="/boardingAdmin"> Boarding Admin </Link> -->
        </div>
        <div
            class="p-2 bg-indigo-900 whitespace-nowrap"
            v-if="hover_owner == true"
        >
            <ul>
                <li class="hover:bg-indigo-600">
                    <Link href="#">Tenant List</Link>
                </li>
                <li class="hover:bg-indigo-600">
                    <Link href="#">Tenant Request</Link>
                </li>
            </ul>
        </div>
    </div>

    <Link class="h-10 w-full text-center py-2 whitespace-nowrap"
        >Boarding Management
    </Link>
    <Link class="h-10 w-full text-center py-2 whitespace-nowrap">
        Payment Management</Link
    >
    <!-- <Link class="h-10 w-full items-center text-center px-6 py-2"> ???</Link> -->
    <!-- <Link class="h-10 w-full items-center text-center px-6 py-2"> ???</Link> -->
</template>
