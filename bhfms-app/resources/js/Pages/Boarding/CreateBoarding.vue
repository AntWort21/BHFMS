<script setup>
// import { computed } from "vue";
// import { usePage } from "@inertiajs/inertia-vue3";
// import { numberLiteral } from "@babel/types";
import { ref, watch } from "vue";
import { useForm, Head } from "@inertiajs/inertia-vue3";
import VueMultiselect from "vue-multiselect";
import Multiselect from "vue-multiselect";
defineProps({
    types: Object,
    selected: Object,
});
let selected = ref("");
// const user = computed(() => usePage().props.auth.user);
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

const customLabel = ({ name, id }) => `${name} with an id of ${id}`;
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
                            Address
                        </label>
                        <input
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="address"
                            type="text"
                            placeholder="address"
                        />
                    </div>
                    <div class="mb-4">
                        <label
                            class="block text-gray-700 text-sm font-bold mb-2"
                            for="map_location"
                        >
                            map_location
                        </label>
                        <input
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="map_location"
                            type="text"
                            placeholder="map_location"
                        />
                    </div>
                    <div class="mb-4">
                        <label
                            class="block text-gray-700 text-sm font-bold mb-2"
                            for="type_id"
                        >
                            Boarding House Type
                        </label>
                        <select
                            data-te-select-init
                            data-te-select-filter="true"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="type_id"
                            type="text"
                            placeholder="type_id"
                        >
                            <option v-for="typ in types" value="{{ typ.id }}">
                                {{ typ.id }} - {{ typ.name }}
                            </option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label
                            class="block text-gray-700 text-sm font-bold mb-2"
                            for="type_id"
                        >
                            Boarding House Type w/ NPM
                        </label>
                        <VueMultiselect
                            v-model="selected"
                            :options="types"
                            :custom-label="customLabel"
                            label="name"
                            track-by="name"
                        >
                        </VueMultiselect>
                    </div>
                    {{ selected.id }}
                    <div class="mb-4">
                        <label
                            class="block text-gray-700 text-sm font-bold mb-2"
                            for="type_id"
                        >
                            Boarding House Type w/ NPM Multi Select
                        </label>
                        <multiselect
                            v-model="selected"
                            :options="types"
                            :multiple="true"
                            :close-on-select="false"
                            :clear-on-select="false"
                            :preserve-search="true"
                            placeholder="Pick some"
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
                            rooms
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
                            for="shared_bathroom"
                        >
                            shared_bathroom
                        </label>
                        <input
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="shared_bathroom"
                            type="text"
                            placeholder="shared_bathroom"
                        />
                    </div>
                    <div class="mb-4">
                        <label
                            class="block text-gray-700 text-sm font-bold mb-2"
                            for="price"
                        >
                            price
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
                            description
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
