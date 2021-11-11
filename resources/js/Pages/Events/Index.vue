<template>
    <group-layout :scroll="!createEventsShow">
        <template #boxed>
            <div class="p-0 md:m-4">
                <EventsTable
                    :events="events"
                    :group="group"
                    :errors="errors"
                    :success="success"
                    :fields="fields"
                    @panelShow="createEventsShow = $event"
                />
            </div>
        </template>
    </group-layout>
</template>

<script>
import GroupLayout from "@/Layouts/GroupLayout";
import UiButton from "@/UI/UIButton";
import UiDataTable from "@/UI/UIDataTable";
import CreateEventsPanel from "@/Components/Panels/CreateEventsPanel";
import DeleteModal from "@/Components/Modals/DeleteModal";
import EventsTable from "@/Partials/__eventsTable";
export default {
    name: "Index",

    components: {
        EventsTable,
        GroupLayout,
        UiButton,
        UiDataTable,
        CreateEventsPanel,
        DeleteModal,
    },

    props: {
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
            fields: ["name", "schedule", "date", "members"],
        };
    },
};
</script>
