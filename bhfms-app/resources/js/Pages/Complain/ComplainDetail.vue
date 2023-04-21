<script setup>
import Footer from "../../Shared/Footer.vue";
import Header from "../../Shared/Header.vue";
import FormErrorMessage from "../../Shared/AccountFormInput/FormErrorMessage.vue";
import FormSelectInput from "../../Shared/AccountFormInput/FormSelectInput.vue";

defineProps({
    complainType: String,
    complain: Object,
});
</script>

<template>
    <Header />
    <section class="h-[75vh] p-10">
        <div class="border border-slate-200 space-y-2 px-4 py-6">
            <div class="semibold text-2xl text-indigo-700">Complain Detail</div>
            <div>
                <label class="block font-semibold">Status</label>
                <div
                    :class="{
                        'text-red-600': complain.complain_status == 'pending',
                        'text-green-600':
                            complain.complain_status == 'finished',
                    }"
                >
                    {{ complain.complain_status }}
                </div>
            </div>
            <div>
                <label class="block font-semibold">Complain Type</label>
                <input
                    :value="complainType"
                    class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600"
                    disabled
                />
            </div>
            <div>
                <label class="block font-semibold">Complain Description</label>
                <textarea
                    :value="complain.complain_desc"
                    class="w-full h-[20vh] p-2.5 border border-gray-300 rounded-lg"
                    placeholder="Please describe your problem"
                    disabled
                />
            </div>
            <div>
                <label class="block font-semibold">Photo/Files</label>
                <img
                    :src="complain.complain_image_url"
                    class="w-40 h-40 object-cover"
                />
            </div>
        </div>
    </section>
    <Footer />
</template>
