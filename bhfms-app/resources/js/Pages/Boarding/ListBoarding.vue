<script setup>
import { Inertia } from "@inertiajs/inertia";
import { ref, watch } from "vue";
import Header from "../../Shared/Header.vue";
import Footer from "../../Shared/Footer.vue";
defineProps({
    all_count: Number,
    approved: Number,
    declined: Number,
    pending: Number,
    boardings: Object,
});

let search = ref("");
watch(search, (value) => {
    Inertia.get(
        "/boardings",
        { search: value },
        {
            preserveState: true,
        }
    );
});
</script>

<template>
    <Header />
    <!-- component -->
    <div class="overflow-x-auto">
        <div
            class="top-0 min-w-screen min-h-screen bg-gray-100 flex justify-center bg-gray font-sans overflow-hidden"
        >
            <!-- Filtering -->
            <div class="flow-root">
                <div class="flow-root">
                    <div class="mt-2 float-left">
                        <div
                            class="rounded border block bg-white border-gray-400 text-gray-700 py-2 px-4 flex"
                        >
                            <button
                                class="flex w-6 h-6 mr-5 text-base bg-blue-400 items-center font-bold justify-center text-white rounded-xl font-mono"
                            >
                                +
                            </button>
                            <h3 class="self-center">Add New Boarding</h3>
                        </div>
                    </div>
                    <div class="mt-2 float-right">
                        <select
                            class="rounded border block bg-white border-gray-400 text-gray-700 py-2 px-4"
                            v-model="search"
                        >
                            <option value="">All ({{ all_count }})</option>
                            <option value="approved">
                                Approved ({{ approved }})
                            </option>
                            <option value="pending">
                                Pending ({{ declined }})
                            </option>
                            <option value="declinded">
                                Declined ({{ pending }})
                            </option>
                        </select>
                    </div>
                </div>

                <div class="bg-white shadow-md rounded my-6">
                    <table class="min-w-max w-full table-auto">
                        <thead>
                            <tr class="uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">
                                    Boarding House Name
                                </th>
                                <th class="py-3 px-6 text-left">Status</th>
                                <th class="py-3 px-6 text-center">
                                    See Details
                                </th>
                                <th class="py-3 px-6 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            <tr
                                v-for="boarding in boardings"
                                class="border-b border-gray-200 bg-gray-50 hover:bg-gray-100"
                            >
                                <td class="py-3 px-6 text-left">
                                    <div class="flex items-center">
                                        <div class="mr-2">
                                            <img
                                                class="w-6 h-6"
                                                src="https://img.icons8.com/color/100/000000/vue-js.png"
                                            />
                                        </div>
                                        <span class="font-medium"
                                            >{{ boarding.name }}
                                        </span>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left">
                                    <span
                                        v-if="boarding.status == 'approved'"
                                        class="bg-green-200 text-green-600 py-1 px-3 rounded-full text-xs"
                                    >
                                        Approved
                                    </span>

                                    <span
                                        v-else-if="boarding.status == 'pending'"
                                        class="bg-yellow-200 text-yellow-600 py-1 px-3 rounded-full text-xs"
                                        >Pending</span
                                    >

                                    <span
                                        v-else
                                        class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs"
                                        >Declined</span
                                    >
                                </td>

                                <td class="py-3 px-6 text-center">
                                    <a href="#">see details</a>
                                </td>

                                <td class="py-3 px-6 text-center">
                                    <div
                                        class="flex item-center justify-center"
                                    >
                                        <div
                                            class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110"
                                        >
                                            <a href="http://">
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                                    />
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                                    />
                                                </svg>
                                            </a>
                                        </div>
                                        <div
                                            class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110"
                                        >
                                            <a href="http://">
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
                                                    />
                                                </svg>
                                            </a>
                                        </div>
                                        <div
                                            class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110"
                                        >
                                            <a href="http://">
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                                    />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <Footer />
</template>
