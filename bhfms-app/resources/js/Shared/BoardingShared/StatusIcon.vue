<script setup>
defineProps({
    boarding: Object,
});
</script>

<template>
    <td class="py-3 px-6 text-left">
        <span
            v-if="boarding.owner_status == 'approved'"
            class="bg-green-200 text-green-600 py-1 px-3 rounded-full text-xs"
        >
            Approved
        </span>

        <span
            v-else-if="boarding.owner_status == 'pending'"
            class="bg-yellow-200 text-yellow-600 py-1 px-3 rounded-full text-xs"
            >Pending</span
        >

        <span
            v-else-if="boarding.owner_status == 'declined'"
            class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs"
            >Declined</span
        >

        <span
            v-else
            class="bg-slate-200 text-slate-600 py-1 px-3 rounded-full text-xs"
            >Banned</span
        >
    </td>
</template>
