<template>
    <group-layout :scroll="!createEventsShow">
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
                    v-if="!hasEvents"
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

                <div class="p-4 md:p-0">
                    <ui-button
                        type="button"
                        text="Create Events"
                        button-style="primary"
                        class="mb-4"
                        @click="createEventsPanelShow(!createEventsShow)"
                    />

                    <div v-if="hasEvents">
                        <ui-data-table
                            :fields="eventFields"
                            :data="getEventData()"
                            :editable="true"
                            :show-pagination="true"
                            :pagination="getEventPagination()"
                            @edit="editEvent"
                        />
                    </div>
                </div>
            </div>
        </template>
        <create-events-panel
            :show="createEventsShow"
            :schedule="schedule"
            :event="editingEvent"
            :errors="errors"
            :delete-event="deleteEvent"
            @deleted="deleteEvent = false"
            @update:show="createEventsPanelShow($event)"
            @delete="deleteEventRequest"
        />
        <delete-modal
            :show="deleteModalShow"
            record-type="Event"
            @update:show="updateDeleteModalShow"
            @delete="deleteEventConfirmed"
        />
    </group-layout>
</template>

<script>
import GroupLayout from "@/Layouts/GroupLayout";
import UiWell from "@/UI/UIWell";
import UiButton from "@/UI/UIButton";
import UiPanel from "@/UI/UIPanel";
import CreateEventsPanel from "@/Components/Panels/CreateEventsPanel";
import UiDataTable from "@/UI/UIDataTable";
import UiModal from "@/UI/UIModal";
import Icon from "@/Components/Icon";
import DeleteModal from "@/Components/Modals/DeleteModal";
export default {
    name: "SchedulesShow",

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
            createEventsShow: false,
            eventFields: [
                {
                    text: "Name",
                    field: "name",
                    route: "groups.events.show",
                },
                {
                    text: "Description",
                    field: "description",
                },
                {
                    text: "Date",
                    field: "date",
                },
                {
                    text: "Assigned Members",
                    field: "assigned_members",
                },
                {
                    text: "Tasks",
                    field: "task_count",
                },
            ],
            editingEvent: {},
            deleteModalShow: false,
            deleteEvent: false,
        };
    },

    computed: {
        hasEvents: function () {
            return this.events.data && this.events.data.length;
        },
    },

    methods: {
        createEventsPanelShow(show) {
            this.createEventsShow = show;
            if (!show) {
                this.editingEvent = {};
            }
        },
        deleteEventRequest() {
            this.deleteModalShow = true;
        },
        deleteEventConfirmed() {
            this.deleteModalShow = false;
            this.deleteEvent = true;
        },
        editEvent(event) {
            this.editingEvent = event;
            this.createEventsPanelShow(true);
        },
        getEventData() {
            let events = _.cloneDeep(this.events.data);
            events.forEach((event) => {
                event.assigned = event.members.map((member) => member.id);
                event.assigned_members = event.members
                    .map((member) => member.name)
                    .join(", ");
                event.task_count = event.tasks.length;
                event.route = {
                    group: this.schedule.group_id,
                    event: event.id,
                };
            });
            return events;
        },
        getEventPagination() {
            return this.events;
        },
        updateDeleteModalShow(show) {
            this.deleteModalShow = show;
        },
    },
};
</script>
