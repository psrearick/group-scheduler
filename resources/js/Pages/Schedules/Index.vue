<template>
    <group-layout>
        <template #boxed>
            <div
                v-if="!hasSchedules"
                class="mx-2 my-4 p-4 bg-red-200 border border-red-800 rounded"
            >
                <p class="text-red-700">You do not have any schedules!</p>
            </div>
            <div class="p-0 md:p-4">
                <div class="py-8">
                    <ui-button
                        type="button"
                        text="Create Schedule"
                        button-style="primary"
                        class="ml-4 md:ml-0"
                        @click="createSchedulesPanelShow(!createSchedulesShow)"
                    />
                </div>
                <ui-data-table
                    v-if="hasSchedules"
                    :data="getScheduleData()"
                    :fields="scheduleFields"
                    :editable="true"
                    :pagination="schedules"
                    :show-pagination="true"
                    @edit="editSchedule"
                />
            </div>
        </template>
        <create-schedules-panel
            :delete-schedule="deleteSchedule"
            :errors="errors"
            :group="group"
            :schedule="editingSchedule"
            :show="createSchedulesShow"
            @delete="deleteScheduleRequest"
            @deleted="deleteSchedule = false"
            @update:show="createSchedulesPanelShow($event)"
        />
        <delete-modal
            :show="deleteModalShow"
            record-type="Schedule"
            @update:show="updateDeleteModalShow"
            @delete="deleteScheduleConfirmed"
        />
    </group-layout>
</template>

<script>
import GroupLayout from "@/Layouts/GroupLayout";
import UiDataTable from "@/UI/UIDataTable";
import UiButton from "@/UI/UIButton";
import UiPanel from "@/UI/UIPanel";
import UiInput from "@/UI/UIInput";
import UiTextArea from "@/UI/UITextArea";
import CreateSchedulesPanel from "@/Components/Panels/CreateSchedulesPanel";
import _ from "lodash";
import DeleteModal from "@/Components/Modals/DeleteModal";
export default {
    name: "SchedulesIndex",

    components: {
        CreateSchedulesPanel,
        DeleteModal,
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
            createSchedulesShow: false,
            editingSchedule: {},
            deleteModalShow: false,
            deleteSchedule: false,
        };
    },

    computed: {
        hasSchedules: function () {
            return (
                this.schedules &&
                this.schedules.data &&
                this.schedules.data.length
            );
        },
    },

    watch: {
        errors: function (newVal) {
            this.errorMessages = newVal;
        },
    },

    methods: {
        createSchedulesPanelShow(show) {
            this.createSchedulesShow = show;
            if (!show) {
                this.editingSchedule = {};
            }
        },

        deleteScheduleConfirmed() {
            this.deleteModalShow = false;
            this.deleteSchedule = true;
        },

        deleteScheduleRequest() {
            this.deleteModalShow = true;
        },

        editSchedule(schedule) {
            this.editingSchedule = _.cloneDeep(schedule);
            this.createSchedulesPanelShow(true);
        },

        getScheduleData() {
            return _.cloneDeep(this.schedules).data.map((schedule) => {
                schedule.route = {
                    name: {
                        group: this.group.id,
                        schedule: schedule.id,
                    },
                };
                return schedule;
            });
        },

        updateDeleteModalShow(show) {
            this.deleteModalShow = show;
        },
    },
};
</script>
