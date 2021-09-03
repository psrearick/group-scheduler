<template>
    <Link :href="href">
        <application-mark h-val="h-16" w-val="w-16" />
    </Link>
</template>

<script>
import ApplicationMark from "@/Components/ApplicationMark";
import { Link } from "@inertiajs/inertia-vue3";

export default {
    name: "LinkLogoLarge",
    components: { ApplicationMark, Link },
    props: {
        href: {
            type: String,
            default: "/",
        },
    },
};
</script>
