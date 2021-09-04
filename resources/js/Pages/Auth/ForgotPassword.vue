<template>
    <Head title="Forgot Password" />

    <card-centered title="Forgot Password">
        <template #logo>
            <link-logo-large />
        </template>

        <div class="mb-4 text-sm text-gray-600">
            Forgot your password? No problem. Just let us know your email
            address and we will email you a password reset link that will allow
            you to choose a new one.
        </div>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <validation-errors class="mb-4" />

        <form @submit.prevent="submit">
            <div>
                <ui-input
                    v-model="form.email"
                    name="email"
                    label="Email"
                    type="email"
                    :required="true"
                    :autofocus="true"
                />
            </div>

            <div class="flex items-center justify-between mt-4">
                <Link :href="route('login')"
                    ><ui-button button-style="danger">Cancel</ui-button></Link
                >
                <ui-button
                    type="submit"
                    button-style="primary"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Email Password Reset Link
                </ui-button>
            </div>
        </form>
    </card-centered>
</template>

<script>
import { Head, Link } from "@inertiajs/inertia-vue3";
import LinkLogoLarge from "@/Components/LinkLogoLarge";
import CardCentered from "@/Components/CardCentered";
import ValidationErrors from "@/Components/ValidationErrors";
import UiButton from "@/UI/UIButton";
import UiInput from "@/UI/UIInput";

export default {
    components: {
        UiInput,
        UiButton,
        ValidationErrors,
        CardCentered,
        LinkLogoLarge,
        Head,
        Link,
    },

    props: {
        status: String,
    },

    data() {
        return {
            form: this.$inertia.form({
                email: "",
            }),
        };
    },

    methods: {
        submit() {
            this.form.post(this.route("password.email"));
        },
    },
};
</script>
