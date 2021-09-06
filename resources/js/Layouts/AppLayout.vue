<template>
    <div>
        <Head :title="title" />

        <jet-banner />
        <ui-flash />

        <div :class="`h-screen bg-gray-100 ${scrollClass}`">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="flex-shrink-0 flex items-center">
                                <link-logo :href="route('dashboard')" />
                            </div>

                            <!-- Navigation Links -->
                            <div
                                class="
                                    hidden
                                    space-x-8
                                    sm:-my-px sm:ml-10 sm:flex
                                "
                            >
                                <jet-nav-link
                                    :href="route('dashboard')"
                                    :active="route().current('dashboard')"
                                >
                                    Dashboard
                                </jet-nav-link>

                                <jet-nav-link
                                    v-if="$page.props.group"
                                    :href="route('groups.members')"
                                    :active="route().current('groups.members')"
                                >
                                    Members
                                </jet-nav-link>

                                <jet-nav-link
                                    v-if="$page.props.group"
                                    :href="
                                        route('groups.schedules.index', {
                                            group: $page.props.group,
                                        })
                                    "
                                    :active="
                                        route().current(
                                            'groups.schedules.index'
                                        )
                                    "
                                >
                                    Schedules
                                </jet-nav-link>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <div class="ml-3 relative">
                                <!-- Groups Dropdown -->
                                <jet-dropdown align="right" width="60">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="
                                                    inline-flex
                                                    items-center
                                                    px-3
                                                    py-2
                                                    border border-transparent
                                                    text-sm
                                                    leading-4
                                                    font-medium
                                                    rounded-md
                                                    text-gray-500
                                                    bg-white
                                                    hover:bg-gray-50
                                                    hover:text-gray-700
                                                    focus:outline-none
                                                    focus:bg-gray-50
                                                    active:bg-gray-50
                                                    transition
                                                "
                                            >
                                                <span v-if="$page.props.group">
                                                    {{ $page.props.group.name }}
                                                </span>
                                                <span v-else>
                                                    No Group Selected
                                                </span>
                                                <svg
                                                    class="ml-2 -mr-0.5 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <div class="w-60">
                                            <!-- Group Management -->
                                            <div
                                                class="
                                                    block
                                                    px-4
                                                    py-2
                                                    text-xs text-gray-400
                                                "
                                            >
                                                Manage Group
                                            </div>

                                            <!-- Group Settings -->
                                            <jet-dropdown-link
                                                v-if="$page.props.group"
                                                :href="
                                                    route(
                                                        'groups.edit',
                                                        $page.props.group.id
                                                    )
                                                "
                                            >
                                                Group Settings
                                            </jet-dropdown-link>

                                            <jet-dropdown-link
                                                :href="route('groups.create')"
                                            >
                                                Create New Group
                                            </jet-dropdown-link>

                                            <p
                                                v-if="$page.props.group"
                                                class="
                                                    cursor-pointer
                                                    block
                                                    px-4
                                                    py-2
                                                    text-sm
                                                    leading-5
                                                    text-gray-700
                                                    hover:bg-gray-100
                                                    focus:outline-none
                                                    focus:bg-gray-100
                                                    transition
                                                "
                                                @click="exitGroup"
                                            >
                                                Exit Group
                                            </p>

                                            <div
                                                class="border-t border-gray-100"
                                            ></div>

                                            <!-- Group Switcher -->
                                            <div
                                                v-if="$page.props.group"
                                                class="
                                                    block
                                                    px-4
                                                    py-2
                                                    text-xs text-gray-400
                                                "
                                            >
                                                Switch Groups
                                            </div>
                                            <div
                                                v-else
                                                class="
                                                    block
                                                    px-4
                                                    py-2
                                                    text-xs text-gray-400
                                                "
                                            >
                                                Select Group
                                            </div>

                                            <div
                                                v-for="group in $page.props.user
                                                    .groups"
                                                :key="group.id"
                                            >
                                                <form
                                                    @submit.prevent="
                                                        switchToGroup(group.id)
                                                    "
                                                >
                                                    <jet-dropdown-link
                                                        as="button"
                                                    >
                                                        <div
                                                            class="
                                                                flex
                                                                items-center
                                                            "
                                                        >
                                                            <svg
                                                                v-if="
                                                                    $page.props
                                                                        .group &&
                                                                    group.id ===
                                                                        $page
                                                                            .props
                                                                            .group
                                                                            .id
                                                                "
                                                                class="
                                                                    mr-2
                                                                    h-5
                                                                    w-5
                                                                    text-emerald-400
                                                                "
                                                                fill="none"
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                stroke-width="2"
                                                                stroke="currentColor"
                                                                viewBox="0 0 24 24"
                                                            >
                                                                <path
                                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                                                ></path>
                                                            </svg>
                                                            <div>
                                                                {{ group.name }}
                                                            </div>
                                                        </div>
                                                    </jet-dropdown-link>
                                                </form>
                                            </div>
                                        </div>
                                    </template>
                                </jet-dropdown>
                            </div>

                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <jet-dropdown align="right" width="48">
                                    <template #trigger>
                                        <button
                                            v-if="
                                                $page.props.jetstream
                                                    .managesProfilePhotos
                                            "
                                            class="
                                                flex
                                                text-sm
                                                border-2 border-transparent
                                                rounded-full
                                                focus:outline-none
                                                focus:border-gray-300
                                                transition
                                            "
                                        >
                                            <img
                                                class="
                                                    h-8
                                                    w-8
                                                    rounded-full
                                                    object-cover
                                                "
                                                :src="
                                                    $page.props.user
                                                        .profile_photo_url
                                                "
                                                :alt="$page.props.user.name"
                                            />
                                        </button>

                                        <span
                                            v-else
                                            class="inline-flex rounded-md"
                                        >
                                            <button
                                                type="button"
                                                class="
                                                    inline-flex
                                                    items-center
                                                    px-3
                                                    py-2
                                                    border border-transparent
                                                    text-sm
                                                    leading-4
                                                    font-medium
                                                    rounded-md
                                                    text-gray-500
                                                    bg-white
                                                    hover:text-gray-700
                                                    focus:outline-none
                                                    transition
                                                "
                                            >
                                                {{ $page.props.user.name }}

                                                <svg
                                                    class="ml-2 -mr-0.5 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <!-- Account Management -->
                                        <div
                                            class="
                                                block
                                                px-4
                                                py-2
                                                text-xs text-gray-400
                                            "
                                        >
                                            Manage Account
                                        </div>

                                        <jet-dropdown-link
                                            :href="route('profile.show')"
                                        >
                                            Profile
                                        </jet-dropdown-link>

                                        <jet-dropdown-link
                                            v-if="
                                                $page.props.jetstream
                                                    .hasApiFeatures
                                            "
                                            :href="route('api-tokens.index')"
                                        >
                                            API Tokens
                                        </jet-dropdown-link>

                                        <div
                                            class="border-t border-gray-100"
                                        ></div>

                                        <!-- Authentication -->
                                        <form @submit.prevent="logout">
                                            <jet-dropdown-link as="button">
                                                Log Out
                                            </jet-dropdown-link>
                                        </form>
                                    </template>
                                </jet-dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button
                                class="
                                    inline-flex
                                    items-center
                                    justify-center
                                    p-2
                                    rounded-md
                                    text-gray-400
                                    hover:text-gray-500 hover:bg-gray-100
                                    focus:outline-none
                                    focus:bg-gray-100
                                    focus:text-gray-500
                                    transition
                                "
                                @click="
                                    showingNavigationDropdown =
                                        !showingNavigationDropdown
                                "
                            >
                                <svg
                                    class="h-6 w-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex':
                                                !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex':
                                                showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
                    class="sm:hidden"
                >
                    <div class="pt-2 pb-3 space-y-1">
                        <jet-responsive-nav-link
                            :href="route('dashboard')"
                            :active="route().current('dashboard')"
                        >
                            Dashboard
                        </jet-responsive-nav-link>

                        <jet-responsive-nav-link
                            :href="route('groups.members')"
                            :active="route().current('groups.members')"
                        >
                            Members
                        </jet-responsive-nav-link>

                        <jet-responsive-nav-link
                            v-if="$page.props.group"
                            :href="
                                route('groups.schedules.index', {
                                    group: $page.props.group,
                                })
                            "
                            :active="route().current('groups.schedules.index')"
                        >
                            Schedules
                        </jet-responsive-nav-link>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="flex items-center px-4">
                            <div
                                v-if="
                                    $page.props.jetstream.managesProfilePhotos
                                "
                                class="flex-shrink-0 mr-3"
                            >
                                <img
                                    class="h-10 w-10 rounded-full object-cover"
                                    :src="$page.props.user.profile_photo_url"
                                    :alt="$page.props.user.name"
                                />
                            </div>

                            <div>
                                <div
                                    class="font-medium text-base text-gray-800"
                                >
                                    {{ $page.props.user.name }}
                                </div>
                                <div class="font-medium text-sm text-gray-500">
                                    {{ $page.props.user.email }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <jet-responsive-nav-link
                                :href="route('profile.show')"
                                :active="route().current('profile.show')"
                            >
                                Profile
                            </jet-responsive-nav-link>

                            <jet-responsive-nav-link
                                v-if="$page.props.jetstream.hasApiFeatures"
                                :href="route('api-tokens.index')"
                                :active="route().current('api-tokens.index')"
                            >
                                API Tokens
                            </jet-responsive-nav-link>

                            <!-- Authentication -->
                            <form method="POST" @submit.prevent="logout">
                                <jet-responsive-nav-link as="button">
                                    Log Out
                                </jet-responsive-nav-link>
                            </form>

                            <!-- Group Management -->
                            <div class="border-t border-gray-200"></div>

                            <div class="block px-4 py-2 text-xs text-gray-400">
                                Manage Group
                            </div>

                            <!-- Group Settings -->
                            <jet-responsive-nav-link
                                v-if="$page.props.group"
                                :href="
                                    route('groups.edit', $page.props.group.id)
                                "
                                :active="route().current('groups.edit')"
                            >
                                Group Settings
                            </jet-responsive-nav-link>

                            <jet-responsive-nav-link
                                :href="route('groups.create')"
                                :active="route().current('groups.create')"
                            >
                                Create New Group
                            </jet-responsive-nav-link>

                            <p
                                v-if="$page.props.group"
                                class="
                                    block
                                    pl-3
                                    pr-4
                                    py-2
                                    border-l-4 border-transparent
                                    text-base
                                    font-medium
                                    text-gray-600
                                    hover:text-gray-800
                                    hover:bg-gray-50
                                    hover:border-gray-300
                                    focus:outline-none
                                    focus:text-gray-800
                                    focus:bg-gray-50
                                    focus:border-gray-300
                                    transition
                                "
                                @click="exitGroup"
                            >
                                Exit Group
                            </p>

                            <div class="border-t border-gray-200"></div>

                            <!-- Group Switcher -->
                            <div
                                v-if="$page.props.group"
                                class="block px-4 py-2 text-xs text-gray-400"
                            >
                                Switch Groups
                            </div>
                            <div
                                v-else
                                class="block px-4 py-2 text-xs text-gray-400"
                            >
                                Select Group
                            </div>

                            <template
                                v-for="group in $page.props.user.groups"
                                :key="group.id"
                            >
                                <form @submit.prevent="switchToGroup(group.id)">
                                    <jet-responsive-nav-link as="button">
                                        <div class="flex items-center">
                                            <svg
                                                v-if="
                                                    $page.props.group &&
                                                    group.id ===
                                                        $page.props.group.id
                                                "
                                                class="
                                                    mr-2
                                                    h-5
                                                    w-5
                                                    text-emerald-400
                                                "
                                                fill="none"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                                ></path>
                                            </svg>
                                            <div>{{ group.name }}</div>
                                        </div>
                                    </jet-responsive-nav-link>
                                </form>
                            </template>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header v-if="$slots.header" class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header"></slot>
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot></slot>
            </main>
        </div>
    </div>
</template>

<script>
import JetBanner from "@/Jetstream/Banner.vue";
import JetDropdown from "@/Jetstream/Dropdown.vue";
import JetDropdownLink from "@/Jetstream/DropdownLink.vue";
import JetNavLink from "@/Jetstream/NavLink.vue";
import JetResponsiveNavLink from "@/Jetstream/ResponsiveNavLink.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import UiFlash from "@/UI/UIFlash";
import LinkLogo from "@/Components/LinkLogo";

export default {
    components: {
        LinkLogo,
        UiFlash,
        Head,
        JetBanner,
        JetDropdown,
        JetDropdownLink,
        JetNavLink,
        JetResponsiveNavLink,
        Link,
    },
    props: {
        title: {
            type: String,
            default: "",
        },
        scroll: {
            type: Boolean,
            default: true,
        },
    },

    data() {
        return {
            showingNavigationDropdown: false,
        };
    },

    computed: {
        scrollClass: function () {
            return this.scroll ? "overflow-auto" : "overflow-hidden";
        },
    },

    methods: {
        switchToGroup(group) {
            this.$inertia.get(
                "/groups/" + group,
                {},
                {
                    preserveState: false,
                }
            );
        },

        exitGroup() {
            this.$inertia.delete("/groups");
        },

        logout() {
            this.$inertia.post(route("logout"));
        },
    },
};
</script>
