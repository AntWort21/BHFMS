<script setup>
// import { computed } from "vue";
// import { usePage } from "@inertiajs/inertia-vue3";
// import { numberLiteral } from "@babel/types";
import { ref, watch } from "vue";
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
    // selectedLoactionGoogle: Object,
});
let selectedType = ref("");
let selectedLocation = ref("");
let selectedFacility = ref("");
// let selectedLoactionGoogle = ref("");
const form = useForm({
    name: "",
    address: "",
    map_location: "",
    type_id: "",
    rooms: 0,
    shared_bathroom: false,
    price: 0,
    description: "",
});

const address = ref("");

const getAddressData = (addressData, placeResultData, id) => {
    address.value = addressData;
};

const customLabelLocation = ({
    country_name,
    province_name,
    city_name,
    district_name,
}) => `${country_name}, ${province_name}, ${city_name}, ${district_name}`;

// const customLabelLocation = ({ province_name, city_name, district_name }) =>
//     `${province_name} with an id of ${province_id} & ${city_id}`;
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
                <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
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
                        />
                    </div>
                    <div class="mb-4">
                        <label
                            class="block text-gray-700 text-sm font-bold mb-2"
                            for="address"
                        >
                            Address Google
                        </label>
                        <vue-google-autocomplete
                            id="address"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            classname="form-control"
                            placeholder="Start typing"
                            v-on:placechanged="getAddressData"
                        >
                        </vue-google-autocomplete>
                        <!-- <h1>
                            {{ address }}
                            {{ address.latitude }}
                            {{ address.longitude }}
                        </h1> -->
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
                                :value="address.latitude"
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
                                :value="address.longitude"
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
                            for="type_id"
                        >
                            Boarding House Location
                        </label>
                        <VueMultiselect
                            v-model="selectedLocation"
                            :options="locations"
                            :custom-label="customLabelLocation"
                        >
                        </VueMultiselect>
                    </div>
                    <!-- {{ selectedLocation.lat }} -->
                    <!-- {{ selectedLocation.lng }} -->
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
                                :value="selectedLocation.lat"
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
                                :value="selectedLocation.lng"
                            />
                        </div>
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
                        />
                    </div>
                    <div class="flex justify-center">
                        <button
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            type="button"
                        >
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
