<script setup>
import { Link } from "@inertiajs/inertia-vue3";

defineProps({
    hover_admin: Boolean,
});
</script>

<template>
    <div
        @mouseover="hover_admin = true"
        @mouseleave="hover_admin = false"
        class="h-10 w-full items-center text-center"
    >
        <div v-if="hover_admin == false" class="py-2">
            Management
            <!-- <Link href="/boardingAdmin"> Boarding Admin </Link> -->
        </div>
        <div
            v-if="hover_admin == true"
            class="border-solid border-b-4 border-indigo-900 py-2 bg-indigo-900 hover:bg-indigo-600"
        >
            Management
            <!-- <Link href="/boardingAdmin"> Boarding Admin </Link> -->
        </div>
        <div
            class="p-2 bg-indigo-900 whitespace-nowrap"
            v-if="hover_admin == true"
        >
            <ul>
                <li class="hover:bg-indigo-600">
                    <Link href="/profile">Boarding Management</Link>
                </li>
                <li class="hover:bg-indigo-600">
                    <Link href="/profile">Facility Management</Link>
                </li>
                <li class="hover:bg-indigo-600">
                    <Link href="/logout">User Management</Link>
                </li>
            </ul>
        </div>
    </div>

    <Link class="h-10 w-full text-center py-2 whitespace-nowrap">
        Complain Management</Link
    >
    <Link class="h-10 w-full text-center py-2 whitespace-nowrap">
        Payment Management</Link
    >
    <!-- <Link class="h-10 w-full items-center text-center px-6 py-2"> ???</Link> -->
    <!-- <Link class="h-10 w-full items-center text-center px-6 py-2"> ???</Link> -->
</template>
