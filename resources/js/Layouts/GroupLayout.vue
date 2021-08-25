<template>
    <app-layout :title="title">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $page.props.group ? $page.props.group.name : "" }}
            </h2>
        </template>

        <div v-if="$slots.boxed" class="py-12">
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
                    <slot name="boxed"></slot>
                </div>
            </div>
        </div>
        <div v-if="$slots.wide">
            <slot name="wide"></slot>
        </div>
        <slot></slot>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import JetNavLink from "@/Jetstream/NavLink.vue";

export default {
    name: "GroupLayout",

    components: {
        AppLayout,
        JetNavLink,
    },
};
</script>
