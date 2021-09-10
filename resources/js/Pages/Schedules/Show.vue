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
                <events-table
                    :schedule="schedule"
                    :events="events"
                    :group="group"
                    :errors="errors"
                    :success="success"
                    :fields="fields"
                    :can-create-multiple="true"
                    @panelShow="createEventsShow = $event"
                />
            </div>
        </template>
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
import EventsTable from "@/Partials/__eventsTable";
export default {
    name: "SchedulesShow",

    components: {
        EventsTable,
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
    },

    data() {
        return {
            createEventsShow: false,
            fields: ["name", "description", "date", "members", "tasks"],
        };
    },
};
</script>
