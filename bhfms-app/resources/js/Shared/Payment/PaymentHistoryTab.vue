<script setup>
defineProps({
    payment: Object
})
const emit = defineEmits(['showDetail']);

let showInvoiceDetail = (invoice_id) => {
    emit('showDetail',invoice_id);
}

let redirect = (url) => {
    window.location.href = url;
}

let convertTime = (date) =>{
    return new Date(date).toLocaleDateString()
}
</script>
<template>
    <div class="w-1/4 flex justify-center">
        <!-- Bisa pake css nanti kalo mau -->
        <p v-if="payment.payment_status=='late'" class="py-2 px-8 bg-red-600 border-2 w-min text-white rounded-md">
            Late
        </p>
        <p v-else-if="payment.payment_status=='pending'" class="py-2 px-5 bg-gray-600 border-2 w-min text-white rounded-md">
            Pending
        </p>
        <p v-else-if="payment.payment_status=='accept'" class="py-2 px-6 bg-green-600 border-2 w-min text-white rounded-md">
            Accept
        </p>
        <p  v-else-if="payment.payment_status=='rejected'" class="py-2 px-4 bg-yellow-400 border-2 w-min text-white rounded-md">
            Rejected
        </p>
        <p  v-else class="py-2 px-4 bg-yellow-400 border-2 w-min text-white">
            None
        </p>
    </div>
    <div class="w-1/4 m-auto">
        <p>
            {{ convertTime(payment.payment_date) }}
        </p>
    </div>
    <div class="w-1/4 m-auto">
        <p>
            {{ payment.boarding_name }}
        </p>
    </div>
    <div class="w-1/4 ">
        <button class="bg-blue-500 text-white rounded-md px-4 py-2" v-on:click="showInvoiceDetail(payment.invoice_id)">
            Details
        </button>
        <button class="bg-blue-600 text-white rounded-md px-6 py-2 ml-2" @click="redirect('/pay?order='+payment.invoice_id)">
            Pay
        </button>
    </div>
</template>
