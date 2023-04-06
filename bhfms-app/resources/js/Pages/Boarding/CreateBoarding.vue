<script setup>
// import { computed } from "vue";
// import { usePage } from "@inertiajs/inertia-vue3";
// import { numberLiteral } from "@babel/types";
import { reactive, ref, watch } from "vue";
import { useForm, Head } from "@inertiajs/inertia-vue3";
import VueMultiselect from "vue-multiselect";
import Multiselect from "vue-multiselect";
import VueGoogleAutocomplete from "vue-google-autocomplete";
// import { Loader } from "@googlemaps/js-api-loader";

defineProps({
    types: Object,
    facilities: Object,
    locations: Object,
    selectedType: Object,
    selectedLocation: Object,
    selectedFacility: Object,
});

const selectedType = ref("");
const selectedFacility = ref("");
const address = ref("");

const getAddressData = (addressData, placeResultData, id) => {
    address.value = addressData;
};

const form = useForm({
    name: "",
    address: address,
    type: selectedType,
    facility: selectedFacility,
    rooms: 0,
    price: 0,
    description: "",
});

// form.post("/boarding/create", {
//     preserveScroll: true,
//     // onSuccess: () => form.reset("password"),
// });

const submit = () => {
    form.post("/boarding/create", {
        preserveScroll: true,
        preserveState: true,
        // onSuccess: () => form.reset("password"),
    });
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
<template>
    <!-- <span v-text="$page.props.auth.user" /> -->
    <h1 v-if="$page.props.user">
        You are logged in as: {{ $page.props.user.name }}, with id =
        {{ $page.props.user.id }}
    </h1>
    <h1 v-else>Oh no 😢</h1>

    <!-- You are logged in as: {{ user.name }} + {{ user.id }} + {{ user.email }} -->
    <div class="overflow-x-auto">
        <div
            class="min-w-screen min-h-screen bg-gray-100 flex items-center justify-center bg-gray font-sans overflow-hidden"
        >
            <div class="w-11/12">
                <form
                    @submit.prevent="submit"
                    enctype="multipart/form-data"
                    class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4"
                >
                    <h1 class="text-blue-600 font-bold text-2xl mb-8">
                        Add New Boarding House
                    </h1>
                    <div class="mb-4">
                        <label
                            class="block text-gray-700 text-sm font-bold mb-2"
                            for="name"
                        >
                            Boarding House Name
                        </label>
                        <input
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="name"
                            type="text"
                            placeholder="name"
                            v-model="form.name"
                        />
                    </div>
                    <div class="mb-4">
                        <label
                            class="block text-gray-700 text-sm font-bold mb-2"
                            for="address"
                        >
                            Address
                        </label>
                        <vue-google-autocomplete
                            id="address"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            classname="form-control"
                            placeholder="Select Address"
                            v-on:placechanged="getAddressData"
                            v-model="form.address"
                        >
                        </vue-google-autocomplete>
                    </div>
                    <div class="mb-4 flow-root">
                        <div class="float-left w-5/12">
                            <label
                                class="block text-gray-700 text-sm font-bold mb-2"
                                for="lat"
                            >
                                Latitude
                            </label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="lat"
                                type="text"
                                placeholder="Latitude"
                                readonly
                                v-model="address.latitude"
                            />
                        </div>
                        <div class="float-right w-5/12">
                            <label
                                class="block text-gray-700 text-sm font-bold mb-2"
                                for="lng"
                            >
                                Longitude
                            </label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="lng"
                                type="text"
                                placeholder="Longitude"
                                readonly
                                v-model="address.longitude"
                            />
                        </div>
                    </div>
                    <div class="mb-4">
                        <label
                            class="block text-gray-700 text-sm font-bold mb-2"
                            for="type_id"
                        >
                            Boarding House Type
                        </label>
                        <VueMultiselect
                            v-model="selectedType"
                            :options="types"
                            label="name"
                            track-by="name"
                        >
                        </VueMultiselect>
                    </div>
                    <div class="mb-4">
                        <label
                            class="block text-gray-700 text-sm font-bold mb-2"
                            for="facilities_id[]"
                        >
                            Facilites
                        </label>
                        <multiselect
                            v-model="selectedFacility"
                            :options="facilities"
                            :multiple="true"
                            :close-on-select="false"
                            :clear-on-select="false"
                            :preserve-search="true"
                            placeholder="Select Facilities"
                            label="name"
                            track-by="name"
                        >
                        </multiselect>
                    </div>
                    <div class="mb-4">
                        <label
                            class="block text-gray-700 text-sm font-bold mb-2"
                            for="rooms"
                        >
                            Number of Rooms
                        </label>
                        <input
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="rooms"
                            type="text"
                            placeholder="rooms"
                            v-model="form.rooms"
                        />
                    </div>
                    <div class="mb-4">
                        <label
                            class="block text-gray-700 text-sm font-bold mb-2"
                            for="price"
                        >
                            Price per Month
                        </label>
                        <input
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="price"
                            type="text"
                            placeholder="price"
                            v-model="form.price"
                        />
                    </div>
                    <div class="mb-4">
                        <label
                            class="block text-gray-700 text-sm font-bold mb-2"
                            for="description"
                        >
                            Description
                        </label>
                        <input
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="description"
                            type="text"
                            placeholder="description"
                            v-model="form.description"
                        />
                    </div>
                    <div class="flex justify-center">
                        <button
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            type="submit"
                        >
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
