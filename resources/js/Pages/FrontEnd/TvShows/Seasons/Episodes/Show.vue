<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import MovieCard from '@/Components/Frontend/MovieCard.vue';
import Pagination from '@/Components/Admin/Pagination.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { ref } from 'vue'
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from '@headlessui/vue'
const props = defineProps({
    season: Object,
    episode: Object,
    latest: Object,
})


const isOpen = ref(false)
const modalTrailer = ref({});

function closeModal() {
    isOpen.value = false
}
function openModal(trailer) {
    modalTrailer.value = trailer;
    isOpen.value = true
}
</script>
<template>

    <Head title="tvShow" />
    <AuthenticatedLayout>
        <main class="my-2" v-if="episode">
            <section class="bg-gradient-to-r from-indigo-700 to-transparent">
                <div class="max-w-6xl mx-auto m-4 p-2">
                    <div class="flex">
                        <div class="w-3/12">
                            <div class="w-full">
                                <img class="w-full h-full rounded"
                                    :src="`https://www.themoviedb.org/t/p/w220_and_h330_face/${season.poster_path}`">
                            </div>
                        </div>
                        <div class="w-8/12">
                            <div class="m-4 p-6">
                                <h1 class="flex text-white font-bold text-4xl">{{ episode.name }}</h1>
                                <div class="flex p-3 text-white space-x-4">
                                    <span>{{ season.name }}</span>
                                </div>
                            </div>
                            <div class="p-8 text-white">
                                <p>{{ episode.overview }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="max-w-6xl mx-auto bg-gray-200 dark:bg-gray-900 p-2 rounded">
                <div class="flex justify-between">
                    <div class="">
                        <h1 class="flex text-slate-600 dark:text-white font-bold text-xl">Episodes</h1>
                        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mt-4">
                            <MovieCard v-for="lseason in latest" :key="lseason.slug">
                                <template #image>
                                    <Link :href="route('episodes.show', lseason.slug)">
                                    <img class=""
                                        :src="`https://www.themoviedb.org/t/p/w220_and_h330_face/${season.poster_path}`">
                                    </Link>
                                </template>
                                <Link :href="route('episodes.show', lseason.slug)">
                                <span class=" text-dark">{{ lseason.name }}</span>
                                </Link>
                            </MovieCard>
                        </div>
                    </div>
                </div>
            </section>

        </main>

    </AuthenticatedLayout>

</template>
