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
        class="px-2 h-10 w-full items-center text-center border-solid border-white z-50"
    >
        <div v-if="hover_owner == false" class="p-2 whitespace-nowrap">
            Tenant Management
        </div>
        <div
            v-if="hover_owner == true"
            class="whitespace-nowrap py-2 bg-indigo-900 z-50 px-2"
        >
            Tenant Management
        </div>
        <div
            class="bg-indigo-900 whitespace-nowrap z-50"
            v-if="hover_owner == true"
        >
            <ul>
                <li class="z-50 py-2 bg-indigo-900 hover:opacity-75">
                    <Link href="/tenantBoarding">Tenant List</Link>
                </li>
                <li class="z-50 py-2 bg-indigo-900 hover:opacity-75">
                    <Link href="/tenantBoarding?search=pending"
                        >Tenant Request</Link
                    >
                </li>
            </ul>
        </div>
    </div>

    <Link
        href="/boardingOwner"
        class="h-10 w-full text-center p-2 whitespace-nowrap z-50 bg-indigo-900 hover:opacity-75"
        >Boarding Management
    </Link>
    <Link
        href="#"
        class="h-10 w-full text-center p-2 whitespace-nowrap z-50 bg-indigo-900 hover:opacity-75"
    >
        Payment Management</Link
    >
</template>
