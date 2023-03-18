<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import { ref } from "vue";

let hover = ref(false);
</script>

<template>
    <section
        class="p-6 bg-indigo-900 flex items-center justify-between text-white"
    >
        <div class="mx-3">
            <img
                :src="'../storage/BHFMS_transparent.png'"
                alt="No Image"
                class="w-16 h-auto"
            />
        </div>
        <div class="space-x-9">
            <Link href="">Boarding House Management</Link>
            <Link href="">Facilities Management</Link>

            <Link href="">Homepage</Link>

            <Link href="">Boarding House List</Link>

            <Link href="">Make Complains</Link>
            <Link href="">Payments</Link>

            <Link href="">My Boarding House</Link>
            <Link href="">My Complains</Link>
            <Link href="">My Payments</Link>
        </div>
        <div class="flex space-x-3">
            <input
                type="text"
                class="bg-white rounded-lg text-black text-sm w-full p-2.5"
                placeholder="Search"
            />
            <div
                @mouseover="hover = true"
                @mouseleave="hover = false"
                class="h-10"
            >
                <div class="px-6 py-2 bg-white rounded-2xl text-black">
                    User
                </div>
                <div
                    class="rounded-lg overflow-visible bg-white text-black"
                    v-if="hover == true"
                >
                    <ul>
                        <li class="p-2">
                            <Link href="#">Profile</Link>
                        </li>
                        <li class="p-2">
                            <Link href="/logout">Logout</Link>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</template>
