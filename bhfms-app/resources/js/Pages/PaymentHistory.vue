<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import PaymentHistoryTab from '../Shared/PaymentHistoryTab.vue';
defineProps({
  type: String,
  listPayments: Array
})
</script>

<template>
    <section class="flex justify-between text-center align-middle mx-10">
        <div class="font-bold self-center">
            <h3>
                Payment List
            </h3>
        </div>
        <div class="flex flex-row">
            <button class="flex flex-row w-6 h-6 mr-5 text-base bg-blue-400 items-center font-bold justify-center text-white rounded-xl font-mono">
                +
            </button>
            <h3 class="self-center">Add New Payment</h3>
        </div>
    </section>
    <section class="mx-2">
        <div class="flex justify-around text-center">
            <div class="w-1/4">
                <h4>Status</h4>
            </div>
            <div class="w-1/4">
                <h4>Date</h4>
            </div>
            <div class="w-1/4">
                <h4 v-if="type=='Tenant'">Tenant Name</h4>
                <h4 v-else-if="type=='Manager'">Boarding House</h4>
                <h4 v-else>Boarding House</h4>
            </div>
            <div class="w-1/4">
            </div>
        </div>
    </section>
    <section class="mx-2 my-3">
<!--
// 0 = late
// 1 = pending
// 2 = accept
// 3 = canceled
 -->
        <div v-for="payment in listPayments" class="flex justify-around text-center py-1">
            <PaymentHistoryTab
            payment="payment">
            </PaymentHistoryTab>
        </div>
    </section>
</template>
