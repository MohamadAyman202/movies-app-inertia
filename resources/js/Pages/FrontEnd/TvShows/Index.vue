<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import MovieCard from '@/Components/Frontend/MovieCard.vue';
import Pagination from '@/Components/Admin/Pagination.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';

const props = defineProps({
    tvShows: Object
})
</script>
<template>

    <Head title="Tv Shows" />
    <AuthenticatedLayout>
        <main class="max-w-6xl mx-auto mt-6 min-h-screen">
            <section class="bg-gray-200 dark:bg-gray-900 dark:text-white mt-4 p-2 rounded">
                <div class="m-2 p-2 text-2xl font-bold text-indigo-600 dark:text-indigo-300">
                    <h1>Tv Shows</h1>
                </div>
                <div class=" grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 rounded">
                    <MovieCard v-for="tvShow in tvShows.data" :key="tvShow.slug">
                        <template #image>
                            <Link :href="route('tvShow.show', tvShow.slug)">
                            <div class="aspect-w-2 aspect-h-3">
                                <img class="object-cover"
                                    :src="`https://www.themoviedb.org/t/p/w220_and_h330_face/${tvShow.poster_path}`">
                            </div>
                            <div class="absolute inset-0 z-10 bg-gradient-to-t from-black to-transparent">
                            </div>

                            <div
                                class="absolute x-10 left-2 top-2 h-6 w-12 bg-gray-800 group-hover:bg-gray-700 text-blue-400 text-center rounded">
                                New
                            </div>
                            <div
                                class="absolute z-10 bottom-2 left-2 text-indigo-300 text-sm font-bold group-hover:text-blue-700">
                                {{ tvShow.seasons_count }}
                            </div>
                            </Link>
                        </template>
                        <Link :href="`tvShow/${tvShows.slug})`">
                        <div class="dark:text-white font-bold group-hover:text-blue-400">
                            {{ tvShow.name }}
                        </div>
                        </Link>
                    </MovieCard>
                </div>
                <Pagination :links="tvShows.links" />
            </section>
        </main>
    </AuthenticatedLayout>
</template>
