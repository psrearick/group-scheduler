<template>
    <fieldset>
        <legend class="text-base font-medium text-gray-900">
            {{ text }}
        </legend>
        <slot></slot>
    </fieldset>
</template>

<script>
export default {
    name: "UIInputSection",

    props: {
        text: {
            type: String,
            default: "",
        },
    },
};
</script>
