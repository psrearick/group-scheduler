<template>
    <ui-panel
        :show="show"
        :form="true"
        :clear="false"
        :title="titleText + ' ' + (isEditing ? createTaskForm.name : 'Task')"
        save-text="Save"
        @update:show="$emit('update:show', $event)"
        @close="closeTaskPanel"
        @save="save"
    >
        <p class="text-gray-500 text-sm py-4">{{ titleText }} a task</p>
        <form>
            <ui-input
                v-model="createTaskForm.name"
                name="name"
                type="string"
                label="Name"
                :required="true"
                :error-message="errorMessages.name"
                class="mb-4"
            />
            <ui-text-area
                v-model="createTaskForm.description"
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
                :selected="createTaskForm.assigned"
                :current="task.members"
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
            <div v-if="isEditing">
                <ui-button
                    button-style="danger"
                    text="Delete Task"
                    @click="requestDeleteTask"
                />
            </div>
        </form>
    </ui-panel>
</template>

<script>
import UiPanel from "@/UI/UIPanel";
import UiInput from "@/UI/UIInput";
import UiButton from "@/UI/UIButton";
import UiTextArea from "@/UI/UITextArea";
import UiSearchMultiSelect from "@/UI/UISearchMultiSelect";
import _ from "lodash";

export default {
    name: "CreateTasksPanel",

    components: {
        UiSearchMultiSelect,
        UiTextArea,
        UiButton,
        UiInput,
        UiPanel,
    },

    props: {
        show: {
            type: Boolean,
            default: false,
        },
        task: {
            type: Object,
            default: () => {},
        },
        group: {
            type: Object,
            default: () => {},
        },
        event: {
            type: Object,
            default: () => {},
        },
        errors: {
            type: Object,
            default: () => {},
        },
        deleteTask: {
            type: Boolean,
            default: false,
        },
    },

    emits: ["update:show", "delete", "deleted", "close"],

    data() {
        return {
            createTaskForm: {
                name: "",
                description: "",
                assigned: [],
            },
            errorMessages: {},
            assignMemberData: [],
            assignMemberShow: false,
            assignMemberValue: "",
        };
    },

    computed: {
        isEditing: function () {
            return this.task && !!this.task.id;
        },
        saveUrl: function () {
            return (
                "/groups/" +
                this.group.id +
                "/events/" +
                this.event.id +
                "/tasks" +
                (this.isEditing ? "/" + this.task.id : "")
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
        errors: function (value) {
            this.errorMessages = value;
        },
        task: function (value) {
            this.clearForm();
            if (this.isEditing) {
                this.createTaskForm = value;
            }
        },
        deleteTask: function (value) {
            if (value) {
                this.delete();
            }
        },
    },

    methods: {
        clearForm() {
            this.createTaskForm = {
                name: "",
                description: "",
                assigned: [],
            };
            this.errorMessages = {};
            this.assignMemberShow = false;
        },
        close() {
            this.$emit("close");
            this.$emit("update:show", false);
        },
        closeTaskPanel() {
            this.clearForm();
            this.close();
        },
        delete() {
            this.$inertia.delete(this.saveUrl, {
                onSuccess: () => {
                    this.$emit("deleted");
                    this.closeTaskPanel();
                },
            });
        },
        requestDeleteTask() {
            this.$emit("delete");
        },
        save() {
            let self = this;
            this.$inertia.visit(this.saveUrl, {
                method: this.saveMethod,
                data: this.createTaskForm,
                preserveState: true,
                onSuccess: () => {
                    if (Object.keys(this.errors).length === 0) {
                        self.closeTaskPanel();
                    }
                },
            });
        },
        assignedMemberFocus() {
            if (this.assignMemberValue === "") {
                this.searchMembers();
            }
        },
        deselectMember(option) {
            let formIndex = this.createTaskForm.assigned.findIndex(
                (elem) => elem === option
            );
            this.createTaskForm.assigned.splice(formIndex, 1);
        },
        searchMembers: _.debounce(function (value) {
            this.assignMemberValue = value;
            axios.post("/members/search", { search: value }).then((res) => {
                this.assignMemberData = res.data.members;
            });
        }, 1000),
        selectMember(option) {
            if (this.createTaskForm.assigned.indexOf(option) === -1) {
                this.createTaskForm.assigned.push(option);
            }
            this.assignMemberValue = "";
        },
    },
};
</script>
