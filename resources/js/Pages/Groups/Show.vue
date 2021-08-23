<template>
    <group-layout>
        <template #boxed>
            <div>
                {{ $page.props.group.name }}
            </div>
        </template>
    </group-layout>
</template>

<script>
import GroupLayout from "@/Layouts/GroupLayout";

export default {
    name: "ShowGroup",

    components: {GroupLayout},

    props: {
        group: {
            type: Object,
            default: () => {},
        },
    },
}
</script>

