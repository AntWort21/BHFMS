<script setup>
defineProps({
    labelName: String,
})

</script>

<template>
<div class="flex flex-row my-2">
    <input
        @input="$emit('update:modelValue', $event.target.value)"
        type="checkbox"
        class="mr-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600"
        value="true"
    />
    <label class="block">{{ labelName }}</label>
</div>
    
</template>
