<script setup>
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import useVuelidate from "@vuelidate/core";
import { required, email, helpers } from "@vuelidate/validators";
import { useToast } from "vue-toastification";

import GuestLayout from "@/Layouts/GuestLayout.vue";
import Button from "@/Components/Button.vue";
import CheckboxInput from "@/Components/Input/CheckboxInput.vue";
import TextInput from "@/Components/Input/TextInput.vue";

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const rules = {
    email: {
        required: helpers.withMessage("This field is required", required),
        email: helpers.withMessage("Please enter a valid email address", email),
    },
    password: {
        required: helpers.withMessage("This field is required", required),
    },
};

const v$ = useVuelidate(rules, form);

const toast = useToast();

const submit = () => {
    form.post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <GuestLayout>
        <h1 class="text-center text-2xl font-medium font-title text-sky-600">
            Open Projects
        </h1>
        <h3 class="text-lg font-bold text-center text-slate-700 mb-6 mt-2">
            Login to your account
        </h3>

        <form @submit.prevent="submit">
            <TextInput
                type="email"
                label="Email"
                v-model="form.email"
                :validate="v$.email"
            />

            <TextInput
                type="password"
                label="Password"
                v-model="form.password"
                class="mt-4"
                :validate="v$.password"
            />

            <CheckboxInput
                label="Remember me"
                v-model:checked="form.remember"
                class="mt-4"
            />

            <Button
                label="Login to account"
                :disabled="!v$.$anyDirty || v$.$invalid || form.processing"
                :loading="form.processing"
                class="mt-6"
                fullWidth
            />
        </form>

        <Button
            label="Forgot password?"
            :href="route('password.request')"
            type="link"
            buttonStyle="black"
            class="mt-2"
            fullWidth
            linkStyle
        />

        <hr class="my-6" />

        <div class="flex items-center gap-4">
            <div class="flex-1">
                <p class="text-slate-600 text-sm tracking-wide text-right">
                    Don't have an account?
                </p>
            </div>
            <div class="flex-0">
                <Button
                    label="Sign up"
                    :href="route('register')"
                    buttonStyle="secondary"
                    type="link"
                    icon="arrow"
                    outline
                />
            </div>
        </div>
    </GuestLayout>
</template>
