<template>
    <svg
        xmlns="http://www.w3.org/2000/svg"
        :class="`${hVal} ${wVal} ${color}`"
        fill="none"
        :viewBox="viewBox"
        :stroke="stroke"
    >
        <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
        />
    </svg>
</template>

<script>
export default {
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
