<template>
    <Head title="Privacy Policy" />

    <div class="font-sans text-gray-900 antialiased">
        <div class="pt-4 bg-gray-100">
            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                <div>
                    <link-logo-large />
                </div>

                <div
                    class="
                        w-full
                        sm:max-w-2xl
                        mt-6
                        p-6
                        bg-white
                        shadow-md
                        overflow-hidden
                        sm:rounded-lg
                        prose
                    "
                    v-html="policy"
                ></div>
            </div>
        </div>
    </div>
</template>

<script>
import { Head } from "@inertiajs/inertia-vue3";
import LinkLogoLarge from "@/Components/LinkLogoLarge";

export default {
    components: {
        LinkLogoLarge,
        Head,
    },
    props: ["policy"],
};
</script>
