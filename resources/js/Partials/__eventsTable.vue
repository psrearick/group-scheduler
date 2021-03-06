<template>
    <div>
        <div
            v-if="!hasEvents"
            class="mx-2 my-4 p-4 bg-red-200 border border-red-800 rounded"
        >
            <p v-if="hasSchedule" class="text-red-700">
                This schedule has no events!
            </p>
            <p v-else class="text-red-700">You do not have any events!</p>
        </div>

        <div class="p-4 md:p-0">
            <ui-button
                type="button"
                text="Create Events"
                button-style="primary"
                class="mb-4"
                @click="createEventsPanelShow(!createEventsShow)"
            />

            <ui-data-table
                v-if="hasEvents"
                :data="getEventData()"
                :fields="eventFields"
                :editable="true"
                :pagination="events"
                :show-pagination="true"
                @edit="editEvent"
            />
        </div>
        <create-events-panel
            :can-create-multiple="canCreateMultiple"
            :delete-event="deleteEvent"
            :errors="errors"
            :event="editingEvent"
            :group="group"
            :schedule="schedule"
            :show="createEventsShow"
            @delete="deleteEventRequest"
            @deleted="deleteEvent = false"
            @update:show="createEventsPanelShow($event)"
        />
        <delete-modal
            :show="deleteModalShow"
            record-type="Event"
            @update:show="updateDeleteModalShow"
            @delete="deleteEventConfirmed"
        />
    </div>
</template>

<script>
import DeleteModal from "@/Components/Modals/DeleteModal";
import Icon from "@/Components/Icon";
import UiModal from "@/UI/UIModal";
import UiDataTable from "@/UI/UIDataTable";
import CreateEventsPanel from "@/Components/Panels/CreateEventsPanel";
import UiButton from "@/UI/UIButton";
import UiWell from "@/UI/UIWell";
import UiPanel from "@/UI/UIPanel";
import GroupLayout from "@/Layouts/GroupLayout";
import _ from "lodash";

export default {
    name: "EventsTable",

    components: {
        DeleteModal,
        Icon,
        UiModal,
        UiDataTable,
        CreateEventsPanel,
        UiButton,
        UiWell,
        UiPanel,
        GroupLayout,
    },

    props: {
        schedule: {
            type: Object,
            default: () => {},
        },
        events: {
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
        success: {
            type: String,
            default: "",
        },
        fields: {
            type: Array,
            default: () => {},
        },
        canCreateMultiple: {
            type: Boolean,
            default: false,
        },
    },

    emits: ["panelShow"],

    data() {
        return {
            createEventsShow: false,
            editingEvent: {},
            deleteModalShow: false,
            deleteEvent: false,
        };
    },

    computed: {
        hasEvents: function () {
            return this.events && this.events.data && this.events.data.length;
        },
        hasSchedule: function () {
            return this.schedule;
        },
        eventFields: function () {
            let eventFields = {
                name: {
                    text: "Name",
                    field: "name",
                    route: "groups.events.show",
                },
                description: {
                    text: "Description",
                    field: "description",
                },
                schedule: {
                    text: "Schedule",
                    field: "schedule_name",
                    route: "groups.schedules.show",
                },
                date: {
                    text: "Date",
                    field: "date",
                },
                members: {
                    text: "Assigned Members",
                    field: "assigned_members",
                },
                tasks: {
                    text: "Tasks",
                    field: "task_count",
                },
            };
            return this.fields.map((field) => {
                return eventFields[field];
            });
        },
    },

    methods: {
        createEventsPanelShow(show) {
            this.createEventsShow = show;
            if (!show) {
                this.editingEvent = {};
            }
            this.$emit("panelShow", show);
        },
        deleteEventConfirmed() {
            this.deleteModalShow = false;
            this.deleteEvent = true;
        },
        deleteEventRequest() {
            this.deleteModalShow = true;
        },
        editEvent(event) {
            this.editingEvent = _.cloneDeep(event);
            this.createEventsPanelShow(true);
        },
        getEventData() {
            return _.cloneDeep(this.events).data.map((event) => {
                event.assigned = event.members.map((member) => member.id);
                event.assigned_members = event.members
                    .map((member) => member.name)
                    .join(", ");
                event.task_count = event.tasks.length;
                event.route = {
                    name: {
                        group: this.group.id,
                        event: event.id,
                    },
                    schedule_name: event.schedule
                        ? {
                              group: event.schedule.group_id,
                              schedule: event.schedule.id,
                          }
                        : {},
                };
                event.schedule_name = event.schedule ? event.schedule.name : "";
                return event;
            });
        },
        updateDeleteModalShow(show) {
            this.deleteModalShow = show;
        },
    },
};
</script>
