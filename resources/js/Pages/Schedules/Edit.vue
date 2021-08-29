<template>
    <group-layout>
        <template #boxed>
            <div class="p-0 md:p-4">
                <ui-well class="mb-8">
                    <h2 class="text-xl">{{ schedule.name }}</h2>
                    <p
                        v-if="schedule.description"
                        class="text-sm text-gray-700"
                    >
                        {{ schedule.description }}
                    </p>
                </ui-well>

                <div
                    v-if="!schedule.events.length"
                    class="
                        mx-2
                        mb-8
                        p-4
                        bg-red-200
                        border border-red-800
                        rounded
                    "
                >
                    <p class="text-red-700">
                        This schedule has no events! Please create a few.
                    </p>
                </div>

                <div>
                    <ui-button
                        type="button"
                        text="Create Events"
                        button-style="secondary"
                        @click="createEventsPanelShow(!createEventsShow)"
                    />
                </div>
            </div>
        </template>
        <ui-panel
            :show="createEventsShow"
            :form="true"
            :clear="true"
            clear-text="Back"
            title="Create Events"
            save-text="Next"
            @update:show="createEventsPanelShow($event)"
            @close="closeCreateEventsPanel"
            @save="nextStep"
            @clearForm="previousStep"
        >
            <form>
                <ui-input
                    v-model.number="createEventsForm.event_quantity"
                    name="quantity"
                    type="number"
                    :step="1"
                    :required="true"
                    label="How many events are you creating?"
                    class="mb-4"
                    :min="1"
                    :disabled="isQuantitySelected"
                    :error-message="errorMessages.event_quantity"
                />
                <div v-if="isQuantitySelected">
                    <ui-input
                        name="date"
                        type="date"
                        :label="dateFieldLabel"
                        :error-message="errorMessages.date"
                        :disabled="!isDateStep"
                        class="mb-4"
                    />
                </div>
                <div v-if="isRepetitionStep"></div>
                <div v-if="isFinalStep">
                    <ui-input
                        v-model="createEventsForm.name"
                        name="name"
                        type="string"
                        label="Name"
                        :required="true"
                        :error-message="errorMessages.name"
                        class="mb-4"
                    />
                    <ui-text-area
                        v-model="createEventsForm.description"
                        name="description"
                        type="textarea"
                        label="Description"
                        :required="false"
                        :error-message="errorMessages.description"
                    />
                </div>
            </form>
        </ui-panel>
    </group-layout>
</template>

<script>
import GroupLayout from "@/Layouts/GroupLayout";
import UiWell from "@/UI/UIWell";
import UiButton from "@/UI/UIButton";
import UiInput from "@/UI/UIInput";
import UiPanel from "@/UI/UIPanel";
export default {
    name: "SchedulesEdit",

    components: { UiInput, UiButton, UiWell, UiPanel, GroupLayout },

    props: {
        schedule: {
            type: Object,
            default: () => {},
        },
    },

    data() {
        return {
            createEventsForm: {
                event_quantity: 0,
                name: "",
                description: "",
            },
            errorMessages: {},
            createEventsShow: false,
            step: 0,
        };
    },

    computed: {
        isQuantitySelected: function () {
            return this.step > 0;
        },
        isDateStep: function () {
            return this.step === 1;
        },
        isRepetitionStep: function () {
            return this.step === 2;
        },
        isFinalStep: function () {
            return this.step === 4;
        },
        dateFieldLabel: function () {
            return this.createEventsForm.event_quantity > 1
                ? "Start Date"
                : "Date";
        },
    },

    methods: {
        nextStep() {
            if (this.step === 0) {
                return this.handleFirstStep();
            }
        },
        previousStep() {
            if (this.step === 1) {
                this.decrement();
            }
        },
        increment() {
            ++this.step;
        },
        decrement() {
            --this.step;
        },
        handleFirstStep() {
            if (!this.updateQuantity()) {
                return;
            }
            // if (this.createEventsForm.event_quantity === 1) {
            //     this.step = 3;
            //     return;
            // }
            this.step = 1;
        },
        updateQuantity() {
            if (this.createEventsForm.event_quantity < 1) {
                this.errorMessages.event_quantity =
                    "Quantity must be greater than zero";
                return false;
            }
            this.errorMessages.event_quantity = null;
            this.increment();
            return true;
        },
        createEventsPanelShow(show) {
            this.createEventsShow = show;
        },
        closeCreateEventsPanel() {
            this.createEventsForm = {};
            this.errorMessage = {};
            this.quantitySelected = false;
        },
    },
};
</script>
