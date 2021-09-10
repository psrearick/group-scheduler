<template>
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div
                class="
                    py-2
                    align-middle
                    inline-block
                    min-w-full
                    sm:px-6
                    lg:px-8
                "
            >
                <div
                    class="
                        shadow
                        overflow-hidden
                        border-b border-gray-200
                        sm:rounded-lg
                    "
                >
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    v-for="(field, index) in fields"
                                    :key="index"
                                    scope="col"
                                    class="
                                        px-6
                                        py-3
                                        text-left text-xs
                                        font-medium
                                        text-gray-500
                                        uppercase
                                        tracking-wider
                                    "
                                >
                                    {{ field.text }}
                                </th>
                                <th
                                    v-if="editable"
                                    scope="col"
                                    class="relative px-6 py-3"
                                >
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="(row, index) in data" :key="index">
                                <td
                                    v-for="(field, fieldIndex) in fields"
                                    :key="fieldIndex"
                                    class="
                                        px-6
                                        py-4
                                        whitespace-nowrap
                                        text-sm
                                        font-medium
                                        text-gray-900
                                    "
                                >
                                    <Link
                                        v-if="(field.link || field.route) && row[field.field]"
                                        :href="getUrl(field, row)"
                                        class="
                                            text-primary-600
                                            hover:text-primary-900
                                            cursor-pointer
                                            font-semibold
                                        "
                                    >
                                        {{ row[field.field] }}
                                    </Link>
                                    <p v-else>
                                        {{ row[field.field] }}
                                    </p>
                                </td>
                                <td
                                    v-if="editable"
                                    class="
                                        px-6
                                        py-4
                                        whitespace-nowrap
                                        text-right text-sm
                                        font-medium
                                    "
                                >
                                    <a
                                        class="
                                            text-primary-600
                                            hover:text-primary-900
                                            cursor-pointer
                                        "
                                        @click="$emit('edit', row)"
                                    >
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <ui-pagination :pagination="pagination" />
    </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
import UiPagination from "@/UI/UIPagination";

export default {
    name: "UiDataTable",

    components: { UiPagination, Link },

    props: {
        data: {
            type: Array,
            default: () => [],
        },
        fields: {
            type: Array,
            default: () => [],
        },
        editable: {
            type: Boolean,
            default: false,
        },
        showPagination: {
            type: Boolean,
            default: true,
        },
        pagination: {
            type: Object,
            default: () => {},
        },
    },

    methods: {
        getUrl(field, data) {
            return field.link
                ? field.link.replace("{link}", data[field.link_field])
                : route(field.route, data["route"][field.field]);
        },
    },
};
</script>
