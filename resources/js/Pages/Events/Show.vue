<template>
    <group-layout>
        <template #boxed>
            <div class="p-0 md:p-4">
                <ui-well class="mb-8">
                    <div class="flex justify-between mb-4">
                        <h2 class="text-xl">
                            {{ event.name
                            }}<span class="text-sm text-gray-700 ml-4">{{
                                event.date
                            }}</span>
                        </h2>
                        <ui-button
                            type="button"
                            text="Edit Event"
                            button-style="primary"
                            @click="editEventShow = true"
                        />
                    </div>
                    <p v-if="event.description" class="text-sm text-gray-700">
                        {{ event.description }}
                    </p>
                </ui-well>
                <div class="p-4 md:p-0">
                    <h3 class="text-lg mb-4">Tasks</h3>
                    <div
                        v-if="!hasTasks"
                        class="
                            mx-2
                            my-4
                            p-4
                            bg-danger-200
                            border border-danger-800
                            rounded
                        "
                    >
                        <p class="text-danger-700">
                            This event does not have any tasks!
                        </p>
                    </div>
                    <ui-button
                        type="button"
                        text="Add Task"
                        button-style="primary"
                        class="mb-4"
                        @click="createTaskPanelShow(true)"
                    />
                    <ui-data-table
                        v-if="hasTasks"
                        :data="getTaskData()"
                        :fields="taskFields"
                        :editable="true"
                        :pagination="tasks"
                        :show-pagination="true"
                        @edit="editTask"
                    />
                </div>
                <create-events-panel
                    v-model:show="editEventShow"
                    :can-create-multiple="false"
                    :delete-event="deleteEvent"
                    :errors="errors"
                    :event="eventData"
                    :group="group"
                    :schedule="schedule"
                    :redirect-on-delete="true"
                    @delete="deleteInitiate('Event')"
                    @deleted="deleteEvent = false"
                />
                <create-tasks-panel
                    v-model:show="addTaskShow"
                    :delete-task="deleteTask"
                    :errors="errors"
                    :event="eventData"
                    :group="group"
                    :task="editingTask"
                    @delete="deleteInitiate('Task')"
                    @deleted="deleteTask = false"
                    @close="createTaskPanelShow(false)"
                />
                <delete-modal
                    v-model:show="deleteModalShow"
                    :record-type="deleteRecordType"
                    @delete="deleteEventConfirmed"
                />
            </div>
        </template>
    </group-layout>
</template>

<script>
import GroupLayout from "@/Layouts/GroupLayout";
import UiWell from "@/UI/UIWell";
import UiButton from "@/UI/UIButton";
import CreateEventsPanel from "@/Components/Panels/CreateEventsPanel";
import DeleteModal from "@/Components/Modals/DeleteModal";
import _ from "lodash";
import UiDataTable from "@/UI/UIDataTable";
import CreateTasksPanel from "@/Components/Panels/CreateTasksPanel";

export default {
    name: "EventsShow",

    components: {
        CreateTasksPanel,
        UiDataTable,
        DeleteModal,
        CreateEventsPanel,
        UiButton,
        GroupLayout,
        UiWell,
    },

    props: {
        event: {
            type: Object,
            default: () => {},
        },
        tasks: {
            type: Object,
            default: () => {},
        },
        errors: {
            type: Object,
            default: () => {},
        },
        success: {
            type: String,
            default: "",
        },
    },

    data() {
        return {
            addTaskShow: false,
            editEventShow: false,
            editingTask: [],
            deleteModalShow: false,
            deleteEvent: false,
            deleteTask: false,
            deleteRecordType: "Event",
            freshEvent: null,
            taskFields: [
                {
                    text: "Name",
                    field: "name",
                },
                {
                    text: "Description",
                    field: "description",
                },
                {
                    text: "Assigned Members",
                    field: "assigned_members",
                },
            ],
        };
    },

    computed: {
        group: function () {
            return this.event.group;
        },
        schedule: function () {
            return this.event.schedule;
        },
        eventData: function () {
            const data = _.cloneDeep(this.event);
            data.assigned = data.members.map((member) => member.id);
            return data;
        },
        hasTasks: function () {
            return this.tasks && this.tasks.data && this.tasks.data.length > 0;
        },
    },

    watch: {
        editEventShow: function (status) {
            this.getFreshEvent(status);
        },
    },

    methods: {
        createTaskPanelShow(show) {
            this.addTaskShow = show;
            if (!show) {
                this.editingTask = [];
            }
        },
        deleteInitiate(recordType) {
            this.deleteRecordType = recordType;
            this.deleteModalShow = true;
        },
        deleteEventConfirmed() {
            this.deleteModalShow = false;
            if (this.deleteRecordType === "Event") {
                return (this.deleteEvent = true);
            }
            return (this.deleteTask = true);
        },
        getFreshEvent(open) {
            this.freshEvent = open ? this.eventData : null;
        },
        getTaskData() {
            return _.cloneDeep(this.tasks).data.map((task) => {
                task.assigned = task.members.map((member) => member.id);
                task.assigned_members = task.members
                    .map((member) => member.name)
                    .join(", ");
                return task;
            });
        },
        editTask(task) {
            this.editingTask = _.cloneDeep(task);
            this.createTaskPanelShow(true);
        },
    },
};
</script>
