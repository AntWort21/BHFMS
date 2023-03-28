<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import Footer from "../Shared/Footer.vue";
import FormErrorMessage from "../Shared/FormErrorMessage.vue";
import FormTextBoxInput from "../Shared/FormTextBoxInput.vue";
import Header from "../Shared/Header.vue";
</script>

<template>
    <Header />
    <section>
        <div
            class="w-full h-[80vh] flex items-center justify-start bg-cover"
            style="background-image: url('../storage/sofa.png')"
        >
            <div
                class="w-[45vh] px-8 py-6 mt-4 text-left shadow-lg ml-80 bg-white"
            >
                <form @submit.prevent="submit">
                    <div class="mt-4 space-y-3">
                        <FormTextBoxInput
                            :input-type="'text'"
                            :label-name="'Location'"
                        />
                        <FormTextBoxInput
                            :input-type="'text'"
                            :label-name="'Rental Period'"
                        />
                        <FormTextBoxInput
                            :input-type="'text'"
                            :label-name="'Number of Tenants'"
                        />
                        <div
                            class="flex items-baseline justify-end items-center space-x-10"
                        >
                            <button
                                class="px-6 py-2 mt-4 text-white bg-indigo-900 rounded-lg hover:bg-blue-900"
                            >
                                Search
                            </button>
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
                    href="#"
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
