<template>
    <div>
        {{ $page.props.group.name }}
    </div>
</template>

<script>
import AppLayout from "../../Layouts/AppLayout";

export default {
    name: "ShowGroup",

    components: {AppLayout},

    props: {
        group: {
            type: Object,
            default: () => {},
        },
    },
}
</script>

