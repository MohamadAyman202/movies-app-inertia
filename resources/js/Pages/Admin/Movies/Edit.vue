<script setup>
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import PageHeader from "@/Components/Admin/PageHeader.vue";

import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    movie: Object,
    errors: Object
});
const form = useForm({
    title: props.movie.title,
    runtime: props.movie.runtime,
    lang: props.movie.lang,
    format: props.movie.video_format,
    rating: props.movie.rating,
    poster_path: props.movie.poster_path,
    backdrop: props.movie.backdrop_path,
    overview: props.movie.overview,
    is_public: props.movie.is_public ? true : false,
});
function SubmitMovies(movie) {
    form.patch(route('admin.movies.update', movie));
}
</script>

<template>

    <Head title="Edit Movie" />

    <AdminAuthenticatedLayout>
        <template #header>
            <PageHeader LinkText="Movie Index " HeadLink="Edit Movie" :route="route('admin.movies.index', movie)" />
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="w-full flex mb-4 p-2 justify-end">
                </div>
                <section class="">
                    <form @submit.prevent="SubmitMovies(movie)">
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div class="w-full">
                                    <div class="">
                                        <label for="first-name" class="block text-sm font-medium text-gray-700">
                                            Title</label>
                                        <input v-model="form.title" type="text" autocomplete="given-name"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                        <small class="text-red-600" v-if="errors.title">{{ errors.title }}</small>
                                    </div>
                                    <div class="mt-3">
                                        <label for="first-name" class="block text-sm font-medium text-gray-700">
                                            Runtime</label>
                                        <input v-model="form.runtime" type="number" min="0" autocomplete="given-name"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                        <small class="text-red-600" v-if="errors.runtime">{{ errors.runtime }}</small>
                                    </div>
                                    <div class="mt-3">
                                        <label for="first-name" class="block text-sm font-medium text-gray-700">
                                            Language</label>
                                        <input v-model="form.lang" type="text" autocomplete="given-name"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                        <small class="text-red-600" v-if="errors.lang">{{ errors.lang }}</small>
                                    </div>
                                    <div class="mt-3">
                                        <label for="first-name" class="block text-sm font-medium text-gray-700">
                                            Format</label>
                                        <input v-model="form.format" type="text" autocomplete="given-name"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                        <small class="text-red-600" v-if="errors.format">{{ errors.format }}</small>
                                    </div>
                                    <div class="mt-3">
                                        <label for="first-name" class="block text-sm font-medium text-gray-700">
                                            Rating</label>
                                        <input v-model="form.rating" type="text" autocomplete="given-name"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                        <small class="text-red-600" v-if="errors.rating">{{ errors.rating }}</small>
                                    </div>
                                    <div class="mt-3">
                                        <label for="first-name" class="block text-sm font-medium text-gray-700">
                                            poster</label>
                                        <input v-model="form.poster_path" type="text" autocomplete="given-name"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                        <small class="text-red-600" v-if="errors.poster_path">{{ errors.poster_path }}</small>
                                    </div>
                                    <div class="mt-3">
                                        <label for="first-name" class="block text-sm font-medium text-gray-700">
                                            Bckdrop</label>
                                        <input v-model="form.backdrop" type="text" autocomplete="given-name"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                        <small class="text-red-600" v-if="errors.backdrop">{{ errors.backdrop }}</small>
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
