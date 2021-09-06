<template>
    <Head title="Register" />

    <card-centered title="Register">
        <template #logo>
            <link-logo-large />
        </template>

        <form @submit.prevent="submit">
            <ui-input
                v-model="form.name"
                class="mb-4"
                name="name"
                label="Name"
                :required="true"
                :autofocus="true"
                :error-message="$page.props.errors.name"
            />

            <ui-input
                v-model="form.email"
                class="mb-4"
                name="email"
                label="Email"
                type="email"
                :required="true"
                :error-message="$page.props.errors.email"
            />

            <ui-input
                v-model="form.password"
                class="mb-4"
                name="password"
                label="Password"
                type="password"
                :required="true"
                :error-message="$page.props.errors.password"
                autocomplete="new-password"
            />

            <ui-input
                v-model="form.password_confirmation"
                name="password_confirmation"
                type="password"
                label="Confirm Password"
                :required="true"
                :error-message="$page.props.errors.password_confirmation"
                autocomplete="new-password"
            />

            <div
                v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature"
                class="mt-4"
            >
                <div class="flex items-center">
                    <ui-checkbox v-model:checked="form.terms" name="terms">
                        <div class="ml-2">
                            I agree to the
                            <a
                                target="_blank"
                                :href="route('terms.show')"
                                class="
                                    underline
                                    text-sm text-gray-600
                                    hover:text-gray-900
                                "
                                >Terms of Service</a
                            >
                            and
                            <a
                                target="_blank"
                                :href="route('policy.show')"
                                class="
                                    underline
                                    text-sm text-gray-600
                                    hover:text-gray-900
                                "
                                >Privacy Policy</a
                            >
                        </div>
                    </ui-checkbox>
                </div>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                    :href="route('login')"
                    class="underline text-sm text-gray-600 hover:text-gray-900"
                >
                    Already registered?
                </Link>

                <ui-button
                    type="submit"
                    button-style="primary"
                    class="ml-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Register
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
import UiCheckbox from "@/UI/UICheckbox";
import UiButton from "@/UI/UIButton";
import UiInput from "@/UI/UIInput";

export default {
    components: {
        UiInput,
        UiButton,
        UiCheckbox,
        ValidationErrors,
        CardCentered,
        LinkLogoLarge,
        Head,
        Link,
    },

    data() {
        return {
            form: this.$inertia.form({
                name: "",
                email: "",
                password: "",
                password_confirmation: "",
                terms: false,
            }),
        };
    },

    methods: {
        submit() {
            this.form.post(this.route("register"), {
                onFinish: () =>
                    this.form.reset("password", "password_confirmation"),
            });
        },
    },
};
</script>
