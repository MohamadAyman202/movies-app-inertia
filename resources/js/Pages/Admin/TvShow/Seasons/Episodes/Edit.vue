<script setup>
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import PageHeader from "@/Components/Admin/PageHeader.vue";

import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    season: Object,
    tvShow: Object,
    episode: Object,
    errors: Object
});
const form = useForm({
    name: props.episode.name,
    overview: props.episode.overview,
    is_public: props.episode.is_public ? true : false,
});
function SubmitEpisode(episode) {
    form.patch(route('admin.episodes.update', [props.tvShow.id, props.season.id, episode.id]));
}
</script>

<template>

    <Head title="Edit Episode" />

    <AdminAuthenticatedLayout>
        <template #header>
            <PageHeader LinkText="Episode Index " HeadLink="Edit Episode"
                :route="route('admin.episodes.index', [tvShow.id, season.id])" />
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="w-full flex mb-4 p-2 justify-end">
                </div>
                <section class="">
                    <form @submit.prevent="SubmitEpisode(episode)">
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div class="w-full">
                                    <div class="">
                                        <label for="first-name" class="block text-sm font-medium text-gray-700">Episode
                                            name</label>
                                        <input v-model="form.name" type="text" autocomplete="given-name"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                        <small class="text-red-600" v-if="errors.name">{{ errors.name }}</small>
                                    </div>
                                    <div class="mt-3">
                                        <label for="first-name"
                                            class="block text-sm font-medium text-gray-700">Overview</label>
                                        <input v-model="form.overview" type="text" autocomplete="given-name"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                        <small class="text-red-600" v-if="errors.overview">{{ errors.overview
                                            }}</small>
                                    </div>
                                    <div class="form-check mt-3">
                                        <label class="form-check-label me-2" for="Published">Published</label>
                                        <input class="form-check-input" type="checkbox" v-model="form.is_public"
                                            value="" id="Published" />
                                    </div>
                                </div>
                                <div class="mt-5 text-center">
                                    <button
                                        class="px-4 py-2 bg-indigo-500 rounded hover:bg-indigo-700 text-white">Update
                                        Episode</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </AdminAuthenticatedLayout>
</template>
