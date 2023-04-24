<script setup>
defineProps({
    paymentMethod: String,
});
</script>
<template>
    <div v-if="paymentMethod=='BCA'">
        <p>1. Please add this account 47192012 to destination bank account</p>
        <p>2. Confirm the name BHFMS PT</p>
        <p>3. Please transfer the amount, and make sure the last 3 digit is correct</p>
        <p>4. Please upload the proof of payment</p>
    </div>
</template>