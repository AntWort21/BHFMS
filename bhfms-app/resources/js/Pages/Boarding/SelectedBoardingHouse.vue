<script setup>
import Header from "../../Shared/Header.vue";
import Footer from "../../Shared/Footer.vue";
import Carousel from "../../Shared/Carousel/Carousel.vue";
import FormTextBoxInput from "../../Shared/AccountFormInput/FormTextBoxInput.vue";
import { useForm } from "@inertiajs/inertia-vue3";

defineProps({
    boardingHouseDetail: Object,
    images: Array,
});

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
    <section>
        <Carousel :slides="images" controls indicators interval />
        <div class="mx-5 space-y-5">
            <div class="text-5xl font-semibold">
                {{ boardingHouseDetail.name }}
            </div>
            <div class="flex justify-between my-10 text-lg font-semibold">
                <div>Description</div>
                <div>Add to Wishlist +</div>
            </div>
            <div>
                {{ boardingHouseDetail.description }}
            </div>
            <div class="flex justify-between">
                <div class="w-1/2">
                    <div class="font-semibold">Owner</div>
                    <div>ownerName</div>
                </div>
                <div class="w-1/2">
                    <div>Location</div>
                    <div>
                        {{ boardingHouseDetail.address }}
                    </div>
                </div>
            </div>
            <div class="flex justify-between">
                <div class="w-1/2">
                    <div class="font-semibold">Facilities</div>
                    <div>List Facilities</div>
                </div>
                <form class="w-1/2" @submit.prevent="submit">
                    <div>IDR [Insert Price Here] per Month</div>
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
                    <div>Total Price:</div>
                    <div class="w-1/2 flex justify-end">
                        <button
                            class="w-20 h-10 bg-indigo-900 flex justify-center items-center text-white"
                        >
                            Rent
                        </button>
                    </div>
                </form>
            </div>
            <div>
                <div class="font-semibold">Similar Boarding House</div>
                <div>
                    Similar Boarding House Description Similar Boarding House
                    Description Similar Boarding House Description Similar
                    Boarding House Description Similar Boarding House
                    Description
                </div>
                <div>Similar Boarding House List</div>
            </div>
            <div>
                <div class="font-semibold">Reviews</div>
                <div>
                    <div>4.0 * and graph</div>
                    <div>----------------------</div>
                </div>
                <div class="flex space-x-20">
                    <div>All Reviews($reviewCount)</div>
                    <div>+ Add Review</div>
                </div>
                <div>List Review</div>
            </div>
        </div>
    </section>
    <Footer />
</template>
