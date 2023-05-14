<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import { ref, reactive } from "vue";
defineProps({
    currentID: Number,
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
            <div
                v-if="boarding.tenant_status == 'checkout'"
                class="w-4 mr-2 transform hover:scale-110"
            >
                <Link
                    href="/review/create"
                    :data="{ id: boarding.boarding_id }"
                >
                    <svg
                        fill="#4b5563"
                        height="15px"
                        width="15px"
                        version="1.1"
                        id="Layer_1"
                        xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink"
                        viewBox="0 0 512 512"
                        xml:space="preserve"
                        stroke="currentColor"
                        class="hover:fill-purple-500"
                    >
                        <path
                            d="M501.108,324.808c-18.078-22.785-51.248-26.095-73.455-7.46l-79.115,66.383h-37.109 c18.518-7.578,31.898-25.423,32.467-46.178c0.797-29.075-22.487-52.931-51.476-52.931H137.134v-15.706 c0-9.222-7.477-16.699-16.699-16.699H16.699C7.477,252.218,0,259.695,0,268.917v213.755c0,9.222,7.477,16.699,16.699,16.699 h103.737c9.222,0,16.699-7.477,16.699-16.699v-27.328l32.695,27.43c9.006,7.557,20.442,11.718,32.199,11.718h156.499 c11.758,0,23.194-4.162,32.201-11.719L493.3,396.711C514.768,378.695,518.272,346.441,501.108,324.808z M103.737,465.972H33.398 V285.615h70.339C103.737,296.354,103.737,458.287,103.737,465.972z M471.83,371.125l-102.571,86.063 c-3.002,2.519-6.814,3.906-10.734,3.906H202.027c-3.919,0-7.73-1.387-10.733-3.906l-54.161-45.44v-93.727h155.286 c10.134,0,18.373,8.324,18.092,18.619c-0.266,9.692-8.706,17.577-18.815,17.577c-7.262,0-59.115,0-65.689,0 c-9.222,0-16.699,7.477-16.699,16.699s7.477,16.699,16.699,16.699h29.59l25.868,21.703c6.005,5.037,13.628,7.813,21.467,7.813 h45.607c7.838,0,15.462-2.774,21.468-7.814l79.115-66.383c7.76-6.511,19.424-5.432,25.824,2.634 C480.972,353.162,479.575,364.628,471.83,371.125z"
                        ></path>
                        <path
                            d="M368.08,92.437l-67.065-9.744l-29.992-60.772c-6.113-12.386-23.833-12.393-29.949,0l-29.992,60.772l-67.065,9.744 c-13.669,1.987-19.151,18.836-9.255,28.483l48.528,47.306l-11.457,66.794c-2.336,13.613,11.995,24.034,24.229,17.604 l59.986-31.536l59.984,31.535c12.157,6.392,26.58-3.898,24.229-17.604l-11.457-66.794l48.529-47.305 C387.225,111.279,381.757,94.424,368.08,92.437z M301.626,207.317c-54.351-28.574-36.583-28.69-91.155,0 c10.384-60.549,15.947-43.691-28.169-86.694c60.547-8.798,46.15,2.338,73.747-53.579c27.188,55.09,12.78,44.721,73.745,53.579 C285.814,163.494,291.21,146.586,301.626,207.317z"
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
