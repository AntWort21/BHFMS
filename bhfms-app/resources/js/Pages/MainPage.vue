<script setup>
import { Link, useForm } from "@inertiajs/inertia-vue3";
import Footer from "../Shared/Footer.vue";
import VueGoogleAutocomplete from "vue-google-autocomplete";
import Header from "../Shared/Header.vue";
import { ref } from "vue";

const address = ref("");

const onPlaceChanged = (addressData, placeResultData) => {
    form.address = placeResultData.formatted_address;
    form.latitude = addressData.latitude
    form.longitude = addressData.longitude
}

const form = useForm({
    address: "",
    latitude: 0,
    longitude: 0
})

const submit = () => {
    form.post('/search')
}
</script>

<template>
    <Header />
    <section>
        <div
            class="w-full h-[80vh] flex items-center justify-start bg-cover"
            style="background-image: url('../storage/sofa.png')"
        >
            <div
                class="w-[45vh] px-8 py-6 mt-4 text-left ml-80 border-gray-500 rounded bg-white bg-opacity-60 rounded-3xl"
            >
                <form @submit.prevent="submit">
                    <div class="mt-4 space-y-3">
                        <p class="text-3xl text-gray-900 font-semibold">
                            Have a location in mind?
                        </p>
                        <p class="text-lg text-gray-900 font-semibold">
                            Find your ideal place to stay
                        </p>
                        <div
                            class="flex w-full h-[3rem] justify-between border border-gray-500 bg-white rounded-3xl items-center p-3"
                        >
                            <vue-google-autocomplete
                                id="autocomplete"
                                class="w-full h-[2rem] rounded-3xl items-center p-3"
                                placeholder="Search Here"
                                v-model="address"
                                v-on:placechanged="onPlaceChanged"
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
                                        <line
                                            x1="21"
                                            y1="21"
                                            x2="16.65"
                                            y2="16.65"
                                        ></line>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="mx-16 my-2 space-y-2">
            <!-- see all accomodation -->
            <p class="text-2xl font-semibold">See All Accomodation</p>
            <p class="text-md text-gray-600">
                Look at all of our registered accomodation
            </p>
            <div
                class="w-full h-[50vh] flex justify-center items-end"
                style="background-image: url('../storage/sofa.png')"
            >
                <Link
                    href="/boarding/all"
                    class="w-60 h-14 mb-32 bg-white flex items-center justify-center rounded-md"
                >
                    Discover Accomodation
                    <div class="ml-3 text-lg">></div>
                </Link>
            </div>
        </div>
        <div class="mx-16 my-2 space-y-2">
            <!-- Highly rated experience -->
            <p class="text-2xl font-semibold">Highly Rated Experiences</p>
            <p class="text-md text-gray-600">
                Look at our highly rated accomodation
            </p>
            <div class="w-full h-[50vh] bg-gray-500 flex">
                <div class="w-1/6 my-2 mr-2 bg-white">
                    <div class="h-2/3 bg-gray-200">ini buat pic</div>
                    <div class="h-1/3 space-y-2">
                        <div class="text-xs text-gray-600">Cayman Islands</div>
                        <div class="font-semibold">Boarding House Name</div>
                        <div class="text-sm">
                            Description Description Description Description
                            Description Description Description Description
                            Description Description Description Description
                        </div>
                    </div>
                </div>
                <div class="w-1/6 my-2 mx-2 bg-white">
                    <div class="h-2/3 bg-gray-200">ini buat pic</div>
                    <div class="h-1/3 space-y-2">
                        <div class="text-xs text-gray-600">Cayman Islands</div>
                        <div class="font-semibold">Boarding House Name</div>
                        <div class="text-sm">
                            Description Description Description Description
                            Description Description Description Description
                            Description Description Description Description
                        </div>
                    </div>
                </div>
                <div class="w-1/6 my-2 mx-2 bg-white">
                    <div class="h-2/3 bg-gray-200">ini buat pic</div>
                    <div class="h-1/3 space-y-2">
                        <div class="text-xs text-gray-600">Cayman Islands</div>
                        <div class="font-semibold">Boarding House Name</div>
                        <div class="text-sm">
                            Description Description Description Description
                            Description Description Description Description
                            Description Description Description Description
                        </div>
                    </div>
                </div>
                <div class="w-1/6 my-2 mx-2 bg-white">
                    <div class="h-2/3 bg-gray-200">ini buat pic</div>
                    <div class="h-1/3 space-y-2">
                        <div class="text-xs text-gray-600">Cayman Islands</div>
                        <div class="font-semibold">Boarding House Name</div>
                        <div class="text-sm">
                            Description Description Description Description
                            Description Description Description Description
                            Description Description Description Description
                        </div>
                    </div>
                </div>
                <div class="w-1/6 my-2 mx-2 bg-white">
                    <div class="h-2/3 bg-gray-200">ini buat pic</div>
                    <div class="h-1/3 space-y-2">
                        <div class="text-xs text-gray-600">Cayman Islands</div>
                        <div class="font-semibold">Boarding House Name</div>
                        <div class="text-sm">
                            Description Description Description Description
                            Description Description Description Description
                            Description Description Description Description
                        </div>
                    </div>
                </div>
                <div class="w-1/6 my-2 ml-2 bg-white">
                    <div class="h-2/3 bg-gray-200">ini buat pic</div>
                    <div class="h-1/3 space-y-2">
                        <div class="text-xs text-gray-600">Cayman Islands</div>
                        <div class="font-semibold">Boarding House Name</div>
                        <div class="text-sm">
                            Description Description Description Description
                            Description Description Description Description
                            Description Description Description Description
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <Footer />
</template>
