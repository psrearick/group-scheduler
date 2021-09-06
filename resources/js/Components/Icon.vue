<template>
    <div>
        <svg
            v-if="icon === 'search'"
            :class="iconClass"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            :viewBox="viewBox"
            :stroke="stroke"
        >
            <path
                fill-rule="evenodd"
                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                clip-rule="evenodd"
            />
        </svg>
        <svg
            v-if="icon === 'outline-menu'"
            :class="iconClass"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            :viewBox="viewBox"
            :stroke="stroke"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16"
            />
        </svg>
        <svg
            v-if="icon === 'outline-x'"
            :class="iconClass"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            :viewBox="viewBox"
            :stroke="stroke"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M6 18L18 6M6 6l12 12"
            />
        </svg>
        <svg
            v-if="icon === 'outline-bell'"
            :class="iconClass"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            :viewBox="viewBox"
            :stroke="stroke"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
            />
        </svg>
        <svg
            v-if="icon === 'chevron-right'"
            :class="iconClass"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            :viewBox="viewBox"
            :stroke="stroke"
        >
            <path
                fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd"
            />
        </svg>
        <svg
            v-if="icon === 'chevron-left'"
            :class="iconClass"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            :viewBox="viewBox"
            :stroke="stroke"
        >
            <path
                fill-rule="evenodd"
                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                clip-rule="evenodd"
            />
        </svg>
        <svg
            v-if="icon === 'selector'"
            :class="iconClass"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            :viewBox="viewBox"
            :stroke="stroke"
        >
            <path
                fill-rule="evenodd"
                d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                clip-rule="evenodd"
            />
        </svg>
        <svg
            v-if="icon === 'check'"
            :class="iconClass"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            :viewBox="viewBox"
            :stroke="stroke"
        >
            <path
                fill-rule="evenodd"
                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                clip-rule="evenodd"
            />
        </svg>
        <svg
            v-if="icon === 'exclamation'"
            :class="iconClass"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            :viewBox="viewBox"
            :stroke="stroke"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
            />
        </svg>
        <svg
            v-if="icon === 'logo'"
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
    </div>
</template>

<script>
export default {
    name: "Icon",

    props: {
        classes: {
            type: String,
            default: "",
        },
        color: {
            type: String,
            default: "text-primary-500",
        },
        hVal: {
            type: String,
            default: "h-6",
        },
        icon: {
            type: String,
            default: "",
        },
        stroke: {
            type: String,
            default: "currentColor",
        },
        viewBox: {
            type: String,
            default: "0 0 24 24",
        },
        wVal: {
            type: String,
            default: "w-6",
        },
    },

    computed: {
        iconClass: function () {
            return `${this.hVal} ${this.wVal} ${this.color} ${this.classes}`;
        },
    },
};
</script>
