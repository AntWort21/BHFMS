<script setup>
defineProps({
    labelName: String,
    optionList: Array,
    labelDesc: String,
    defaultText: String,
});

defineEmits(['update:modelValue'])
</script>

<template>
    <label class="block  mt-2">{{ labelName }}</label>
    <select
        @input="$emit('update:modelValue', $event.target.value)"
        :placeholder="labelName"
        class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600"
    >
    <option value="" disabled selected hidden>{{ defaultText }}</option>
        <option v-for="option in optionList" :value="option">{{ option }}</option>
    </select>
</template>
