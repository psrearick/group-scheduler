<template>
    <Head title="Secure Area" />

    <card-centered title="Confirm Password">
        <template #logo>
            <link-logo-large />
        </template>

        <div class="mb-4 text-sm text-gray-600">
            This is a secure area of the application. Please confirm your
            password before continuing.
        </div>

        <validation-errors class="mb-4" />

        <form @submit.prevent="submit">
            <div>
                <jet-label for="password" value="Password" />
                <jet-input
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full"
                    required
                    autocomplete="current-password"
                    autofocus
                />
            </div>

            <div class="flex justify-end mt-4">
                <jet-button
                    class="ml-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Confirm
                </jet-button>
            </div>
        </form>
    </card-centered>
</template>

<script>
import { Head } from "@inertiajs/inertia-vue3";
import JetButton from "@/Jetstream/Button.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import LinkLogoLarge from "@/Components/LinkLogoLarge";
import CardCentered from "@/Components/CardCentered";
import ValidationErrors from "@/Components/ValidationErrors";

export default {
    components: {
        ValidationErrors,
        CardCentered,
        LinkLogoLarge,
        Head,
        JetButton,
        JetInput,
        JetLabel,
    },

    data() {
        return {
            form: this.$inertia.form({
                password: "",
            }),
        };
    },

    methods: {
        submit() {
            this.form.post(this.route("password.confirm"), {
                onFinish: () => this.form.reset(),
            });
        },
    },
};
</script>
