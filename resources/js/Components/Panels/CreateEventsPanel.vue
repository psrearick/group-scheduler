<template>
    <ui-panel
        :show="show"
        :form="true"
        :clear="false"
        title="Create Events"
        save-text="Save"
        :wide="true"
        @update:show="$emit('update:show', $event)"
        @close="close"
        @save="save"
    >
        <form>
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
                class="mb-4"
            />
            <ui-search-multi-select
                v-model:show="assignMemberShow"
                :value="assignMemberValue"
                @update:model-value="searchMembers"
                @focus="assignedMemberFocus"
                :data="assignMemberData"
                @select="selectMember"
                @deselect="deselectMember"
                :selected="assignedMemberSelected"
                label="Assign Members"
                name="assign_name"
                key-name="id"
                display="name"
                class="mb-4"
            />
            <div class="mb-4 md:flex gap-x-4">
                <ui-radio
                    v-model="recurringString"
                    name="recurring"
                    description="Will the event repeat?"
                    :options="recurringOptions"
                    color="primary"
                    :error-message="errorMessages.recurring"
                    :required="true"
                    class="flex-1 mb-4 md:mb-0"
                />
                <ui-select-menu
                    v-if="isRecurring"
                    v-model:show="frequencyShow"
                    v-model:selected="createEventsForm.frequency"
                    label="Repeat Every"
                    name="frequency"
                    :options="frequencyOptions"
                    class="flex-1"
                />
            </div>
            <div
                :class="
                    isRecurring
                        ? ' mb-4 md:flex gap-x-4 justify-between'
                        : 'mb-4'
                "
            >
                <ui-input
                    v-model="createEventsForm.start_date"
                    name="date"
                    type="date"
                    :label="dateFieldLabel"
                    :error-message="errorMessages.start_date"
                    :class="`mb-4 md:mb-0` + (isRecurring ? ' flex-1' : '')"
                    :required="true"
                />
                <ui-input
                    v-if="isRecurring"
                    v-model="createEventsForm.end_date"
                    name="end_date"
                    type="date"
                    label="End Date"
                    :error-message="errorMessages.end_date"
                    :class="isRecurring ? 'flex-1' : ''"
                />
            </div>
        </form>
    </ui-panel>
</template>

<script>
import UiPanel from "@/UI/UIPanel";
import UiRadio from "@/UI/UIRadio";
import UiInput from "@/UI/UIInput";
import UiTextArea from "@/UI/UITextArea";
import UiSelectMenu from "@/UI/UISelectMenu";
import UiSearchMultiSelect from "@/UI/UISearchMultiSelect";
export default {
    name: "CreateEventsPanel",

    components: {
        UiSearchMultiSelect,
        UiInput,
        UiPanel,
        UiRadio,
        UiSelectMenu,
        UiTextArea,
    },

    props: {
        show: {
            type: Boolean,
            default: false,
        },
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
                assigned: [],
            },
            errorMessages: {},
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
            assignMemberData: [],
            assignMemberShow: false,
            assignMemberValue: "",
            assignedMemberSelected: [],
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
        assignedMemberFocus() {
            if (this.assignMemberValue === "") {
                this.searchMembers();
            }
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
                assigned: [],
            };
        },
        close() {
            this.$emit("close");
        },
        closeCreateEventsPanel() {
            this.clearForm();
            this.errorMessage = {};
        },
        searchMembers: _.debounce(function (value) {
            this.assignMemberValue = value;
            axios.post('/members/search', {search: value})
                .then((res) => {
                    this.assignMemberData = res.data.members;
                });
        }, 1000),
        selectMember(option) {
            this.assignedMemberSelected.push(option);
            this.createEventsForm.assigned.push(option.id);
            this.assignMemberValue = "";
        },
        deselectMember(option) {
            let index = this.assignedMemberSelected.findIndex(elem => elem.id === option.id);
            this.assignedMemberSelected.splice(index, 1);
            let formIndex = this.createEventsForm.assigned.findIndex(elem => elem === option.id);
            this.createEventsForm.assigned.splice(formIndex, 1);
        },
        save() {
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
                    only: ["schedule", "errors"],
                }
            );
        },
    },
};
</script>

<style scoped></style>
