<template>
    <group-layout>
        <template #boxed>
            <div class="p-0 md:p-4">
                <div class="py-8">
                    <ui-button
                        type="button"
                        text="Create Schedule"
                        button-style="primary"
                        class="ml-4 md:ml-0"
                        @click="createScheduleShow(!createPanelShow)"
                    />
                </div>
                <ui-data-table
                    :data="getTableData()"
                    :fields="scheduleFields"
                    :editable="true"
                    :pagination="schedules"
                    :show-pagination="true"
                    @edit="editScheduleShow"
                />
            </div>
        </template>
        <ui-panel
            :show="createPanelShow"
            :form="true"
            :clear="false"
            :title="action + ' Schedule'"
            :save-text="action"
            @update:show="createScheduleShow($event)"
            @close="closeSchedulePanel"
            @save="submitSchedule"
        >
            <p class="text-gray-500 text-sm py-4">{{ action }} a schedule</p>
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
            </form>
        </ui-panel>
    </group-layout>
</template>

<script>
import GroupLayout from "@/Layouts/GroupLayout";
import UiDataTable from "@/UI/UIDataTable";
import UiButton from "@/UI/UIButton";
import UiPanel from "@/UI/UIPanel";
import UiInput from "@/UI/UIInput";
import UiTextArea from "@/UI/UITextArea";
export default {
    name: "SchedulesIndex",

    components: {
        UiTextArea,
        UiInput,
        UiPanel,
        UiButton,
        UiDataTable,
        GroupLayout,
    },

    props: {
        schedules: {
            type: Object,
            default: () => {},
        },
        errors: {
            type: Object,
            default: () => {},
        },
        group: {
            type: Object,
            default: () => {},
        },
    },

    data() {
        return {
            scheduleFields: [
                {
                    text: "Name",
                    field: "name",
                    route: "groups.schedules.show",
                },
                {
                    text: "Description",
                    field: "description",
                },
            ],
            createScheduleForm: {
                name: "",
                description: "",
            },
            createPanelShow: false,
            errorMessages: {},
            action: "Create",
        };
    },

    watch: {
        errors: function (newVal) {
            this.errorMessages = newVal;
        },
    },

    methods: {
        closeSchedulePanel() {
            this.createScheduleForm = {
                name: "",
                description: "",
            };
            this.errorMessages = {};
            this.action = "Create";
        },

        createScheduleShow(show) {
            this.createPanelShow = show;
        },

        submitSchedule() {
            if (this.createScheduleForm.id) {
                this.updateSchedule();
                return;
            }
            this.createSchedule();
        },

        createSchedule() {
            let self = this;
            let url = "/groups/" + this.group.id + "/schedules";
            this.$inertia.post(url, this.createScheduleForm, {
                onSuccess: function () {
                    self.closeSchedulePanel();
                    self.createScheduleShow(false);
                },
            });
        },

        updateSchedule() {
            let self = this;
            let url =
                "/groups/" +
                this.group.id +
                "/schedules/" +
                this.createScheduleForm.id;
            this.$inertia.patch(url, this.createScheduleForm, {
                onSuccess: function () {
                    self.closeSchedulePanel();
                    self.createScheduleShow(false);
                },
            });
        },

        editScheduleShow(schedule) {
            this.action = "Edit";
            this.createScheduleForm = _.cloneDeep(schedule);
            this.createScheduleShow(true);
        },

        getTableData() {
            return this.schedules.data.map((schedule) => {
                schedule.route = {
                    group: this.group.id,
                    schedule: schedule.id,
                };
                return schedule;
            });
        },
    },
};
</script>
