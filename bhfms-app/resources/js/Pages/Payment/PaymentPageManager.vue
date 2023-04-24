<script setup>
import { Link, useForm } from '@inertiajs/inertia-vue3';
import FormSelectInputTenant from '../../Shared/Payment/FormSelectInputTenant.vue';
import Header from '../../Shared/Header.vue';
import Footer from '../../Shared/Footer.vue';
import FormTextBoxInputReadOnly from '../../Shared/Payment/FormTextBoxInputReadOnly.vue';
import FormErrorMessage from '../../Shared/AccountFormInput/FormErrorMessage.vue';
import FormTextBoxInput from '../../Shared/AccountFormInput/FormTextBoxInput.vue';
import FormSelectInputTransactionType from '../../Shared/Payment/FormSelectInputTransactionType.vue';


defineProps({
    listTenants: Array,
    boardingHouseName: String,
    transactionTypes: Array
});

let form = useForm({
    paymentDate: "",
    paymentAmount: "",
    tenantEmail: "",
    paymentRepeat: "",
    transactionType: "",
});

let submit = () => {
    form.post("/addPaymentManager");
};
</script>
<template>
    <Header />
    <div class="m-5">
        <h3>Payment Page</h3>
        <form @submit.prevent="submit">
            <div>
            <FormTextBoxInputReadOnly
                v-model="form.boardingHouseName"
                    :input-type="'text'"
                    :label-name="'Boarding House Name'"
                    :value="boardingHouseName.boarding_name"/>
            </div>
            <div>
                <FormSelectInputTransactionType
                    v-model="form.transactionType"
                    :option-list="transactionTypes"
                    :label-desc="'Transaction Type'"
                    :label-name="'Transaction Type'"
                    :default-text="'Select Transaction Type'"
                />
                <FormErrorMessage
                    :error-message="form.errors.transactionType"
                />
            </div>
            <div>
                <FormTextBoxInput
                    v-model="form.paymentDate"
                        :input-type="'date'"
                        :label-name="'Month'"/>
                <FormErrorMessage
                    :error-message="form.errors.paymentDate"
                />
            </div>
            <div>
                <FormTextBoxInput
                    v-model="form.paymentAmount"
                        :input-type="'number'"
                        :label-name="'Amount'"/>
                <FormErrorMessage
                   :error-message="form.errors.paymentAmount"
                />
            </div>
            <div>
                <FormSelectInputTenant
                    v-model="form.tenantEmail"
                    :option-list="listTenants"
                    :label-desc="'Tenant'"
                    :label-name="'Tenant'"
                />
                <FormErrorMessage
                    :error-message="form.errors.tenantEmail"
                />
            </div>
            <div>
                <FormTextBoxInput
                    v-model="form.paymentRepeat"
                        :input-type="'radio'"
                        :label-name="'Repeat Payment'"
                />
                <FormErrorMessage
                    :error-message="form.errors.paymentRepeat"
                />
            </div>
            <button
                class="px-6 py-2 mt-4 text-white bg-blue-600 rounded-lg hover:bg-blue-900">
                Add Payment
            </button>
        </form>
    </div>
    <Footer />
</template>