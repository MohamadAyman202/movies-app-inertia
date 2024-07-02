<script setup>
import { Link } from '@inertiajs/vue3';
const props = defineProps({
    LinkText: {
        type: String,
        required: true,
    },
    HeadLink: {
        type: String,
        required: true,
    },
    route: {
        type: String,
        required: false,
    },

    

})
</script>
<template>
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ HeadLink }}</h2>
        <Link :href="route"
            class="px-5 py-2 bg-green-600 hover:bg-green text-white rounded-lg flex justify-center items-center">
        {{ LinkText }}
        </Link>
    </div>
</template>
