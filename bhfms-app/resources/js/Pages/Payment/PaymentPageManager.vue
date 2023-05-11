<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import FormSelectInputTenant from '../../Shared/Payment/FormSelectInputTenant.vue';
import Header from '../../Shared/Header.vue';
import Footer from '../../Shared/Footer.vue';
import FormTextBoxInputReadOnly from '../../Shared/Payment/FormTextBoxInputReadOnly.vue';
import FormErrorMessage from '../../Shared/AccountFormInput/FormErrorMessage.vue';
import FormSelectInputTransactionType from '../../Shared/Payment/FormSelectInputTransactionType.vue';
import FormTextBoxInputPayment from '../../Shared/Payment/FormTextBoxInputPayment.vue';
import FormCheckboxInput from '../../Shared/Payment/FormCheckboxInput.vue';

defineProps({
    transaction: Array,
    listTenants: Array,
    boardingHouseName: String,
    transactionTypes: Array,
    tenant: Array
});

let form = useForm({
    paymentDate: "",
    paymentAmount: "",
    transactionType: "",
    tenantEmail: "",
    paymentRepeat: "",
    transactionType: "",
});

let submit = () => {
    form.post("/addPaymentManager");
};

const today = new Date();
today.setMinutes(today.getMinutes() - today.getTimezoneOffset());
const minToday = today.toISOString().split('T')[0];

</script>
<template>
    <Header />
    <div class="m-5">
        
    {{ transaction }}
    {{ tenant }}
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
                    :default-value="transaction.transaction_type_id"
                />
                <FormErrorMessage
                    :error-message="form.errors.transactionType"
                />
            </div>
            <div>
                <FormTextBoxInputPayment
                    v-model="form.paymentDate"
                        :input-type="'date'"
                        :label-name="'Date'"
                        :min-value="minToday"
                        :model-value="transaction.payment_date"/>
                <FormErrorMessage
                    :error-message="form.errors.paymentDate"
                />
            </div>
            <div>
                <FormTextBoxInputPayment
                    v-model="form.paymentAmount"
                        :input-type="'number'"
                        :label-name="'Amount'"
                        :min-value="'10000'"
                        :model-value="transaction.amount"/>
                <FormErrorMessage
                   :error-message="form.errors.paymentAmount"
                />
            </div>
            <div>
                <FormSelectInputTenant
                    v-model="form.tenantEmail"
                    :option-list="listTenants"
                    :label-desc="'Select Tenant'"
                    :label-name="'Tenant'"
                    :default-email="tenant.email"
                    :default-username="tenant.user_name"
                    />
                <FormErrorMessage
                    :error-message="form.errors.tenantEmail"
                />
            </div>
            <div clas>
                <FormCheckboxInput
                    v-model="form.paymentRepeat"
                        :label-name="'Repeat Payment'"
                        :default-value="tenant.repeat_payment"
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