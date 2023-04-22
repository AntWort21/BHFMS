<script setup>
defineProps({
    invoiceDetail: Array,
    price: String,
});
</script>

<template>
   <div @scroll.prevent class="fixed flex w-full h-full bg-black/70  top-0 left-0 right-0 bottom-0 overflow-hidden items-center align-center justify-center z-10 pointer-events-auto cursor-pointer" v-on:click="closeDetail">
        
   </div>
   <div class="relative flex p-8 min-w-fit h-fit align-center justify-center z-20 mb-3">
            <div class="relative flex flex-col bg-white/100 opacity-100">
                <div class="">
                    <h2>
                        Detail Payment
                    </h2>
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
                                    <p>Payment Date</p>
                                    <p>:</p>
                                </div>
                                <p class="px-5 w-7/12">{{ invoiceDetail.start_date }}</p>
                            </div>
                            <div class="flex flex-row">
                                <div class="flex flex-row w-5/12 justify-between">
                                    <p>Status</p>
                                    <p>:</p>
                                </div>
                                <p class="px-5 w-7/12">{{ invoiceDetail.payment_status }}</p>
                            </div>
                        </div>
                        <div class="flex flex-row justify-between my-10">
                            <p>Total Price</p>
                            <p>Rp {{ price }}</p>
                        </div>
                    </div>
                    <div class="flex flex-col border w-2/6">
                        <a v-if="invoiceDetail.payment_status=='pending'" href="pay?order=">Pay</a>
                        <a v-else href="">Review</a>
                        
                        <a>Chat</a>
                        <a>Complain</a>
                    </div>
                </div>
            </div>
        </div>
</template>
<script>
    export default {
        methods: {
            closeDetail() {
                this.$emit('closeDetail');
            }
        }
    }
</script>