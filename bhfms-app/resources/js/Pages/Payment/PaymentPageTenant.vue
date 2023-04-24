<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import FormSelectInputTenant from '../../Shared/Payment/FormSelectInputTenant.vue';
import Header from '../../Shared/Header.vue';
import Footer from '../../Shared/Footer.vue';
import FormTextBoxInputReadOnly from '../../Shared/Payment/FormTextBoxInputReadOnly.vue';
import FormErrorMessage from '../../Shared/AccountFormInput/FormErrorMessage.vue';
import FormSelectInputPaymentType from '../../Shared/Payment/FormSelectInputPaymentType.vue';

defineProps({
    listPaymentType: Array,
    paymentDetail: Object
});

let form = useForm({
    paymentDate: "",
    paymentAmount: "",
    tenantEmail: "",
    paymentRepeat: "",
});

let submit = () => {
    form.post("/addPaymentTenant");
};

let convertAmount = (amount) => {
    return new Number(amount).toLocaleString("id-ID");
}
</script>
<template>
    <Header />
    <div class="m-5">
        <h2 class="mb-3">Make Payment</h2>
        <form @submit.prevent="submit">
            <div>
                <FormTextBoxInputReadOnly
                    v-model="form.boardingHouseName"
                    :input-type="'text'"
                    :label-name="'Boarding House Name'"
                    :value="paymentDetail.boarding_name"
                    />
            </div>
            <div>
                <FormTextBoxInputReadOnly
                    v-model="form.paymentDate"
                        :input-type="'date'"
                        :label-name="'Month'"
                        :value="paymentDetail.payment_date"
                        />
            </div>
            <div>
                <FormSelectInputPaymentType
                    v-model="form.paymentType"
                    :option-list="listPaymentType"
                    :label-desc="'Payment Type'"
                    :label-name="'Payment Type'"
                    :default-text="'Select Payment Type'"
                />
                <FormErrorMessage
                    :error-message="form.errors.paymentType"
                />
            </div>
            <div>
                <FormTextBoxInputReadOnly
                    v-model="form.paymentAmount"
                        :input-type="'text'"
                        :label-name="'Amount'"
                        :value="convertAmount(paymentDetail.amount)"/>
                <FormErrorMessage
                   :error-message="form.errors.paymentAmount"
                />
            </div>
            <div>

            </div>
            <div>
                <div>
                <label class="block">Upload Proof of Payment</label>
                <input
                    type="file"
                    @input="form.pictureFile = $event.target.files[0]"
                    accept="image/x-png,image/jpeg"
                    class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600"
                />
            </div>
            </div>

            <button
                class="px-6 py-2 mt-4 text-white bg-blue-600 rounded-lg hover:bg-blue-900">
                Make Payment
            </button>
        </form>
    </div>
    <Footer />
</template>