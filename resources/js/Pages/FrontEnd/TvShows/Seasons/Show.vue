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
    tvShow: Object,
    season: Object,
    episodes: Object,
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
        <main class="my-2" v-if="season">
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
                                <h1 class="flex text-white font-bold text-4xl">{{ season.name }}</h1>
                                <div class="flex p-3 text-white space-x-4">
                                    <span> Season Nr: {{ tvShow.name }} - {{ tvShow.created_year }}</span>
                                </div>
                            </div>
                            <div class="p-8 text-white">
                                <p>{{ tvShow.overview }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="max-w-6xl mx-auto bg-gray-200 dark:bg-gray-900 p-2 rounded">
                <div class="flex justify-between">
                    <div class="w-7/12">
                        <h1 class="flex text-slate-600 dark:text-white font-bold text-xl">Episodes</h1>
                        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mt-4">
                            <MovieCard v-for="episode in season.episodes" :key="episode.slug">
                                <template #image>
                                    <Link :href="route('episodes.show', episode.slug)">
                                    <img class=""
                                        :src="`https://www.themoviedb.org/t/p/w220_and_h330_face/${season.poster_path}`">
                                    </Link>
                                </template>
                                <Link :href="route('episodes.show', episode.slug)">
                                <span class=" text-dark">{{ episode.name }}</span>
                                </Link>
                            </MovieCard>
                        </div>
                    </div>
                    <div class="w-4/12">
                        <h1 class="flex text-slate-600 dark:text-white mb-3 font-bold text-xl">Latest Movies</h1>
                        <div class="grid grid-cols-3 gap-2">
                            <div v-for="lmovie in latest" :key="latest.slug">
                                <Link :href="route('movies.show', lmovie.slug)">
                                <img class="w-full h-full rounded-lg"
                                    :src="`https://www.themoviedb.org/t/p/w220_and_h330_face/${lmovie.poster_path}`">
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- <section class="max-w-6xl mx-auto bg-gradient-to-r from-indigo-700 to-transparent mt-6 p-2"
                v-if="tvShow.tags">
                <span v-for="tag in tvShow.tags" :key="tag.slug"
                    class="font-bold text-white hover:text-indigo-200 cursor-pointer">
                    <Link :href="route('tags.show', tag.slug)">
                    </Link>
                </span>
            </section> -->
        </main>

    </AuthenticatedLayout>
    <TransitionRoot appear :show="isOpen" as="template">
        <Dialog as="div" @close="closeModal" class="relative z-10">
            <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0" enter-to="opacity-100"
                leave="duration-200 ease-in" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-black/25" />
            </TransitionChild>

            <div class="fixed inset-0 overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 text-center">
                    <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0 scale-95"
                        enter-to="opacity-100 scale-100" leave="duration-200 ease-in" leave-from="opacity-100 scale-100"
                        leave-to="opacity-0 scale-95">
                        <DialogPanel
                            class="w-full max-w-6xl transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all">
                            <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900">
                                {{ tvShow.title }}
                            </DialogTitle>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500" v-if="modalTrailer[0]">
                                <div class="aspect-w-16 aspect-h-10" v-html="modalTrailer[0].embed_html"></div>
                                </p>
                            </div>

                            <div class="mt-4">
                                <button type="button"
                                    class="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                                    @click="closeModal">
                                    Close
                                </button>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
