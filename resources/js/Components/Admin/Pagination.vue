<script setup>
import { Link } from '@inertiajs/vue3';
defineProps({
    links: Array
})
</script>
<template>
    <div class="m-2 p-2 flex">
        <template v-for="(link, index) in links" :key="index">
            <div v-if="link.url === null" v-html="link.label"
                class="mb-1 mr-1 px-4 py-3 text-gray-400 text-sm leading-4 border rounded">
            </div>
            <Link v-else
                class="mb-1 mr-1 px-4 py-3 text-sm leading-4 border rounded focus:text-indigo-500 focus:border-indigo-500 hover:bg-white"
                :href="link.url" v-html="link.label" :class="{ 'bg-indigo-200': link.active }" />
        </template>
    </div>
</template>
