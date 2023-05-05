<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import { ref, reactive } from "vue";
defineProps({
    currentID: Number,
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
            </div>

            <!-- Tenant Tab -->
            <div v-if="$page.props.user.role_id == 2" class="flex">
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

                <!-- Complain -->
                <div
                    v-if="boarding.tenant_status == 'approved'"
                    class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110"
                >
                    <Link :href="`#`">
                        <svg
                            viewBox="0 0 32 32"
                            id="svg5"
                            version="1.1"
                            xmlns="http://www.w3.org/2000/svg"
                            xmlns:svg="http://www.w3.org/2000/svg"
                            fill="#4b5563"
                            stroke="#4b5563"
                        >
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g
                                id="SVGRepo_tracerCarrier"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            ></g>
                            <g id="SVGRepo_iconCarrier">
                                <defs id="defs2"></defs>
                                <g id="layer1" transform="translate(-108,-388)">
                                    <path
                                        d="m 115,408.01367 c -2.7527,0 -5,2.2473 -5,5 0,2.7527 2.2473,5 5,5 h 14 c 2.7527,0 5,-2.2473 5,-5 0,-2.7527 -2.2473,-5 -5,-5 z m 0,2 h 14 c 1.6793,0 3,1.32071 3,3 0,1.6793 -1.3207,3 -3,3 h -14 c -1.6793,0 -3,-1.3207 -3,-3 0,-1.67929 1.3207,-3 3,-3 z"
                                        id="path453585"
                                        style="
                                            color: #4b5563;
                                            fill: #4b5563;
                                            fill-rule: evenodd;
                                            stroke-linecap: round;
                                            stroke-linejoin: round;
                                            stroke-miterlimit: 4.1;
                                            -inkscape-stroke: none;
                                        "
                                    ></path>
                                    <path
                                        d="m 131,399.01367 a 1,1 0 0 0 -1,1 1,1 0 0 0 1,1 1,1 0 0 0 1,-1 1,1 0 0 0 -1,-1 z"
                                        id="path453573"
                                        style="
                                            color: #4b5563;
                                            fill: #4b5563;
                                            fill-rule: evenodd;
                                            stroke-linecap: round;
                                            stroke-linejoin: round;
                                            stroke-miterlimit: 4.1;
                                            -inkscape-stroke: none;
                                        "
                                    ></path>
                                    <path
                                        d="m 131,393.01367 a 1,1 0 0 0 -1,1 v 3 a 1,1 0 0 0 1,1 1,1 0 0 0 1,-1 v -3 a 1,1 0 0 0 -1,-1 z"
                                        id="path453567"
                                        style="
                                            color: #4b5563;
                                            fill: #4b5563;
                                            fill-rule: evenodd;
                                            stroke-linecap: round;
                                            stroke-linejoin: round;
                                            stroke-miterlimit: 4.1;
                                            -inkscape-stroke: none;
                                        "
                                    ></path>
                                    <path
                                        d="m 131,390.01367 c -2.63036,0 -4.9293,1.46542 -6.125,3.6211 -0.90021,-0.4054 -1.87895,-0.62123 -2.875,-0.6211 -3.85415,0 -7,3.14586 -7,7 0,3.85415 3.14585,7 7,7 a 1.000105,1.000105 0 0 0 0.002,0 c 2.57139,-0.007 4.90293,-1.42397 6.11524,-3.625 0.88031,0.40064 1.85579,0.625 2.88281,0.625 3.85414,0 7,-3.14585 7,-7 0,-3.85413 -3.14586,-7 -7,-7 z m 0,2 c 2.77327,0 5,2.22674 5,5 0,2.77327 -2.22673,5 -5,5 -0.98421,0 -1.89849,-0.28178 -2.66992,-0.76758 a 1.000005,1.000005 0 0 0 -0.2461,-0.16601 C 126.82049,400.17503 126,398.69579 126,397.01367 c 0,-0.5237 0.081,-1.02855 0.22852,-1.50195 a 1.000005,1.000005 0 0 0 0.10546,-0.30078 c 0.71945,-1.87506 2.52941,-3.19727 4.66602,-3.19727 z m -9,3 c 0.75319,-10e-5 1.49281,0.17045 2.16602,0.49414 -0.10719,0.48532 -0.16602,0.98922 -0.16602,1.50586 0,2.1085 0.94381,4.00364 2.42773,5.28906 -0.84495,1.64398 -2.53896,2.70503 -4.42773,2.71094 -2.77326,0 -5,-2.22673 -5,-5 0,-2.77326 2.22674,-5 5,-5 z"
                                        id="path453555"
                                        style="
                                            color: #4b5563;
                                            fill: #4b5563;
                                            fill-rule: evenodd;
                                            stroke-linecap: round;
                                            stroke-linejoin: round;
                                            stroke-miterlimit: 4.1;
                                            -inkscape-stroke: none;
                                        "
                                    ></path>
                                </g>
                            </g>
                        </svg>
                    </Link>
                </div>
            </div>
            <!-- Chat -->
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
                        <path
                            d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"
                        ></path>
                    </svg>
                </Link>
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
