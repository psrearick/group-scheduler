<template>
    <ui-panel
        :show="show"
        :form="true"
        :clear="false"
        :title="titleText + ' ' + (isEditing ? createScheduleForm.name : 'Schedule')"
        save-text="Save"
        @update:show="$emit('update:show', $event)"
        @close="close"
        @save="save"
    >
        <p class="text-gray-500 text-sm py-4">{{ titleText }} a schedule</p>
        <form>
            <ui-input
                v-model="createScheduleForm.name"
                name="name"
                type="string"
                label="Name"
                :required="true"
                :error-message="errorMessages.name"
                class="mb-4"
            />
            <ui-text-area
                v-model="createScheduleForm.description"
                name="description"
                type="textarea"
                label="Description"
                :required="false"
                :error-message="errorMessages.description"
            />
            <div v-if="isEditing">
                <ui-button
                    class="mt-4"
                    button-style="danger"
                    text="Delete Schedule"
                    @click="requestDeleteSchedule"
                />
            </div>
        </form>
    </ui-panel>
</template>

<script>
import UiButton from "@/UI/UIButton";
import UiTextArea from "@/UI/UITextArea";
import UiInput from "@/UI/UIInput";
import UiPanel from "@/UI/UIPanel";
export default {
    name: "CreateSchedulesPanel",

    components: {
        UiPanel,
        UiInput,
        UiTextArea,
        UiButton
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
        group: {
            type: Object,
            default: () => {},
        },
        errors: {
            type: Object,
            default: () => {},
        },
        deleteSchedule: {
            type: Boolean,
            default: false,
        },
    },

    emits: ["update:show", "delete", "deleted"],

    data() {
        return {
            createScheduleForm: {
                name: "",
                description: "",
            },
            errorMessages: {},
        };
    },

    computed: {
        isEditing: function () {
            return !!this.schedule.id;
        },
        saveUrl: function () {
            return (
                "/groups/" +
                this.group.id +
                "/schedules" +
                (this.isEditing ? "/" + this.schedule.id : "")
            );
        },
        saveMethod: function () {
            return this.isEditing ? "patch" : "post";
        },
        titleText: function () {
            return this.isEditing ? "Edit" : "Create";
        },
    },

    watch: {
        errors: function (newVal) {
            this.errorMessages = newVal;
        },
        schedule: function (newVal) {
            this.clearForm();
            if(this.isEditing) {
                this.createScheduleForm = newVal;
            }
        },
        deleteSchedule: function (newVal) {
            if (newVal) {
                this.delete();
            }
        },
    },

    methods: {
        clearForm() {
            this.createScheduleForm = {
                name: "",
                description: "",
            };
            this.errorMessages = {};
        },
        close() {
            this.$emit("update:show", false);
        },
        closeSchedulePanel() {
            this.clearForm();
            this.close();
        },
        delete() {
            this.$inertia.delete(this.saveUrl, {
                onSuccess: () => {
                    this.$emit("deleted");
                    this.closeSchedulePanel();
                },
            });
        },
        requestDeleteSchedule() {
            this.$emit("delete");
        },
        createSchedule() {
            let self = this;
            let url = "/groups/" + this.group.id + "/schedules";
            this.$inertia.post(url, this.createScheduleForm, {
                onSuccess: function () {
                    self.closeSchedulePanel();
                    self.createSchedulesPanelShow(false);
                },
            });
        },
        save() {
            let self = this;
            this.$inertia.visit(this.saveUrl, {
                method: this.saveMethod,
                data: this.createScheduleForm,
                preserveState: true,
                onSuccess: () => {
                    if (Object.keys(this.errors).length === 0) {
                        self.closeSchedulePanel();
                    }
                },
            });
        },
    }
}
</script>
