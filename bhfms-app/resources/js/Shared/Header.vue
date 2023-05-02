<script setup>
import { Link, useForm } from "@inertiajs/inertia-vue3";
import { ref } from "vue";
import VueGoogleAutocomplete from "vue-google-autocomplete";

let hover = ref(false);
let selectedProfile = ref(false);
let selectedLogout = ref(false);

const onPlaceChangedHeader = (addressData, placeResultData) => {
    form.address = placeResultData.formatted_address;
    form.latitude = addressData.latitude;
    form.longitude = addressData.longitude;
};

const form = useForm({
    address: "",
    latitude: 0,
    longitude: 0,
});

const submitHeader = () => {
    form.post("/search");
};
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
            <div v-if="$page.props.user">
                <Link
                    class="mx-3"
                    v-if="$page.props.user.role_id == '1'"
                    href="/boardingAdmin"
                    >Boarding House Management</Link
                >
                <Link
                    class="mx-3"
                    v-if="$page.props.user.role_id == '3'"
                    href="/boardingOwner"
                    >Boarding House Management</Link
                >
                <Link
                    class="mx-3"
                    v-if="$page.props.user.role_id == '4'"
                    href="/boardingManager"
                    >Boarding House Management</Link
                >
                <Link
                    class="mx-3"
                    href=""
                    v-if="$page.props.user.role_id == '1'"
                    >Facilities Management</Link
                >
                <Link
                    class="mx-3"
                    href=""
                    v-if="$page.props.user.role_id == '1'"
                    >User Management</Link
                >
            </div>

            <Link href="">Homepage</Link>

            <!-- <Link href="">Boarding House List</Link>

            <Link href="">Make Complains</Link>
            <Link href="">Payments</Link>

            <Link href="">My Boarding House</Link>
            <Link href="">My Complains</Link>
            <Link href="">My Payments</Link> -->
        </div>
        <div class="flex items-center space-x-3">
            <form @submit.prevent="submitHeader" class="w-full h-10 flex items-center justify-between border border-gray-500 bg-white rounded-3xl items-center p-3">
                <vue-google-autocomplete
                    id="autocomplete"
                    class="h-full rounded-3xl items-center p-3 text-black"
                    placeholder="Search Here"
                    v-model="address"
                    v-on:placechanged="onPlaceChangedHeader"
                />
                <div
                    class="flex items-baseline justify-end items-center space-x-10"
                >
                    <button
                        class="text-white w-[3rem] h-[3rem] rounded-full flex items-center justify-center"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="28"
                            height="28"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="#000000"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </button>
                </div>
            </form>

            <div
                @mouseover="hover = true"
                @mouseleave="hover = false"
                class="h-10 w-full items-center text-center"
            >
                <div
                    v-if="hover == false"
                    class="px-6 py-2 bg-white rounded-2xl text-black"
                >
                    <div v-if="$page.props.user">
                        {{ $page.props.user.user_name }}
                    </div>
                    <div v-else>User</div>
                </div>
                <div
                    v-if="hover == true"
                    class="border-solid border-b-4 border-indigo-900 px-6 py-2 bg-white rounded-2xl text-black"
                >
                    <div v-if="$page.props.user">
                        {{ $page.props.user.user_name }}
                    </div>
                    <div v-else>User</div>
                </div>
                <div
                    class="rounded-lg bg-white text-black"
                    v-if="hover == true"
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
