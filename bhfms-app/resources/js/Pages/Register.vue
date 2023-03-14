<script setup>
import Header from "../Shared/Header.vue";
import Footer from "../Shared/Footer.vue";
import { useForm } from "@inertiajs/inertia-vue3";

let form = useForm({
    firstName: "",
    lastName: "",
    gender: "",
    dateOfBirth: "",
    email: "",
    password: "",
    confirmPassword: "",
});

let submit = () => {
    form.post("/users");
};
</script>

<template>
    <Header />
    <div
        class="flex items-center justify-center bg-cover min-h-screen overflow-hidden"
        style="background-image: url('../storage/sofa.png')"
    >
        <div class="px-8 py-6 mt-4 text-left shadow-lg my-10 bg-white">
            <h3 class="text-2xl font-bold text-center">Welcome to BHFMS</h3>
            <form @submit.prevent="submit">
                <div class="mt-4">
                    <div class="flex flex-column">
                        <div class="mx-2">
                            <label class="block" for="email">First Name</label>
                            <input
                                v-model="form.firstName"
                                type="text"
                                placeholder="First Name"
                                class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600"
                            />
                            <!-- <div
                                v-if="form.errors.firstName"
                                v-text="form.errors.firstName"
                                class="text-red-500 text-xs mt-1"
                            /> -->
                        </div>
                        <div class="mx-2">
                            <label class="block">Last Name</label>
                            <input
                                v-model="form.lastName"
                                type="text"
                                placeholder="Last Name"
                                class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600"
                            />
                        </div>
                        <!-- <div
                            v-if="form.errors.lastName"
                            v-text="form.errors.lastName"
                            class="text-red-500 text-xs mt-1"
                        /> -->
                    </div>
                    <div class="mt-4 mx-2">
                        <label class="block">Gender</label>
                        <input
                            v-model="form.gender"
                            type="text"
                            placeholder="Gender"
                            class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600"
                        />
                        <!-- <div
                            v-if="form.errors.gender"
                            v-text="form.errors.gender"
                            class="text-red-500 text-xs mt-1"
                        /> -->
                    </div>
                    <div class="mt-4 mx-2">
                        <label class="block">Date of Birth</label>
                        <input
                            v-model="form.dateOfBirth"
                            type="date"
                            placeholder="Date of Birth"
                            class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600"
                        />
                        <!-- <div
                            v-if="form.errors.dateOfBirth"
                            v-text="form.errors.dateOfBirth"
                            class="text-red-500 text-xs mt-1"
                        /> -->
                    </div>
                    <div class="mt-4 mx-2">
                        <label class="block">Email</label>
                        <input
                            v-model="form.email"
                            type="email"
                            placeholder="Email"
                            class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600"
                        />
                    </div>
                    <div class="mt-4 mx-2">
                        <label class="block">Password</label>
                        <input
                            v-model="form.password"
                            type="password"
                            placeholder="Password"
                            class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600"
                        />
                        <!-- <div
                            v-if="form.errors.password"
                            v-text="form.errors.password"
                            class="text-red-500 text-xs mt-1"
                        /> -->
                    </div>
                    <div class="mt-4 mx-2">
                        <label class="block">Confirm Password</label>
                        <input
                            v-model="form.confirmPassword"
                            type="password"
                            placeholder="Confirm Password"
                            class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600"
                        />
                        <!-- <div
                            v-if="form.errors.confirmPassword"
                            v-text="form.errors.confirmPassword"
                            class="text-red-500 text-xs mt-1"
                        /> -->
                    </div>
                    <div
                        class="flex items-baseline justify-betweens space-x-6 mt-4"
                    >
                        <button
                            class="px-6 py-2 mt-4 text-white bg-blue-600 rounded-lg hover:bg-blue-900"
                        >
                            Register
                        </button>
                        <a
                            href="#"
                            class="text-xs text-blue-600 hover:underline"
                            >Already Have an Account? Login</a
                        >
                    </div>
                </div>
            </form>
        </div>
    </div>
    <Footer />
</template>
