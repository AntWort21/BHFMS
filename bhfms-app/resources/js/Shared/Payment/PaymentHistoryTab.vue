<script setup>
defineProps({
    payment: Object
})
</script>
<template>
    <div class="w-1/4 flex justify-center">
        <!-- Bisa pake css nanti kalo mau -->
        <p v-if="payment.payment_status=='late'" class="py-2 px-8 bg-red-600 border-2 w-min text-white">
            Late
        </p>
        <p v-else-if="payment.payment_status=='pending'" class="py-2 px-5 bg-gray-600 border-2 w-min text-white">
            Pending
        </p>
        <p v-else-if="payment.payment_status=='accept'" class="py-2 px-6 bg-green-600 border-2 w-min text-white">
            Accept
        </p>
        <p  v-else-if="payment.payment_status=='rejected'" class="py-2 px-4 bg-yellow-400 border-2 w-min text-white">
            Rejected
        </p>
        <p  v-else class="py-2 px-4 bg-yellow-400 border-2 w-min text-white">
            None
        </p>
    </div>
    <div class="w-1/4 m-auto">
        <p>
            {{ payment.start_date }}
        </p>
    </div>
    <div class="w-1/4 m-auto">
        <p>
            {{ payment.boarding_name }}
        </p>
    </div>
    <div class="w-1/4">
        <button class="bg-blue-600 text-white p-2" v-on:click="showInvoiceDetail(payment.invoice_id)">
            Details
        </button>
    </div>
</template>
<script>
    export default {
        methods: {
            showInvoiceDetail(invoice_id) {
                this.$emit('showDetail',invoice_id);
            }
        }
    }
</script>
