<template>
    <form @submit.prevent="register">
        <div class="w-1/2 mx-auto">
            <div class="mt-4">
                <label class="label" for="name">Name</label>
                <input
                    type="text"
                    v-model="form.name"
                    class="input"
                    id="name"
                />
                <div class="input-error" v-if="form.errors.name">
                    {{ form.errors.name }}
                </div>
            </div>
            <div class="mt-4">
                <label class="label" for="email">Email</label>
                <input
                    type="text"
                    v-model="form.email"
                    class="input"
                    id="email"
                />
                <div class="input-error" v-if="form.errors.email">
                    {{ form.errors.email }}
                </div>
            </div>
            <div class="mt-4">
                <label class="label" for="password">Password</label>
                <input
                    type="password"
                    v-model="form.password"
                    class="input"
                    id="password"
                />
                <div class="input-error" v-if="form.errors.password">
                    {{ form.errors.password }}
                </div>
            </div>
            <div class="mt-4">
                <label class="label" for="password_confirmation"
                    >Password Confirmation</label
                >
                <input
                    type="password"
                    v-model="form.password_confirmation"
                    class="input"
                    id="password_confirmation"
                />
                <div
                    class="input-error"
                    v-if="form.errors.password_confirmation"
                >
                    {{ form.errors.password_confirmation }}
                </div>
            </div>
            <div class="mt-4">
                <button class="btn-primary w-full" type="submit">
                    Create Account
                </button>
                <div class="mt-2 text-center">
                    <Link :href="route('login')" class="text-sm text-gray-500"
                        >Already have an account? click here</Link
                    >
                </div>
            </div>
        </div>
    </form>
</template>
<script setup>
import { useForm, Link } from "@inertiajs/vue3";
const form = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
});

const register = () => {
    form.post(route("user-account.store"));
};
</script>
