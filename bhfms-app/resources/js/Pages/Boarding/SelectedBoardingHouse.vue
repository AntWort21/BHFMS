<script setup>
import Header from "../../Shared/Header.vue";
import Footer from "../../Shared/Footer.vue";
import Carousel from "../../Shared/Carousel/Carousel.vue";
import FormTextBoxInput from "../../Shared/AccountFormInput/FormTextBoxInput.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { ref } from "vue";

defineProps({
    boardingHouseDetail: Object,
    facilityList: Object,
    images: Array,
    ownerName: String,
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
    <section class="mb-10">
        <Carousel :slides="images" controls indicators interval />
        <div class="mx-5 space-y-5">
            <div class="text-5xl font-semibold">
                {{ boardingHouseDetail.boarding_name }}
            </div>
            <div class="flex justify-between my-10 text-lg font-semibold">
                <div>Description</div>
                <div>Add to Wishlist +</div>
            </div>
            <div>
                {{ boardingHouseDetail.boarding_desc }}
            </div>
            <div class="flex justify-between">
                <div class="w-1/2">
                    <div class="font-semibold">Owner</div>
                    <div>{{ ownerName }}</div>
                </div>
                <div class="w-1/2">
                    <div class="font-semibold">Location</div>
                    <div>
                        {{ boardingHouseDetail.address }}
                    </div>
                </div>
            </div>
            <div class="flex justify-between">
                <div class="w-1/2">
                    <div class="font-semibold">Facilities</div>
                    <div v-for="facility in facilityList">{{ facility }}</div>
                </div>
                <form class="w-1/2" @submit.prevent="submit">
                    <div>IDR {{ boardingHouseDetail.price }} per Month</div>
                    <div class="flex justify-between">
                        <div class="w-1/2">
                            <div class="border border-solid border-slate-300">
                                <FormTextBoxInput
                                    v-model="form.startDate"
                                    :input-type="'date'"
                                    :label-name="'Check In'"
                                />
                            </div>
                        </div>
                        <div class="w-1/2">
                            <div class="border border-solid border-slate-300">
                                <FormTextBoxInput
                                    v-model="form.endDate"
                                    :input-type="'date'"
                                    :label-name="'Check Out'"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-center mt-5">
                        <button
                            class="w-36 h-10 bg-indigo-900 flex justify-center items-center text-white rounded-md"
                        >
                            Rent
                        </button>
                    </div>
                </form>
            </div>
            <div>
                <div class="font-semibold">Similar Boarding House</div>
                <div>
                    Similar Boarding House Description
                </div>
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
                        <div>+ Add Review</div>
                    </div>
                    <div class="flex justify-start space-x-2 items-start">
                        <img src="" alt="no image" class="w-6 h-6 rounded-xl" />
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
    </section>
    <Footer />
</template>
