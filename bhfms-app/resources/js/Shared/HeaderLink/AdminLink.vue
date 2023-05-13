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
        class="px-16 h-10 w-full items-center text-center border-solid border-white z-50"
    >
        <div v-if="hover_admin == false" class="p-2 px-16 whitespace-nowrap">
            Management
        </div>
        <div
            v-if="hover_admin == true"
            class="whitespace-nowrap py-2 bg-indigo-900 z-50 px-16"
        >
            Management
        </div>
        <div
            class="bg-indigo-900 whitespace-nowrap z-50"
            v-if="hover_admin == true"
        >
            <ul>
                <li class="z-50 py-2 bg-indigo-900 hover:opacity-75">
                    <Link href="/boardingAdmin">Boarding Management</Link>
                </li>
                <li class="z-50 py-2 bg-indigo-900 hover:opacity-75">
                    <Link href="/facilityAll">Facility Management</Link>
                </li>
                <li class="z-50 py-2 bg-indigo-900 hover:opacity-75">
                    <Link href="/userAll">User Management</Link>
                </li>
                <li class="z-50 py-2 bg-indigo-900 hover:opacity-75">
                    <Link href="/boardingTypeAll"
                        >Boarding Type Management</Link
                    >
                </li>
                <li class="z-50 py-2 bg-indigo-900 hover:opacity-75">
                    <Link href="/complainTypeAll"
                        >Complain Type Management</Link
                    >
                </li>
                <li class="z-50 py-2 bg-indigo-900 hover:opacity-75">
                    <Link href="/transactionTypeAll"
                        >Transaction Type Management</Link
                    >
                </li>
                <li class="z-50 py-2 bg-indigo-900 hover:opacity-75">
                    <Link href="/paymentMethodAll"
                        >Payment Method Management</Link
                    >
                </li>
            </ul>
        </div>
    </div>
</template>
