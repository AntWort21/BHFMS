<script setup>
defineProps({
    invoiceDetail: Object,
    price: String,
    userRole: Number,
});

const emit = defineEmits(['closeDetail']);
let query = new URLSearchParams(window.location.search);
let closeDetail = () => {
    emit('closeDetail');
}

let convertTime = (date) =>{
    return new Date(date).toLocaleDateString();
}

let redirect = (url) => {
    window.location.href = url;
}

let getFileName = (payment_date, invoice_id) => {
    // const dateParts = payment_date.split('-');
    // console.log(new Date(payment_date).toISOString());
    console.log(payment_date);
//     const year = date.getUTCFullYear();
// const month = date.getUTCMonth();
// const day = date.getUTCDate();
//     const year = dateParts[0];
//     const month = dateParts[1] - 1; // month is 0-based in JS
//     const day = dateParts[2];
// console.log(new Date().toISOString())
    // console.log(new Date(Date.UTC(year, month, day)).toISOString());
    return new Date(payment_date).toISOString().slice(0,10).replace(/-/g,"")
  + invoice_id + '.png';
    // +invoice_id+'.png';

}
</script>

<template>
   <div @scroll.prevent class="fixed flex w-full h-full bg-black/70  top-0 left-0 right-0 bottom-0 overflow-hidden items-center align-middle justify-center z-10 pointer-events-auto cursor-pointer" v-on:click="closeDetail">
        
   </div>
   <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-10">
            <div class="relative flex flex-col bg-white/100 opacity-100">
                <div class="flex flex-row justify-between p-2">
                    <h2>
                        Detail Payment
                    </h2>
                    <button v-on:click="closeDetail">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
                <div class="h-full w-full flex flex-row">
                    <div class="flex flex-col w-4/6 border px-5 py-2">
                        <div class="w-full space-y-4">
                            <div class="flex flex-row">
                                <div class="flex flex-row w-5/12 justify-between">
                                    <p>Invoice No</p>
                                    <p>:</p>
                                </div>
                                <a class="px-5 text-blue-500  w-7/12" href="">{{ invoiceDetail.invoice_id }}</a>
                            </div>
                            <div class="flex flex-row">
                                <div class="flex flex-row w-5/12 justify-between">
                                    <p>Tennant</p>
                                    <p>:</p>
                                </div>
                                <p class="px-5 w-7/12">{{ invoiceDetail.user_name }}</p>
                            </div>
                            <div class="flex flex-row">
                                <div class="flex flex-row w-5/12 justify-between">
                                    <p>Boarding House</p>
                                    <p>:</p>
                                </div>
                                <p class="px-5 w-7/12">{{ invoiceDetail.boarding_name }}</p>
                            </div>
                            <div class="flex flex-row">
                                <div class="flex flex-row w-5/12 justify-between">
                                    <p>Transaction Type</p>
                                    <p>:</p>
                                </div>
                                <p class="px-5 w-7/12">{{ invoiceDetail.transaction_type_name }}</p>
                            </div>
                            <div class="flex flex-row">
                                <div class="flex flex-row w-5/12 justify-between">
                                    <p>Payment Date</p>
                                    <p>:</p>
                                </div>
                                <p class="px-5 w-7/12">{{ convertTime(invoiceDetail.payment_date) }}</p>
                            </div>
                            <div class="flex flex-row">
                                <div class="flex flex-row w-5/12 justify-between">
                                    <p>Status</p>
                                    <p>:</p>
                                </div>
                                <p class="px-5 w-7/12">{{ invoiceDetail.payment_status }}</p>
                            </div>
                            <div class="flex flex-row"
                            v-if="invoiceDetail.payment_status=='Processing'||invoiceDetail.payment_status=='Approved'">
                                <div class="flex flex-row w-5/12 justify-between">
                                    <p>Proof Of Payment</p>
                                    <p>:</p>
                                </div>
                                <img 
                                class="px-5 w-7/12 appearance-none"
                                v-if="invoiceDetail.payment_date"
                                :src="`/storage/proofOfPayment/`+getFileName(invoiceDetail.payment_date, invoiceDetail.invoice_id)"
                                alt="Proof Of Payment">
                            </div>
                        </div>
                        <div class="flex flex-row justify-between my-10">
                            <p>Total Price</p>
                            <p>Rp {{ price }}</p>
                        </div>
                    </div>
                    <div class="flex flex-col border w-2/6 px-3 items-center">
                        <button class="mt-4 mb-2 bg-blue-500 py-1 w-24 text-white rounded-full" v-if="invoiceDetail.payment_status=='Pending' && userRole==2" @click="redirect('/pay?order='+invoiceDetail.invoice_id)">Pay</button>
                        <button class="mt-4 mb-2 bg-blue-500 py-1 w-24 text-white rounded-full" v-else-if="invoiceDetail.payment_status=='Approved' && userRole==2" href="">Review</button>
                        
                        <button class="my-2 bg-blue-500 py-1 w-24 text-white rounded-full">Chat</button>
                        
                        <button class="my-2 bg-blue-500 py-1 w-24 text-white rounded-full" v-if="userRole==2">Complain</button>
                        <button class="my-2 bg-blue-500 py-1 w-24 text-white rounded-full" v-else-if="userRole==1||userRole==3" @click="redirect('/cancelPayment?order='+invoiceDetail.invoice_id+'&boarding='+query.get('boarding'))">Cancel</button>

                    </div>
                </div>
            </div>
        </div>
</template>