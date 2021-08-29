<template>
    <div class="fixed top-4 right-4 z-10">
        <transition
            enter-from-class="opacity-0"
            enter-active-class="duration-700 ease-in"
            enter-to-class="opacity-100"
            leave-from-class="opacity-100"
            leave-active-class="duration-700 ease-out"
            leave-to-class="opacity-0"
        >
            <div v-if="show">
                <div
                    v-if="$page.props.flash.success"
                    class="
                        mb-8
                        flex
                        items-center
                        justify-between
                        bg-green-500
                        rounded
                        max-w-lg
                    "
                >
                    <div class="flex items-center mr-4">
                        <svg
                            class="
                                ml-4
                                mr-4
                                flex-no-shrink
                                w-4
                                h-4
                                fill-current
                                text-white
                            "
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                        >
                            <polygon points="0 11 2 9 7 14 18 3 20 5 7 18" />
                        </svg>
                        <div class="py-4 text-white text-sm font-medium">
                            {{ $page.props.flash.success }}
                        </div>
                    </div>
                    <button
                        type="button"
                        class="group mr-2 p-2"
                        @click="show = false"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 text-white hover:text-green-700"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>
                <div
                    v-if="$page.props.flash.error"
                    class="
                        mb-8
                        flex
                        items-center
                        justify-between
                        bg-red-500
                        rounded
                        max-w-lg
                    "
                >
                    <div class="flex items-center mr-4">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="mx-4 flex-no-shrink h-6 w-6 text-white"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"
                            />
                        </svg>
                        <div class="py-4 text-white text-sm font-medium">
                            {{ $page.props.flash.error }}
                        </div>
                    </div>
                    <button
                        type="button"
                        class="group mr-2 p-2"
                        @click="show = false"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 text-white hover:text-red-700"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>
                <div
                    v-if="Object.keys($page.props.errors).length > 0"
                    class="
                        mb-8
                        flex
                        items-center
                        justify-between
                        bg-red-500
                        rounded
                        max-w-lg
                    "
                >
                    <div class="flex items-center mr-4">
                        <svg
                            class="
                                ml-4
                                mr-4
                                flex-no-shrink
                                w-4
                                h-4
                                fill-current
                                text-white
                            "
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                        >
                            <path
                                d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm1.41-1.41A8 8 0 1 0 15.66 4.34 8 8 0 0 0 4.34 15.66zm9.9-8.49L11.41 10l2.83 2.83-1.41 1.41L10 11.41l-2.83 2.83-1.41-1.41L8.59 10 5.76 7.17l1.41-1.41L10 8.59l2.83-2.83 1.41 1.41z"
                            />
                        </svg>
                        <div class="py-4 text-white text-sm font-medium">
                            <span
                                v-if="
                                    Object.keys($page.props.errors).length === 1
                                "
                                >There is one form error.</span
                            >
                            <span v-else
                                >There are
                                {{ Object.keys($page.props.errors).length }}
                                form errors.</span
                            >
                        </div>
                    </div>
                    <button
                        type="button"
                        class="group mr-2 p-2"
                        @click="show = false"
                    >
                        <svg
                            class="
                                block
                                w-2
                                h-2
                                fill-current
                                text-white
                                group-hover:text-red-900
                            "
                            xmlns="http://www.w3.org/2000/svg"
                            width="235.908"
                            height="235.908"
                            viewBox="278.046 126.846 235.908 235.908"
                        >
                            <path
                                d="M506.784 134.017c-9.56-9.56-25.06-9.56-34.62 0L396 210.18l-76.164-76.164c-9.56-9.56-25.06-9.56-34.62 0-9.56 9.56-9.56 25.06 0 34.62L361.38 244.8l-76.164 76.165c-9.56 9.56-9.56 25.06 0 34.62 9.56 9.56 25.06 9.56 34.62 0L396 279.42l76.164 76.165c9.56 9.56 25.06 9.56 34.62 0 9.56-9.56 9.56-25.06 0-34.62L430.62 244.8l76.164-76.163c9.56-9.56 9.56-25.06 0-34.62z"
                            />
                        </svg>
                    </button>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
export default {
    name: "UiFlash",

    props: {
        timeout: {
            type: Number,
            default: 7000,
        },
    },

    data() {
        return {
            show: false,
        };
    },

    watch: {
        "$page.props.flash": {
            handler() {
                this.show = true;
                if (this.timeout > 0) {
                    setTimeout(() => (this.show = false), this.timeout);
                }
            },
            deep: true,
        },
    },

    mounted() {
        console.log(this.$page.props);
        this.show =
            !!this.$page.props.flash.error || !!this.$page.props.flash.success;
    },
};
</script>
