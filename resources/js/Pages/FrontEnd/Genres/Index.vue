<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import MovieCard from '@/Components/Frontend/MovieCard.vue';
import Pagination from '@/Components/Admin/Pagination.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';

const props = defineProps({
    genre: Object,
    movies: Object,
})
</script>
<template>

    <Head title="Genres" />
    <AuthenticatedLayout>
        <main class="max-w-6xl mx-auto mt-6 min-h-screen">
            <section class="bg-gray-200 dark:bg-gray-900 dark:text-white mt-4 p-2 rounded">
                <div class="m-2 p-2 text-2xl font-bold text-indigo-600 dark:text-indigo-300">
                    <h1>{{ genre.title }}</h1>
                </div>
                <div class=" grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 rounded">
                    <MovieCard v-for="movies in movies.data" :key="genre.slug">
                        <template #image>
                            <Link :href="route('movies.show', movies.slug)">
                            <div class="aspect-w-2 aspect-h-3">
                                <img class="object-cover"
                                    :src="`https://www.themoviedb.org/t/p/w220_and_h330_face/${movies.poster_path}`">
                            </div>
                            <div
                                class="absolute x-10 left-2 top-2 h-6 w-12 bg-gray-800 group-hover:bg-gray-700 text-blue-400 text-center rounded">
                                New
                            </div>
                            <div class="absolute inset-0 z-10 bg-gradient-to-t from-black to-transparent"></div>
                            <div class="absolute inset-y-0 left-5 z-10 invisible group-hover:visible flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-12 w-12 text-blue-700 bg-red-700 rounded-full" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div
                                    class="absolute transition opacity-0 duration-500 ease-in-out transform group-hover:opacity-100 group-hover:translate-x-16 group-hover:pr-2 text-white font-bold">
                                    Play</div>
                            </div>

                            </Link>
                        </template>
                        <Link :href="route('casts.show', movies.slug)">
                        <div class="dark:text-white font-bold group-hover:text-blue-400">
                            {{ movies.title }}
                        </div>
                        </Link>
                    </MovieCard>
                </div>
                <Pagination :links="movies.links" />
            </section>
        </main>
    </AuthenticatedLayout>
</template>
