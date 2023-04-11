<script setup>
// import { computed } from "vue";
// import { usePage } from "@inertiajs/inertia-vue3";
// import { numberLiteral } from "@babel/types";
import { computed, ref, watch } from "vue";
import { useForm, usePage } from "@inertiajs/inertia-vue3";
import VueMultiselect from "vue-multiselect";
import Multiselect from "vue-multiselect";
import VueGoogleAutocomplete from "vue-google-autocomplete";
import Header from "../../Shared/Header.vue";
import Footer from "../../Shared/Footer.vue";

defineProps({
    types: Object,
    facilities: Object,
    managers: Object,
    locations: Object,
    images: Array,
    // selectedType: Object,
    // selectedLocation: Object,
    // selectedFacility: Object,
    // selectedManager: Object,
});
const selectedType = ref("");
const selectedFacility = ref("");
const selectedManager = ref("");
const address = ref("");
const images = ref([]);

const getAddressData = (addressData, placeResultData, id) => {
    address.value = placeResultData.formatted_address;
    form.lat = addressData.latitude;
    form.lng = addressData.longitude;
};

const onFileChange = (e) => {
    const selectedFiles = e.target.files;
    for (let i = 0; i < selectedFiles.length; i++) {
        console.log(selectedFiles[i]);
        images.value.push(selectedFiles[i]);
    }

    for (let i = 0; i < images.value.length; i++) {
        let reader = new FileReader();
        reader.onload = (e) => {
            images.value[i].src = reader.result;
        };

        reader.readAsDataURL(images.value[i]);
    }
};

const customLabelManager = ({ user_name, email }) =>
    `${user_name} - (${email})`;

const form = useForm({
    name: "",
    address: address,
    type: selectedType,
    facility: selectedFacility,
    rooms: 0,
    price: 0,
    description: "",
    images: images,
    sharedBathroom: false,
    manager: selectedManager,
    currentUserID: usePage().props.user,
    lat: 0,
    lng: 0,
});

const submit = () => {
    form.post("/boarding/create", {
        preserveScroll: true,
        preserveState: true,
        // onSuccess: () => form.reset("password"),
    });
};
</script>
<template>
    <Header />
    <!-- Set ID of current User -->
    <!-- <input
        hidden
        id="currentUserID"
        type="text"
        :value="$page.props.user.user_name"
        v-model="form.currentUserID"
    /> -->

    <h1 v-if="$page.props.user">
        You are logged in as: {{ $page.props.user.user_name }}, with id =
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
                            placeholder="Boarding House Name"
                            v-model="form.name"
                        />
                        <div
                            v-if="form.errors.name"
                            v-text="form.errors.name"
                            class="text-red-500 text-xs mt-1"
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
                            types="address"
                            v-model="form.address"
                        >
                        </vue-google-autocomplete>
                        <div
                            v-if="form.errors.address"
                            v-text="form.errors.address"
                            class="text-red-500 text-xs mt-1"
                        />
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
                                v-model="form.lat"
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
                                v-model="form.lng"
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
                            :options="types.map((type) => type.id)"
                            :custom-label="
                                (opt) =>
                                    types.find((x) => x.id == opt)
                                        .boarding_type_name
                            "
                        >
                        </VueMultiselect>
                        <div
                            v-if="form.errors.type"
                            v-text="form.errors.type"
                            class="text-red-500 text-xs mt-1"
                        />
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
                            :options="facilities.map((facility) => facility.id)"
                            :custom-label="
                                (opt) =>
                                    facilities.find((x) => x.id == opt)
                                        .facility_detail_name
                            "
                            :multiple="true"
                            :close-on-select="false"
                            :clear-on-select="false"
                            :preserve-search="true"
                            placeholder="Select Facilities"
                        >
                        </multiselect>
                        <div
                            v-if="form.errors.facility"
                            v-text="form.errors.facility"
                            class="text-red-500 text-xs mt-1"
                        />
                    </div>
                    <div class="mb-4 flow-root">
                        <div class="float-left">
                            <label
                                class="block text-gray-700 text-sm font-bold mb-2"
                                for="sharedBathroom"
                            >
                                Shared Bathroom ?
                            </label>
                        </div>

                        <div class="flex float-right">
                            <input
                                v-model="form.sharedBathroom"
                                class="mb-2"
                                type="checkbox"
                                value=""
                                id="sharedBathroom"
                            />
                            <label
                                class="block text-gray-700 text-sm font-bold mb-2 ml-2"
                                for="sharedBathroom"
                            >
                                Check if True
                            </label>
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
                        <div
                            v-if="form.errors.price"
                            v-text="form.errors.price"
                            class="text-red-500 text-xs mt-1"
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
                        <div
                            v-if="form.errors.description"
                            v-text="form.errors.description"
                            class="text-red-500 text-xs mt-1"
                        />
                    </div>

                    <div class="mb-4">
                        <label
                            class="block text-gray-700 text-sm font-bold mb-2"
                            for="manager"
                        >
                            Select Manager (Optional)
                        </label>
                        <VueMultiselect
                            v-model="selectedManager"
                            :options="managers"
                            :custom-label="customLabelManager"
                            track-by="user_name"
                        >
                        </VueMultiselect>
                        <div
                            v-if="form.errors.manager"
                            v-text="form.errors.manager"
                            class="text-red-500 text-xs mt-1"
                        />
                    </div>

                    <div class="mb-4">
                        <label
                            class="block text-gray-700 text-sm font-bold mb-2"
                            for="images"
                        >
                            Pictures
                        </label>
                        <input
                            id="images"
                            type="file"
                            multiple
                            @change="onFileChange"
                            class="mb-2"
                        />
                        <div
                            v-if="form.errors.images"
                            v-text="form.errors.images"
                            class="text-red-500 text-xs mt-1"
                        />

                        <div
                            v-for="(image, key) in images"
                            :key="key"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        >
                            <img class="preview" :ref="'image'" />
                            {{ image.name }}
                        </div>
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
    <Footer />
</template>
