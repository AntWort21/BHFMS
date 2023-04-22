<script setup>
import { Link } from "@inertiajs/inertia-vue3";
defineProps({
    currentID: Number,
    boarding: Object,
});
</script>

<template>
    <td class="py-3 px-6 text-center">
        <div class="flex item-center justify-center">
            <!-- See details (Admin, Owner, Manager) -->
            <div
                class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110"
            >
                <Link :href="''">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                        />
                    </svg>
                </Link>
            </div>

            <!-- Edit (Admin, Owner) -->
            <div
                v-if="
                    $page.props.user.role_id == 1 ||
                    $page.props.user.role_id == 3
                "
                class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110"
            >
                <Link :href="`/boarding/update/${currentID}`">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
                        />
                    </svg>
                </Link>
            </div>

            <!-- Delete (Admin, Owner) -->
            <div
                v-if="
                    $page.props.user.role_id == 1 ||
                    $page.props.user.role_id == 3
                "
                class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110"
            >
                <Link :href="''">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                        />
                    </svg>
                </Link>
            </div>

            <!-- Accept/ Decline (Admin Only) -->
            <div
                v-if="
                    boarding.status == 'pending' &&
                    $page.props.user.role_id == 1
                "
                class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110"
            >
                <Link :href="''">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"
                        ></path>
                        <circle cx="8.5" cy="7" r="4"></circle>
                        <polyline points="17 11 19 13 23 9"></polyline>
                    </svg>
                </Link>
            </div>

            <!-- Reapprove (Owner Only) -->
            <div
                v-if="
                    boarding.status == 'declined' &&
                    $page.props.user.role_id == 3
                "
                class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110 mt-0.5"
            >
                <Link :href="''">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2.5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        width="13"
                        height="13"
                    >
                        <path d="M2.5 2v6h6M21.5 22v-6h-6" />
                        <path
                            d="M22 11.5A10 10 0 0 0 3.2 7.2M2 12.5a10 10 0 0 0 18.8 4.2"
                        />
                    </svg>
                </Link>
            </div>
        </div>
    </td>
</template>
