<template>
    <icon
        icon="logo"
        :view-box="viewBox"
        :h-val="hVal"
        :w-val="wVal"
        :color="color"
        :stroke="stroke"
    />
</template>

<script>
import Icon from "@/Components/Icon";
export default {
    components: { Icon },
    props: {
        viewBox: {
            type: String,
            default: "0 0 24 24",
        },
        hVal: {
            type: String,
            default: "h-6",
        },
        wVal: {
            type: String,
            default: "w-6",
        },
        color: {
            type: String,
            default: "text-primary-500",
        },
        stroke: {
            type: String,
            default: "currentColor",
        },
    },
};
</script>
