<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import { ref, reactive } from "vue";
defineProps({
    currentID: Number,
    endDate: Date,
    tenantID: Number,
    boarding: Object,
});

let mouseover = ref(false);
let popup = reactive({
    show: false,
    boarding_id: 0,
    boarding_name: "",
});

let enableDisablePopup = (id, name) => {
    popup.show = !popup.show;
    popup.boarding_id = id;
    popup.boarding_name = name;
};

const deleteBoarding = (idx) => {
    Inertia.post(`/boarding/delete/${idx}`);
};
</script>

<template>
    <td class="py-3 px-6 text-center">
        <div class="flex item-center justify-center">
            <!-- See details (Admin, Owner, Manager) -->
            <div
                v-if="$page.props.user.role_id != 2"
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
                    <Link :href="`/boardingAdmin/request/${currentID}`">
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
                    @mouseover="mouseover = true"
                    @mouseleave="mouseover = false"
                    @click="
                        enableDisablePopup(
                            boarding.boarding_id,
                            boarding.boarding_name
                        )
                    "
                    class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110"
                >
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
                </div>
            </div>

            <!-- Owner Tab -->
            <div v-if="$page.props.user.role_id == 3" class="flex">
                <!-- Edit -->
                <div
                    v-if="boarding.owner_status == 'approved'"
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

                <!-- Reapprove (Owner Only) -->
                <div
                    v-if="boarding.owner_status == 'declined'"
                    class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110 mt-0.5"
                >
                    <Link :href="`/boarding/reapprove/${currentID}`">
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

                <!-- Disable Boarding (Owner Only) -->
                <div
                    v-if="boarding.owner_status == 'approved'"
                    class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110 mt-0.5"
                >
                    <Link :href="`/boarding/disable/${currentID}`">
                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g
                                id="SVGRepo_tracerCarrier"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            ></g>
                            <g id="SVGRepo_iconCarrier">
                                <g id="Navigation / House_Close">
                                    <path
                                        id="Vector"
                                        d="M10 15L12 13.0001M12 13.0001L14 11.0001M12 13.0001L10 11.0001M12 13.0001L14 15M4 16.8002V11.4522C4 10.9179 4 10.6506 4.06497 10.4019C4.12255 10.1816 4.2173 9.97307 4.34521 9.78464C4.48955 9.57201 4.69064 9.39569 5.09277 9.04383L9.89436 4.84244C10.6398 4.19014 11.0126 3.86397 11.4324 3.73982C11.8026 3.63035 12.1972 3.63035 12.5674 3.73982C12.9875 3.86406 13.3608 4.19054 14.1074 4.84383L18.9074 9.04383C19.3096 9.39569 19.5102 9.57201 19.6546 9.78464C19.7825 9.97307 19.8775 10.1816 19.9351 10.4019C20 10.6505 20 10.9184 20 11.4522V16.8037C20 17.9216 20 18.4811 19.7822 18.9086C19.5905 19.2849 19.2842 19.5906 18.9079 19.7823C18.4805 20.0001 17.9215 20.0001 16.8036 20.0001H7.19691C6.07899 20.0001 5.5192 20.0001 5.0918 19.7823C4.71547 19.5906 4.40973 19.2849 4.21799 18.9086C4 18.4807 4 17.9203 4 16.8002Z"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    ></path>
                                </g>
                            </g>
                        </svg>
                    </Link>
                </div>

                <!-- Enable Boarding (Owner Only) -->
                <div
                    v-if="boarding.owner_status == 'disabled'"
                    class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110 mt-0.5"
                >
                    <Link :href="`/boarding/enable/${currentID}`">
                        <svg
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g
                                id="SVGRepo_tracerCarrier"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            ></g>
                            <g id="SVGRepo_iconCarrier">
                                <g id="Navigation / House_Check">
                                    <path
                                        id="Vector"
                                        d="M15 11.0001L11 15.0001L9 13.0001M4 16.8002V11.4522C4 10.9179 4 10.6506 4.06497 10.4019C4.12255 10.1816 4.21779 9.97307 4.3457 9.78464C4.49004 9.57201 4.69064 9.39569 5.09277 9.04383L9.89436 4.84244C10.6398 4.19014 11.0126 3.86397 11.4324 3.73982C11.8026 3.63035 12.1972 3.63035 12.5674 3.73982C12.9875 3.86406 13.3608 4.19054 14.1074 4.84383L18.9074 9.04383C19.3096 9.39569 19.5102 9.57201 19.6546 9.78464C19.7825 9.97307 19.877 10.1816 19.9346 10.4019C19.9995 10.6506 20 10.9179 20 11.4522V16.8037C20 17.9216 20 18.4811 19.7822 18.9086C19.5905 19.2849 19.2837 19.5906 18.9074 19.7823C18.48 20.0001 17.921 20.0001 16.8031 20.0001H7.19691C6.07899 20.0001 5.5192 20.0001 5.0918 19.7823C4.71547 19.5906 4.40973 19.2849 4.21799 18.9086C4 18.4807 4 17.9203 4 16.8002Z"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    ></path>
                                </g>
                            </g>
                        </svg>
                    </Link>
                </div>
            </div>

            <!-- Tenant Tab -->
            <div v-if="$page.props.user.role_id == 2" class="flex">
                <div
                    class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110"
                >
                    <Link :href="`/boardingTenant/detail/${tenantID}`">
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
                <!-- Payment -->
                <div
                    v-if="boarding.tenant_status == 'approved'"
                    class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110"
                >
                    <Link :href="`#`">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <rect x="2" y="4" width="20" height="16" rx="2" />
                            <path d="M7 15h0M2 9.5h20" />
                        </svg>
                    </Link>
                </div>

                <!-- End Rent -->
                <div
                    v-if="
                        boarding.tenant_status == 'approved' &&
                        boarding.endDate == null
                    "
                    class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110"
                >
                    <Link :href="`/boarding/rent/end/${tenantID}`">
                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                            stroke="currentColor"
                        >
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g
                                id="SVGRepo_tracerCarrier"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            ></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M16.5 15V19.5H5.5V5.5H16.5V10M10 12.5H22.5"
                                    stroke="currentColor"
                                    stroke-width="2"
                                ></path>
                                <path
                                    d="M20 10L22.5 12.5L20 15"
                                    stroke="currentColor"
                                    stroke-width="2"
                                ></path>
                            </g>
                        </svg>
                    </Link>
                </div>
            </div>
        </div>
    </td>

    <div
        v-if="popup.show"
        class="fixed inset-0 grid place-items-center"
        style="background: rgba(0, 0, 0, 0.4)"
        @click="popup.show = false"
    >
        <div class="bg-white w-5/12 rounded">
            <header class="text-xl m-3">Confirmation</header>
            <div class="mx-3">Delete/Ban {{ popup.boarding_name }} ?</div>
            <button
                class="bg-blue-500 hover:bg-blue-600 rounded p-2 ml-3 my-3 text-white"
                type="button"
                @click="deleteBoarding(popup.boarding_id)"
            >
                Confirm
            </button>
            <button
                class="bg-red-500 hover:bg-red-600 rounded p-2 m-3 text-white"
                type="button"
                @click="popup.show = false"
            >
                Back
            </button>
        </div>
    </div>
</template>
