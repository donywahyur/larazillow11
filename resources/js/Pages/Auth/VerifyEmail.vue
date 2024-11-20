<template>
    Your need to be verified first to see the page.
    <div>
        <Link
            :href="route('verification.send')"
            as="button"
            method="post"
            class="text-indigo-600 dark:text-indigo-400"
        >
            Resend Verify Email
        </Link>
    </div>
</template>
<script setup>
import { Link } from "@inertiajs/vue3";
</script>
