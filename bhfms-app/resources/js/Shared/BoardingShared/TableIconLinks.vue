<script setup>
import { Link } from "@inertiajs/inertia-vue3";
defineProps({
    currentID: Number,
    boarding: Object,
});

const deleteBoarding = (idx) => {
    $inertia.put(`/boarding/delete/${idx}`);
};
</script>

<template>
    <td class="py-3 px-6 text-center">
        <div class="flex item-center justify-center">
            <!-- See details (Admin, Owner, Manager) -->

            <div
                class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110"
            >
                <Link :href="`/boarding/read/${currentID}`">
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

            <!-- Admin Tab -->
            <div v-if="$page.props.user.role_id == 1" class="flex">
                <!-- Edit -->
                <div
                    v-if="boarding.owner_status != 'banned'"
                    class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110"
                >
                    <Link :href="`boarding/update/${currentID}`">
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

                <!-- Accept or Decline Req -->
                <div
                    v-if="boarding.owner_status == 'pending'"
                    class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110"
                >
                    <Link :href="''">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="16"
                            height="16"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                    </Link>
                </div>

                <!-- Delete -->
                <div
                    v-if="boarding.owner_status != 'banned'"
                    class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110"
                >
                    <Link :href="`boarding/delete/${currentID}`">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="16"
                            height="16"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="15" y1="9" x2="9" y2="15"></line>
                            <line x1="9" y1="9" x2="15" y2="15"></line>
                        </svg>
                    </Link>
                </div>
            </div>

            <!-- Owner Tab -->
            <div v-if="$page.props.user.role_id == 3" class="flex">
                <!-- Edit -->
                <div
                    v-if="boarding.owner_status != 'banned'"
                    class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110"
                >
                    <Link :href="`boarding/update/${currentID}`">
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

                <!-- Delete -->
                <div
                    v-if="boarding.owner_status != 'banned'"
                    class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110"
                >
                    <Link :href="`boarding/delete/${currentID}`">
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

                <!-- Reapprove (Owner Only) -->
                <div
                    v-if="boarding.owner_status == 'declined'"
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

            <!-- Manager Tab -->
            <div v-if="$page.props.user.role_id == 4"></div>
        </div>
    </td>
</template>
