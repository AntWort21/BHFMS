<script setup>
import { Link } from "@inertiajs/inertia-vue3";

defineProps({
    hover_tenant: Boolean,
});
</script>

<template>
    <Link
        href="#"
        class="h-10 w-full text-center p-2 whitespace-nowrap z-50 bg-indigo-900 hover:opacity-75"
        >My Boarding House
    </Link>
    <Link
        href="#"
        class="h-10 w-full text-center p-2 whitespace-nowrap z-50 bg-indigo-900 hover:opacity-75"
        >Payment History
    </Link>
    <Link
        href="#"
        class="h-10 w-full text-center p-2 whitespace-nowrap z-50 bg-indigo-900 hover:opacity-75"
        >Payment History
    </Link>
</template>
