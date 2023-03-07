<script setup>
import { Link } from '@inertiajs/inertia-vue3';

</script>

<template>
    <section class="p-6 bg-indigo-900 flex justify-between mt-auto text-white">
        <div class="ml-10">
            <p class="font-bold text-2xl">
                Footer
            </p>
            <p class="text-sm w-1/3">
                Lorem Ipsum Dolor sit amet, consectetur adispiscing elit
                te Lorem Ipsum Dolor sit amet, consectetur adispiscing elit
                te Lorem Ipsum Dolor sit amet, consectetur adispiscing elit
                te Lorem Ipsum Dolor sit amet, consectetur adispiscing elit
                te Lorem Ipsum Dolor sit amet, consectetur adispiscing elit
                te
            </p>
        </div>
        <div class="mr-36 w-1/6">
            <p class="font-bold text-2xl">
                Page Link
            </p>
            <ul class="mt-6 space-y-3">
                <li>
                    <Link href="/">Homepage</Link>
                </li>
                <li>
                    <Link href="/">Boarding House List</Link>
                </li>
                <li>
                    <Link href="/">Complains</Link>
                </li>
                <li>
                    <Link href="/">Payment List</Link>
                </li>
            </ul>
        </div>
    </section>
    <section class="bg-gray-200 text-center">
        &copy 2023 BHFMS
    </section>
</template>
