<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $page.props.group ? $page.props.group.name : "Dashboard" }}
            </h2>
        </template>

        <div v-if="$page.props.group">
            <show-group />
        </div>

        <div v-else class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="
                        bg-white
                        overflow-hidden
                        shadow-xl
                        sm:rounded-lg
                        min-h-screen
                    "
                >
                    <div class="flex justify-between">
                        <div>
                            <div>
                                <button @click="createGroup">
                                    Create Group
                                </button>
                            </div>
                            <div>
                                <button @click="joinGroup">Join Group</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Jetstream/Welcome.vue";
import ShowGroup from "@/Pages/Groups/Show";

export default {
    components: {
        ShowGroup,
        AppLayout,
        Welcome,
    },

    methods: {
        createGroup: function () {
            this.$inertia.get("/groups/create");
        },

        joinGroup: function () {
            this.$inertia.get("/groups/join");
        },

        enterGroup: function (id) {
            this.$inertia.get("/groups/" + id);
        },
    },
};
</script>
