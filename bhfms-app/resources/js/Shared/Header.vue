<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import { ref } from "vue";

import AdminLink from "./HeaderLink/AdminLink.vue";
import OwnerLink from "./HeaderLink/OwnerLink.vue";
import TenantLink from "./HeaderLink/TenantLink.vue";

let hover_profile = ref(false);
let selectedProfile = ref(false);
let selectedLogout = ref(false);

let hover_admin = ref(false);
let hover_tenant = ref(false);
let hover_owner = ref(false);
</script>

<template>
    <section
        class="p-6 bg-indigo-900 flex items-center justify-between text-white"
    >
        <div class="mx-3">
            <img
                :src="'/storage/BHFMS_transparent.png'"
                alt="No Image"
                class="w-16 h-auto"
            />
        </div>
        <div class="space-x-9 flex">
            <!-- <Link href="/">Homepage</Link> -->
            <!-- <AdminLink :hover_admin="hover_admin" /> -->
            <OwnerLink :hover_owner="hover_owner" />
            <TenantLink />
        </div>
        <div class="flex space-x-3">
            <input
                type="text"
                class="bg-white rounded-lg text-black text-sm w-full p-2.5"
                placeholder="Search"
            />
            <div
                @mouseover="hover_profile = true"
                @mouseleave="hover_profile = false"
                class="h-10 w-full items-center text-center"
            >
                <div
                    v-if="hover_profile == false"
                    class="px-6 py-2 bg-white rounded-2xl text-black"
                >
                    <div v-if="$page.props.user">
                        {{ $page.props.user.user_name }}
                    </div>
                    <div v-else>User</div>
                </div>
                <div
                    v-if="hover_profile == true"
                    class="border-solid border-b-4 border-indigo-900 px-6 py-2 bg-white rounded-2xl text-black"
                >
                    <div v-if="$page.props.user">
                        {{ $page.props.user.user_name }}
                    </div>
                    <div v-else>User</div>
                </div>
                <div
                    class="rounded-lg bg-white text-black"
                    v-if="hover_profile == true"
                >
                    <ul>
                        <li class="p-2 hover:bg-gray-200 hover:rounded-lg">
                            <Link href="/profile">Profile</Link>
                        </li>
                        <li class="p-2 hover:bg-gray-200 hover:rounded-lg">
                            <Link href="/logout">Logout</Link>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</template>
