<template>
    <ui-modal :show="show" :title="`Delete ${recordType}`">
        <template #icon>
            <icon icon="exclamation" color="text-red-500" />
        </template>
        <p class="text-sm text-gray-500">
            Are you sure you want to this {{ recordType.toLowerCase() }}? It
            will be permanently removed. This action cannot be undone.
        </p>
        <template #footer>
            <div class="sm:flex sm:flex-row-reverse gap-2">
                <ui-button
                    text="Delete"
                    button-style="danger"
                    @click="$emit('delete')"
                />
                <ui-button text="Cancel" button-style="white" @click="$emit('update:show', false)" />
            </div>
        </template>
    </ui-modal>
</template>

<script>
import UiModal from "@/UI/UIModal";
import Icon from "@/Components/Icon";
import UiButton from "@/UI/UIButton";
export default {
    name: "DeleteModal",

    components: { UiButton, Icon, UiModal },

    props: {
        show: {
            type: Boolean,
            default: false,
        },
        recordType: {
            type: String,
            default: "Record",
        },
    },

    emits: ["update:show", "delete"],
};
</script>
