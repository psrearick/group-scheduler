<template>
    <div>
        <div
            v-if="show"
            class="fixed w-full h-full z-40"
            @click="$emit('close')"
        ></div>
        <div class="z-50">
            <label
                id="listbox-label"
                class="block text-sm font-medium text-gray-700"
            >
                {{ label }}
            </label>
            <div class="mt-1 relative">
                <button
                    type="button"
                    class="
                        bg-white
                        relative
                        w-full
                        border border-gray-300
                        rounded-md
                        shadow-sm
                        pl-3
                        pr-10
                        py-2
                        text-left
                        cursor-default
                        focus:outline-none
                        focus:ring-1
                        focus:ring-indigo-500
                        focus:border-indigo-500
                        sm:text-sm
                    "
                    aria-haspopup="listbox"
                    aria-expanded="true"
                    aria-labelledby="listbox-label"
                >
                    <span class="block truncate">
                        {{ selected.label }}
                    </span>
                    <span
                        class="
                            absolute
                            inset-y-0
                            right-0
                            flex
                            items-center
                            pr-2
                            pointer-events-none
                        "
                    >
                        <svg
                            class="h-5 w-5 text-gray-400"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                            aria-hidden="true"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </span>
                </button>

                <transition
                    leave-active-class="transition ease-in duration-100"
                    leave-from-class="opacity-100"
                    leave-to-class="opacity-0"
                >
                    <ul
                        v-show="show"
                        class="
                            absolute
                            z-10
                            mt-1
                            w-full
                            bg-white
                            shadow-lg
                            max-h-60
                            rounded-md
                            py-1
                            text-base
                            ring-1 ring-black ring-opacity-5
                            overflow-auto
                            focus:outline-none
                            sm:text-sm
                        "
                        tabindex="-1"
                        role="listbox"
                        aria-labelledby="listbox-label"
                    >
                        <li
                            v-for="(option, index) in options"
                            :id="name + '-' + index"
                            :key="index"
                            :class="liClass(index)"
                            role="option"
                            @mouseenter="mouseOn(option)"
                            @mouseleave="mouseOff(option)"
                        >
                            <span
                                :class="
                                    (isSelected(option)
                                        ? 'font-semibold'
                                        : 'font-normal') + ' block truncate'
                                "
                            >
                                {{ option.label }}
                            </span>
                            <span
                                v-if="isSelected(option)"
                                :class="checkmarkClass(index)"
                            >
                                <svg
                                    class="h-5 w-5"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                    aria-hidden="true"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </span>
                        </li>
                    </ul>
                </transition>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "UiSelectMenu",

    props: {
        label: {
            type: String,
            default: "",
        },
        name: {
            type: String,
            default: "",
        },
        options: {
            type: Array,
            default: () => {},
        },
        show: {
            type: Boolean,
            default: false,
        },
        selected: {
            type: Object,
            default: () => {},
        },
    },

    data() {
        return {
            mouse: null,
        };
    },

    methods: {
        isSelected(option) {
            return selected.id === option.id;
        },
        mouseOn(index) {
            this.mouse = index;
        },
        mouseOff(option) {
            this.mouse = null;
        },
        liClass(index) {
            return (
                (this.mouse === index
                    ? "text-white bg-indigo-600"
                    : "text-gray-900") +
                " cursor-default select-none relative py-2 pl-3 pr-9"
            );
        },
        checkmarkClass(index) {
            return (
                (this.mouse === index ? "text-indigo-600" : "text-white") +
                " absolute inset-y-0 right-0 flex items-center pr-4"
            );
        },
    },
};
</script>
