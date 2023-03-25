<script setup>
defineProps({
    payment: Array
})
</script>
<template>
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
</template>