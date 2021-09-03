<template>
    <group-layout>
        <template #boxed>
            <div class="p-0 md:p-4">
                <div class="flex justify-between py-8">
                    <ui-button
                        type="button"
                        text="Add Existing User"
                        button-style="primary"
                        @click="addUserShow(!addPanelShow)"
                    ></ui-button>
                    <ui-button
                        type="button"
                        text="Create User for Group"
                        button-style="primary"
                        @click="createUserShow(!createPanelShow)"
                    ></ui-button>
                </div>
                <ui-data-table :data="getMembers()" :fields="membersFields" />
            </div>
        </template>
        <ui-panel
            :show="createPanelShow"
            :form="true"
            :clear="false"
            title="Add User to Group"
            save-text="Add"
            @update:show="createUserShow($event)"
            @close="closeCreateUser"
            @save="createUser"
        >
            <p class="text-gray-500 text-sm py-4">
                Create a new user for this group that can be claimed at a later
                time.
            </p>
            <form>
                <ui-input
                    v-model="createUserForm.name"
                    name="name"
                    type="string"
                    label="Name"
                    :required="true"
                    class="mb-4"
                    :error-message="errorMessages.name"
                />
                <ui-input
                    v-model="createUserForm.username"
                    name="username"
                    type="string"
                    label="Username"
                    :required="false"
                    class="mb-4"
                    :error-message="errorMessages.username"
                />
                <ui-input
                    v-model="createUserForm.email"
                    name="email"
                    type="string"
                    label="Email"
                    :required="false"
                    class="mb-4"
                    :error-message="errorMessages.email"
                />
                <ui-input
                    v-model="createUserForm.phone_number"
                    name="phone"
                    type="string"
                    label="Phone Number"
                    :required="false"
                    class="mb-4"
                    :error-message="errorMessages.phone_number"
                />
                <ui-input
                    v-model="createUserForm.groupme_username"
                    name="groupme"
                    type="string"
                    label="GroupMe Username"
                    :required="false"
                    :error-message="errorMessages.groupme_username"
                />
            </form>
        </ui-panel>
        <ui-panel
            :show="addPanelShow"
            :form="true"
            :clear="false"
            title="Add User to Group"
            save-text="Add"
            @update:show="addUserShow($event)"
            @close="closeAddUser"
            @save="addUser"
        >
            <p class="text-gray-500 text-sm py-4">
                Add an existing user by their username or email.
            </p>
            <form>
                <ui-input
                    v-model="addUserForm.username"
                    name="username"
                    type="string"
                    label="Username"
                    :required="false"
                    :error-message="errorMessages.username"
                    class="mb-4"
                />
                <ui-input
                    v-model="addUserForm.email"
                    name="email"
                    type="string"
                    label="Email"
                    :required="false"
                    :error-message="errorMessages.email"
                />
            </form>
        </ui-panel>
    </group-layout>
</template>

<script>
import GroupLayout from "@/Layouts/GroupLayout";

import UiButton from "@/UI/UIButton";
import UiPanel from "@/UI/UIPanel";
import UiDataTable from "@/UI/UIDataTable";
import UiInput from "@/UI/UIInput";
export default {
    name: "MembersIndex",

    components: { UiInput, UiDataTable, UiPanel, UiButton, GroupLayout },

    props: {
        members: {
            type: Array,
            default: () => {},
        },
        errors: {
            type: Object,
            default: () => {},
        },
    },

    data: function () {
        return {
            membersFields: [
                {
                    text: "Name",
                    field: "name",
                },
                {
                    text: "Email",
                    field: "email",
                },
                {
                    text: "Phone",
                    field: "phone_number",
                },
                {
                    text: "GroupMe",
                    field: "groupme_username",
                },
                {
                    text: "Active",
                    field: "active",
                },
            ],
            createPanelShow: false,
            createUserForm: {
                name: "",
                username: "",
                email: "",
                phone_number: "",
                groupme_username: "",
            },
            addPanelShow: false,
            addUserForm: {
                username: "",
                email: "",
            },
            errorMessages: {},
        };
    },

    watch: {
        errors: function (newVal) {
            this.errorMessages = newVal;
        },
    },

    methods: {
        getMembers() {
            return this.members.map((member) => {
                return {
                    name: member.name,
                    email: member.email,
                    phone_number: member.phone_number,
                    groupme_username: member.groupme_username,
                    active: member.claimed_at ? "Yes" : "No",
                };
            });
        },

        addUserShow(show) {
            this.addPanelShow = show;
        },

        closeAddUser() {
            this.addUserForm = {
                username: "",
                email: "",
            };
            this.errorMessages = {};
        },

        addUser() {
            let self = this;
            this.$inertia.post("/groups/members", this.addUserForm, {
                onSuccess: function () {
                    self.closeAddUser();
                    self.addUserShow(false);
                },
            });
        },

        createUserShow(show) {
            this.createPanelShow = show;
        },

        closeCreateUser() {
            this.createUserForm = {
                name: "",
                username: "",
                email: "",
                phone_number: "",
                groupme_username: "",
            };
            this.errorMessages = {};
        },

        createUser() {
            let self = this;
            this.$inertia.post("/users", this.createUserForm, {
                onSuccess: function () {
                    self.closeCreateUser();
                    self.createUserShow(false);
                },
            });
        },
    },
};
</script>
