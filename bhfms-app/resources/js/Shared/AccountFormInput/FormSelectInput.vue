<script setup>
defineProps({
    labelName: String,
    optionList: Array,
});
</script>

<template>
    <label class="block">{{ labelName }}</label>
    <select
        @input="$emit('update:modelValue', $event.target.value)"
        :placeholder="labelName"
        class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600"
    >
        <option value="" disabled selected>Select your {{ labelName }}</option>
        <option v-for="option in optionList" :value="option">{{ option }}</option>
    </select>
</template>
