<script setup>
import Header from "../../Shared/Header.vue";
import Footer from "../../Shared/Footer.vue";
import Carousel from "../../Shared/Carousel/Carousel.vue";
import FormTextBoxInput from "../../Shared/AccountFormInput/FormTextBoxInput.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { computed, ref, onMounted } from "vue";

defineProps({
    boardingHouseDetail: Object,
    facilityList: Object,
    images: Array,
    ownerName: String,
    ownerPicture: String,
    currVacancy: Number,
    isAvailable: Boolean,
});

let totalPrice = ref(null);

let form = useForm({
    startDate: "",
    endDate: "",
});

let submit = () => {
    form.post("/rent");
};
</script>

<template>
    <Header />
    <Carousel :slides="images" controls indicators interval class="my-8" />
    <!-- Trial only -->
    <!-- <div
        class="flow-root mt-4 items-center align-center flex shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
        v-for="img in images"
    >
        {{ img }}
    </div>

    {{ currVacancy }} -->
    <!-- End Trial Only -->
    <section class="mb-10 flex justify-center items-center">
        <div class="w-1/2">
            <div class="space-y-6">
                <div class="text-5xl font-semibold my-5 text-slate-800">
                    {{ boardingHouseDetail.boarding_name }}
                </div>
                <div class="my-10 text-lg font-semibold flex justify-end">
                    Save +
                </div>
                <hr class="w-full h-0.5 bg-slate-100 border-0" />
                <div class="flex">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="#000000"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <circle cx="12" cy="10" r="3" />
                        <path
                            d="M12 21.7C17.3 17 20 13 20 10a8 8 0 1 0-16 0c0 3 2.7 6.9 8 11.7z"
                        />
                    </svg>
                    {{ boardingHouseDetail.address }}
                </div>
                <div class="flex justify-between">
                    <div class="w-2/3">
                        <div class="font-semibold">Facilities</div>
                        <div v-for="facility in facilityList">
                            {{ facility }}
                        </div>
                    </div>
                    <form
                        class="w-1/3 flex justify-start items-center shadow-lg p-2"
                        @submit.prevent="submit"
                    >
                        <div
                            class="w-full flex flex-col items-center justify-center"
                        >
                            <div
                                v-if="isAvailable"
                                class="text-black font-semibold"
                            >
                                Capacity : {{ currVacancy }}
                            </div>
                            <div v-else class="text-red-500 font-semibold">
                                Capacity : {{ currVacancy }}
                            </div>
                            <div class="flex items-center">
                                <p class="text-xl font-semibold">
                                    IDR {{ boardingHouseDetail.price }}
                                </p>
                                <p>/month</p>
                            </div>
                            <div class="border border-solid border-slate-300">
                                <FormTextBoxInput
                                    v-model="form.startDate"
                                    :input-type="'date'"
                                    :label-name="'Start Date'"
                                />
                            </div>
                            <div class="w-1/2 flex justify-end mt-5">
                                <button
                                    class="w-36 h-10 bg-indigo-900 flex justify-center items-center text-white rounded-md disabled:opacity-50"
                                    :disabled="!isAvailable"
                                >
                                    Rent
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="flex justify-start">
                    <div
                        class="w-1/2 flex justify-between border-t-2 border-b-2 border-slate-100"
                    >
                        <div class="font-semibold">
                            Maintained By {{ ownerName }}
                        </div>
                        <img
                            :src="ownerPicture"
                            alt="no image"
                            class="w-[5rem] h-[5rem] rounded-full object-scale-down"
                        />
                    </div>
                </div>
                <div>
                    <div class="font-semibold">Related Boarding House</div>
                    <div>Similar Boarding House Description</div>
                    <div>Similar Boarding House List</div>
                </div>
                <div class="divide-y">
                    <div>
                        <div class="font-semibold text-xl">Reviews</div>
                        <div class="mt-2">
                            <div class="flex items-center space-x-1">
                                <span
                                    class="text-sm font-medium text-slate-600 dark:text-slate-500"
                                    >5</span
                                >
                                <div
                                    class="w-1/6 h-2 bg-slate-200 rounded dark:bg-slate-200"
                                >
                                    <div
                                        class="h-2 bg-yellow-400 rounded"
                                        style="width: 70%"
                                    ></div>
                                </div>
                                <span
                                    class="text-sm font-medium text-slate-600 dark:text-slate-500"
                                    >70%</span
                                >
                            </div>
                            <div class="flex items-center space-x-1">
                                <span
                                    class="text-sm font-medium text-slate-600 dark:text-slate-500"
                                    >4</span
                                >
                                <div
                                    class="w-1/6 h-2 bg-slate-200 rounded dark:bg-slate-200"
                                >
                                    <div
                                        class="h-2 bg-yellow-400 rounded"
                                        style="width: 17%"
                                    ></div>
                                </div>
                                <span
                                    class="text-sm font-medium text-slate-600 dark:text-slate-500"
                                    >17%</span
                                >
                            </div>
                            <div class="flex items-center space-x-1">
                                <span
                                    class="text-sm font-medium text-slate-600 dark:text-slate-500"
                                    >3</span
                                >
                                <div
                                    class="w-1/6 h-2 bg-slate-200 rounded dark:bg-slate-200"
                                >
                                    <div
                                        class="h-2 bg-yellow-400 rounded"
                                        style="width: 8%"
                                    ></div>
                                </div>
                                <span
                                    class="text-sm font-medium text-slate-600 dark:text-slate-500"
                                    >8%</span
                                >
                            </div>
                            <div class="flex items-center space-x-1">
                                <span
                                    class="text-sm font-medium text-slate-600 dark:text-slate-500"
                                    >2</span
                                >
                                <div
                                    class="w-1/6 h-2 bg-slate-200 rounded dark:bg-slate-200"
                                >
                                    <div
                                        class="h-2 bg-yellow-400 rounded"
                                        style="width: 8%"
                                    ></div>
                                </div>
                                <span
                                    class="text-sm font-medium text-slate-600 dark:text-slate-500"
                                    >8%</span
                                >
                            </div>
                            <div class="flex items-center space-x-1">
                                <span
                                    class="text-sm font-medium text-slate-600 dark:text-slate-500"
                                    >1</span
                                >
                                <div
                                    class="w-1/6 h-2 bg-slate-200 rounded dark:bg-slate-200"
                                >
                                    <div
                                        class="h-2 bg-yellow-400 rounded"
                                        style="width: 8%"
                                    ></div>
                                </div>
                                <span
                                    class="text-sm font-medium text-slate-600 dark:text-slate-500"
                                    >8%</span
                                >
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="flex space-x-20">
                            <div>All Reviews ($reviewCount)</div>
                        </div>
                        <div class="flex justify-start space-x-2 items-start">
                            <img
                                src=""
                                alt="no image"
                                class="w-6 h-6 rounded-xl"
                            />
                            <div>
                                <div class="text-md font-semibold">
                                    Anonymous User
                                </div>
                                <div class="flex text-xs space-x-1">
                                    <div>stars</div>
                                    <div>datetime</div>
                                </div>
                                <div>Good</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <Footer />
</template>
