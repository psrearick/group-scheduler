<template>
    <Head title="Log in" />

    <card-centered title="Login">
        <template #logo>
            <link-logo-large />
        </template>

        <validation-errors class="mb-4" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

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

            <div class="mt-4">
                <ui-input
                    v-model="form.password"
                    name="password"
                    type="password"
                    label="Password"
                    :required="true"
                />
            </div>

            <div class="block mt-4">
                <ui-checkbox
                    v-model:checked="form.remember"
                    name="remember"
                    label="Remember me"
                />
            </div>

            <div class="flex items-center justify-between mt-4">
                <div>
                    <Link
                        :href="route('register')"
                        class="
                            mt-6
                            block
                            underline
                            text-sm text-gray-600
                            hover:text-gray-900
                        "
                    >
                        Not registered?
                    </Link>
                    <Link
                        v-if="canResetPassword"
                        :href="route('password.request')"
                        class="
                            mt-2
                            block
                            underline
                            text-sm text-gray-600
                            hover:text-gray-900
                        "
                    >
                        Forgot your password?
                    </Link>
                </div>
                <ui-button
                    type="submit"
                    button-style="primary"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Log in
                </ui-button>
            </div>
        </form>
    </card-centered>
</template>

<script>
import JetLabel from "@/Jetstream/Label.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import LinkLogoLarge from "@/Components/LinkLogoLarge";
import CardCentered from "@/Components/CardCentered";
import ValidationErrors from "@/Components/ValidationErrors";
import UiButton from "@/UI/UIButton";
import UiInput from "@/UI/UIInput";
import UiCheckbox from "@/UI/UICheckbox";

export default {
    components: {
        UiCheckbox,
        UiInput,
        UiButton,
        ValidationErrors,
        CardCentered,
        LinkLogoLarge,
        Head,
        JetLabel,
        Link,
    },

    props: {
        canResetPassword: Boolean,
        status: {
            type: String,
            default: "",
        },
    },

    data() {
        return {
            form: this.$inertia.form({
                email: "",
                password: "",
                remember: false,
            }),
        };
    },

    methods: {
        submit() {
            this.form
                .transform((data) => ({
                    ...data,
                    remember: this.form.remember ? "on" : "",
                }))
                .post(this.route("login"), {
                    onFinish: () => this.form.reset("password"),
                });
        },
    },
};
</script>
