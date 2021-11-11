<template>
    <icon
        icon="logo"
        :view-box="viewBox"
        :h-val="hVal"
        :w-val="wVal"
        :color="iconColor"
        :stroke="stroke"
        @mouseenter="enterColor"
        @mouseleave="leaveColor"
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
        hoverColor: {
            type: String,
            default: "text-gray-400",
        },
        stroke: {
            type: String,
            default: "currentColor",
        },
    },
    data() {
        return {
            iconColor: "",
        };
    },
    mounted() {
        this.iconColor = this.color;
    },
    methods: {
        enterColor() {
            this.iconColor = this.hoverColor;
        },
        leaveColor() {
            this.iconColor = this.color;
        },
    },
};
</script>
