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
            <Link class="py-2 bg-indigo-900 hover:opacity-25" href="/">
                <img
                    :src="'/storage/BHFMS_transparent.png'"
                    alt="No Image"
                    class="w-16 h-auto"
                />
            </Link>
        </div>
        <div class="space-x-9 flex">
            <Link class="py-2 bg-indigo-900 hover:opacity-75 z-50" href="/"
                >Homepage</Link
            >
            <div v-if="$page.props.user" class="flex z-50">
                <AdminLink
                    v-if="$page.props.user.role_id == 1"
                    :hover_admin="hover_admin"
                />
                <OwnerLink
                    v-if="
                        $page.props.user.role_id == 3 ||
                        $page.props.user.role_id == 4
                    "
                    :hover_owner="hover_owner"
                />
                <TenantLink
                    v-if="$page.props.user.role_id == 2"
                    :hover_tenant="hover_tenant"
                />
            </div>
        </div>
        <div class="flex space-x-3 z-50">
            <input
                type="text"
                class="bg-white rounded-lg text-black text-sm w-full p-2.5 z-50"
                placeholder="Search"
            />
            <div
                v-if="!$page.props.user"
                class="h-10 w-full items-center text-center z-50"
            >
                <div
                    class="p-2 hover:bg-gray-200 z-50 px-6 py-2 bg-white rounded-2xl text-black z-50"
                >
                    <Link href="/login">Login</Link>
                </div>
            </div>
            <div
                v-else
                @mouseover="hover_profile = true"
                @mouseleave="hover_profile = false"
                class="h-10 w-full items-center text-center z-50"
            >
                <div
                    v-if="hover_profile == false"
                    class="px-6 py-2 bg-white rounded-2xl text-black z-50"
                >
                    <div v-if="$page.props.user">
                        {{ $page.props.user.user_name }}
                    </div>
                </div>
                <div
                    v-if="hover_profile == true"
                    class="border-solid border-b-4 border-indigo-900 px-6 py-2 bg-white rounded-2xl text-black z-50"
                >
                    <div v-if="$page.props.user">
                        {{ $page.props.user.user_name }}
                    </div>
                </div>
                <div
                    class="rounded-lg bg-white text-black z-50"
                    v-if="hover_profile == true"
                >
                    <ul class="z-50">
                        <li class="p-2 hover:bg-gray-200 hover:rounded-lg z-50">
                            <Link href="/profile">Profile</Link>
                        </li>
                        <li class="p-2 hover:bg-gray-200 hover:rounded-lg z-50">
                            <Link href="/logout">Logout</Link>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</template>
