<template>
    <div>
        <div>
            <ui-input-label
                v-if="description.length"
                :name="name"
                :label="description"
                :required="required"
            />
        </div>
        <div v-if="errorMessage">
                <span class="text-red-500 text-xs">
                    {{ errorMessage }}
                </span>
        </div>
        <div class="mt-4 space-y-4">
            <div v-for="(option, index) in options" class="flex items-center">
                <input
                    :id="option.id"
                    v-model="modelValue"
                    :name="name"
                    :value="option.id"
                    type="radio"
                    :class="inputClass"
                    @change="$emit('update:modelValue', $event.target.value)"
                />
                <label
                    :for="option.option_name"
                    class="ml-3 block text-sm font-medium text-gray-700"
                >
                    {{ option.label }}
                </label>
            </div>
        </div>
    </div>
</template>

<script>
import UiInputLabel from "@/UI/UIInputLabel";
export default {
    name: "UiRadio",
    components: { UiInputLabel },
    props: {
        options: {
            type: Array,
            default: () => {},
        },
        legendText: {
            type: String,
            default: "",
        },
        description: {
            type: String,
            default: "",
        },
        name: {
            type: String,
            default: "",
        },
        color: {
            type: String,
            default: "primary",
        },
        disabled: {
            type: Boolean,
            default: false,
        },
        modelValue: {
            type: String,
            default: "",
        },
        required: {
            type: Boolean,
            default: false,
        },
        errorMessage: {
            type: String,
            default: "",
        },
    },

    computed: {
        focusRing: function () {
            return `focus:ring-${this.color}-500`;
        },
        textColor: function () {
            return `text-${this.color}-500`;
        },
        inputClass: function () {
            return (
                this.focusRing + " h-4 w-4 border-gray-300 " + this.textColor
            );
        },
    },

    methods: {
        selectOption($event) {},
    },
};
</script>
