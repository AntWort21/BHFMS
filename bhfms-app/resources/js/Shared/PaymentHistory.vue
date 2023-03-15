<script setup>
import { Link } from '@inertiajs/inertia-vue3';
defineProps({
  type: String,
  listPayments: Array
})
</script>

<template>
    <section class="flex justify-between text-center align-middle mx-10">
        <div class="font-bold self-center">
            <p>
                Payment List
            </p>
        </div>
        <div class="flex flex-row">
            <button class="flex flex-row w-6 h-6 mr-5 text-base bg-blue-400 items-center font-bold justify-center text-white rounded-xl font-mono">
                +
            </button>
            <p class="self-center">Add New Payment</p>
        </div>
    </section>
    <section class="mx-2">
        <div class="flex justify-around text-center">
            <div class="w-1/4">
                <p>Status</p>
            </div>
            <div class="w-1/4">
                <p>Date</p>
            </div>
            <div class="w-1/4">
                <p v-if="type=='Tenant'">Tenant Name</p>
                <p v-else-if="type=='Manager'">Boarding House</p>
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
        <div v-for="payment of listPayments" class="flex justify-around text-center py-1">
            <div class="w-1/4 flex justify-center">
                <p v-if="payment[0]==0" class="py-2 px-8 bg-red-600 border-2 w-min text-white">
                    Late
                </p>
                <p v-else-if="payment[0]==1" class="py-2 px-5 bg-gray-600 border-2 w-min text-white">
                    Pending
                </p>
                <p v-else-if="payment[0]==2" class="py-2 px-6 bg-green-600 border-2 w-min text-white">
                    Accept
                </p>
                <p  v-else-if="payment[0]==3" class="py-2 px-4 bg-yellow-400 border-2 w-min text-white">
                    Canceled
                </p>
            </div>
            <div class="w-1/4 m-auto">
                <p>
                    {{ payment[1] }}
                </p>
            </div>
            <div class="w-1/4 m-auto">
                <p>
                    {{ payment[2] }}
                </p>
            </div>
            <div class="w-1/4">
                <button class="bg-blue-600 text-white p-2">
                    Details
                </button>
            </div>
        </div>
    </section>
</template>
