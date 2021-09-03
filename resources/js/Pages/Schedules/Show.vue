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
                    <p class="text-red-700">This schedule has no events!</p>
                </div>

                <div>
                    <ui-button
                        type="button"
                        text="Create Events"
                        button-style="primary"
                        @click="createEventsPanelShow(!createEventsShow)"
                    />
                </div>
            </div>
        </template>
        <ui-panel
            :show="createEventsShow"
            :form="true"
            :clear="false"
            title="Create Events"
            save-text="Save"
            @update:show="createEventsPanelShow($event)"
            @close="closeCreateEventsPanel"
            @save="saveEvent"
        >
            <form>
                <ui-radio
                    v-model="recurringString"
                    name="recurring"
                    description="Will the event repeat?"
                    :options="recurringOptions"
                    color="primary"
                    class="mb-4"
                    :required="true"
                />
                <div v-if="recurringString">
                    <ui-input
                        v-model="createEventsForm.start_date"
                        name="date"
                        type="date"
                        :label="dateFieldLabel"
                        :error-message="errorMessages.start_date"
                        class="mb-4"
                        :required="true"
                    />
                    <ui-input
                        v-if="isRecurring"
                        v-model="createEventsForm.end_date"
                        name="end_date"
                        type="date"
                        label="End Date"
                        :error-message="errorMessages.end_date"
                        class="mb-4"
                    />
                    <ui-select-menu
                        v-if="isRecurring"
                        v-model:show="frequencyShow"
                        v-model:selected="createEventsForm.frequency"
                        label="Repeat Every"
                        name="frequency"
                        :options="frequencyOptions"
                        class="mb-4"
                    />
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
import UiRadio from "@/UI/UIRadio";
import UiTextArea from "@/UI/UITextArea";
import UiSelectMenu from "@/UI/UISelectMenu";
export default {
    name: "SchedulesShow",

    components: {
        UiSelectMenu,
        UiRadio,
        UiInput,
        UiButton,
        UiWell,
        UiPanel,
        UiTextArea,
        GroupLayout,
    },

    props: {
        schedule: {
            type: Object,
            default: () => {},
        },
        errors: {
            type: Object,
            default: () => {},
        },
    },

    data() {
        return {
            createEventsForm: {
                name: "",
                description: "",
                recurring: false,
                start_date: null,
                end_date: null,
                frequency: "",
                schedule_id: null,
            },
            errorMessages: {},
            createEventsShow: false,
            recurringOptions: [
                {
                    id: "recurring-recurring",
                    option_name: "recurring-recurring",
                    label: "Recurring Event",
                },
                {
                    id: "recurring-onetime",
                    option_name: "recurring-onetime",
                    label: "Single Event",
                },
            ],
            recurringString: "",
            frequencyOptions: [
                {
                    label: "Day",
                    id: "day",
                },
                {
                    label: "Week",
                    id: "week",
                },
                {
                    label: "Month",
                    id: "month",
                },
                {
                    label: "Year",
                    id: "year",
                },
            ],
            frequencyShow: false,
        };
    },

    computed: {
        dateFieldLabel: function () {
            return this.isRecurring ? "Start Date" : "Date";
        },
        isRecurring: function () {
            return this.recurringString === "recurring-recurring";
        },
    },

    watch: {
        errors: function (newVal) {
            this.errorMessages = newVal;
        },
    },

    methods: {
        createEventsPanelShow(show) {
            this.createEventsShow = show;
        },
        clearForm() {
            this.createEventsForm = {
                name: "",
                description: "",
                recurring: false,
                start_date: null,
                end_date: null,
                frequency: "",
                schedule_id: null,
            };
        },
        closeCreateEventsPanel() {
            this.clearForm();
            this.errorMessage = {};
        },
        saveEvent() {
            let self = this;
            this.createEventsForm.schedule_id = this.schedule.id;
            this.createEventsForm.recurring = this.isRecurring;
            this.$inertia.post(
                "/groups/" + this.schedule.group_id + "/events",
                this.createEventsForm,
                {
                    onSuccess: () => {
                        self.closeCreateEventsPanel();
                    },
                    only: ["schedule"],
                }
            );
        },
    },
};
</script>
