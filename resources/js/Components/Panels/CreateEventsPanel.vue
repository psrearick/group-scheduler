<template>
    <ui-panel
        :show="show"
        :form="true"
        :clear="false"
        :title="isEditing ? `Edit ${createEventsForm.name}` : 'Create Events'"
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
                :data="assignMemberData"
                :selected="assignedMemberSelected"
                label="Assign Members"
                name="assign_name"
                key-name="id"
                display="name"
                class="mb-4"
                @update:model-value="searchMembers"
                @focus="assignedMemberFocus"
                @select="selectMember"
                @deselect="deselectMember"
            />
            <div v-if="!isEditing && canCreateMultiple" class="mb-4 md:flex gap-x-4">
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
                    :error-message="errorMessages.frequency"
                    :options="frequencyOptions"
                    class="flex-1"
                    :required="isRecurring"
                />
            </div>
            <div
                :class="
                    isRecurring
                        ? ' mb-8 md:flex gap-x-4 justify-between'
                        : 'mb-8'
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
                    :required="isRecurring"
                />
            </div>
            <div v-if="isEditing">
                <ui-button
                    button-style="danger"
                    text="Delete Event"
                    @click="requestDeleteEvent"
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
import UiButton from "@/UI/UIButton";
export default {
    name: "CreateEventsPanel",

    components: {
        UiButton,
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
        canCreateMultiple: {
            type: Boolean,
            default: true,
        },
        schedule: {
            type: Object,
            default: () => {},
        },
        group: {
            type: Object,
            default: () => {},
        },
        errors: {
            type: Object,
            default: () => {},
        },
        event: {
            type: Object,
            default: () => {},
        },
        deleteEvent: {
            type: Boolean,
            default: false,
        },
    },

    emits: ["update:show", "delete", "deleted"],

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
        isEditing: function () {
            return !!this.event.id;
        },
        saveUrl: function () {
            return "/groups/" + this.group.id + "/events"
                + (this.isEditing ? "/" + this.event.id : "");
        },
        saveMethod: function () {
            return this.isEditing ? "patch" : "post";
        },
    },

    watch: {
        errors: function (newVal) {
            this.errorMessages = newVal;
        },
        event: function (newVal) {
            this.clearForm();
            if (this.isEditing) {
                this.createEventsForm = newVal;
                if (newVal.members) {
                    newVal.members.forEach((member) => {
                        this.selectMember(member);
                    });
                }
            }
        },
        deleteEvent: function (newVal) {
            if (newVal) {
                this.delete();
            }
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
            this.errorMessage = {};
            this.recurringString = "";
            this.assignMemberShow = false;
            this.frequencyShow = false;
            this.assignedMemberSelected = [];
        },
        close() {
            this.$emit("update:show", false);
        },
        closeCreateEventsPanel() {
            this.clearForm();
            this.close();
        },
        searchMembers: _.debounce(function (value) {
            this.assignMemberValue = value;
            axios.post("/members/search", { search: value }).then((res) => {
                this.assignMemberData = res.data.members;
            });
        }, 1000),
        selectMember(option) {
            this.assignedMemberSelected.push(option);
            if (this.createEventsForm.assigned.indexOf(option.id) === -1) {
                this.createEventsForm.assigned.push(option.id);
            }
            this.assignMemberValue = "";
        },
        deselectMember(option) {
            let index = this.assignedMemberSelected.findIndex(
                (elem) => elem.id === option
            );
            this.assignedMemberSelected.splice(index, 1);
            let formIndex = this.createEventsForm.assigned.findIndex(
                (elem) => elem === option
            );
            this.createEventsForm.assigned.splice(formIndex, 1);
        },
        requestDeleteEvent() {
            this.$emit("delete");
        },
        delete() {
            this.$inertia.delete(this.saveUrl, {
                onSuccess: () => {
                    this.$emit("deleted");
                    this.closeCreateEventsPanel();
                },
            });
        },
        save() {
            let self = this;
            this.createEventsForm.schedule_id = this.schedule
                ? this.schedule.id
                : this.createEventsForm.schedule_id;
            this.createEventsForm.recurring = this.isRecurring;
            this.$inertia.visit(this.saveUrl, {
                method: this.saveMethod,
                data: this.createEventsForm,
                preserveState: true,
                onSuccess: () => {
                    if (Object.keys(this.errors).length === 0) {
                        self.closeCreateEventsPanel();
                    }
                },
            });
        },
    },
};
</script>

<style scoped></style>
