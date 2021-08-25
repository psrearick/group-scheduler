<template>
    <app-layout title="Create Group">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Group
            </h2>
        </template>

        <page class="py-12">
            <div>
                <form class="w-1/2 ml-4" @submit.prevent="submit">
                    <div class="mb-4">
                        <jet-label for="name" value="Name" />
                        <jet-input
                            id="name"
                            v-model="form.name"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            autofocus
                            autocomplete="name"
                        />
                        <p v-if="errors.name" class="text-red-500">
                            {{ errors.name }}
                        </p>
                    </div>

                    <div class="flex justify-between">
                        <jet-button
                            type="submit"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                            @click.prevent="cancel"
                        >
                            Cancel
                        </jet-button>
                        <jet-button
                            type="submit"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            Create
                        </jet-button>
                    </div>
                </form>
            </div>
        </page>
    </app-layout>
</template>

<script>
import AppLayout from "../../Layouts/AppLayout";
import page from "../../Partials/__page";
import JetButton from "@/Jetstream/Button.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";

export default {
    name: "CreateGroup",

    components: { AppLayout, page, JetButton, JetLabel, JetInput },

    props: {
        errors: {
            type: Object,
            default: () => {},
        },
    },

    data() {
        return {
            form: this.$inertia.form({
                name: "",
            }),
        };
    },

    methods: {
        cancel: function () {
            this.$inertia.get("/dashboard");
        },
        submit: function () {
            this.form.post("/groups", {
                onSuccess: () => this.form.reset("name"),
            });
        },
    },
};
</script>
