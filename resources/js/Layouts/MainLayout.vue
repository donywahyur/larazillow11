<template>
    <header
        class="border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 w-full"
    >
        <div class="container mx-auto">
            <nav class="p-4 flex items-center justify-between">
                <div class="text-lg font-medium">
                    <Link :href="route('listing.index')">Listing</Link>
                </div>
                <div
                    class="text-xl text-indigo-600 dark:text-indigo-300 font-bold text-center"
                >
                    <Link :href="route('listing.index')">LaraZillow</Link>
                </div>
                <div class="flex items-center gap-4" v-if="user">
                    <Link :href="route('realtor.listing.index')" class="text-sm text-gray-400">{{ user.name }}</Link :href="route('realtor.listing.index')">
                    <Link :href="route('realtor.listing.create')" class="btn-primary">
                        + New Listing</Link
                    >
                    <Link :href="route('logout')" method="delete" as="button"
                        >Logout</Link
                    >
                </div>
                <div v-else class="flex items-center gap-2">
                    <Link :href="route('user-account.create')">Register</Link>
                    <Link :href="route('login')">Sign-In</Link>
                </div>
            </nav>
        </div>
    </header>
    <main class="container mx-auto p-4 w-full">
        <div
            v-if="flashSuccess"
            class="mb-4 border rounded-md shadow-sm border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-900 p-2"
        >
            {{ flashSuccess }}
        </div>
        <slot></slot>
    </main>
</template>
<style scope>
a {
    margin-right: 10px;
}
.success {
    background-color: green;
    color: white;
}
</style>
<script setup>
import { computed } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import { ref } from "vue";

const page = usePage();
const flashSuccess = computed(() => page.props.flash.success);

const user = computed(() => page.props.user);
</script>
