<template>
    <group-layout>
        <template #boxed>
            <div class="p-4">
                <div class="flex justify-between py-8">
                    <div>Add Existing User to Group</div>
                    <div>Create User for Group</div>
                </div>
                <data-table
                    :data="getMembers()"
                    :fields="membersFields"

                />
            </div>
        </template>
    </group-layout>
</template>

<script>
import GroupLayout from "@/Layouts/GroupLayout";
import DataTable from "@/UI/DataTable";
export default {
    name: "MembersIndex",

    components: {DataTable, GroupLayout},

    props: {
        members: {
            type: Array,
            default: () => {}
        }
    },

    data: function() {
        return {
            membersFields: [
                {
                    text: 'Name',
                    field: 'name',
                },
                {
                    text: 'Email',
                    field: 'email',
                },
                {
                    text: 'Phone',
                    field: 'phone_number',
                },
                {
                    text: 'GroupMe',
                    field: 'groupme_username',
                },
                {
                    text: 'Active',
                    field: 'active',
                },
            ],
        }
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
        }
    }


}
</script>
