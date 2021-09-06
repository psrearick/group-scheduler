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
                    v-if="!schedule.events.length"
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
                        @click="createEventsPanelShow(!createEventsShow)"
                    />
                </div>
            </div>
        </template>
        <create-events-panel
            :show="createEventsShow"
            :schedule="schedule"
            :errors="errors"
            @update:show="createEventsPanelShow($event)"
        />
    </group-layout>
</template>

<script>
import GroupLayout from "@/Layouts/GroupLayout";
import UiWell from "@/UI/UIWell";
import UiButton from "@/UI/UIButton";
import UiPanel from "@/UI/UIPanel";
import UiTextArea from "@/UI/UITextArea";
import UiSelectMenu from "@/UI/UISelectMenu";
import CreateEventsPanel from "@/Components/Panels/CreateEventsPanel";
export default {
    name: "SchedulesShow",

    components: {
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
        errors: {
            type: Object,
            default: () => {},
        },
    },

    data() {
        return {
            createEventsShow: false,
        };
    },

    methods: {
        createEventsPanelShow(show) {
            this.createEventsShow = show;
        },
    },
};
</script>
