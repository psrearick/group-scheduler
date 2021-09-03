<template>
    <Link :href="href">
        <application-mark h-val="h-9" w-val="w-9" view-box="0 0 24 24" />
    </Link>
</template>

<script>
import ApplicationMark from "@/Components/ApplicationMark";
import { Link } from "@inertiajs/inertia-vue3";

export default {
    name: "LinkLogo",
    components: { ApplicationMark, Link },
    props: {
        href: {
            type: String,
            default: "/",
        },
    },
};
</script>
