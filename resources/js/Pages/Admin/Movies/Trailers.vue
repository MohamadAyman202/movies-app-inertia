<script setup>
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import PageHeader from "@/Components/Admin/PageHeader.vue";
import Multiselect from 'vue-multiselect';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    movie: Object,
    trailers: Object,
    errors: Object,
    tags: Array,
    casts: Array,
    movieCasts: Array,
    movieTags: Array,
});
const form = useForm({
    name: '',
    embed_html: '',
    tags: props.movieTags,
    casts: props.movieCasts,

});
function SubmitMovies(movie) {
    form.post(route('admin.trailers.store', movie), {
        onSuccess: () => form.reset(),
        preserveScroll: true,
        preserveState: true,
    });
}
</script>

<template>

    <Head title="Edit Movie" />

    <AdminAuthenticatedLayout>
        <template #header>
            <PageHeader LinkText="Movie Index " HeadLink="Add trailer" :route="route('admin.movies.index', movie)" />
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="w-full flex mb-4 p-2 justify-end px-4 py-5 bg-white sm:p-6" v-if="trailers.length > 0">
                    <div v-for="trailer in trailers" :key="trailer.id">

                        <Link class="mx-2 rounded bg-red-500 py-2 px-5 text-white hover:bg-red-700"
                            :href="route('admin.trailers.destroy', trailer)" method="delete" as="button">{{ trailer.name
                        }}
                        </Link>
                    </div>
                </div>
                <section class="">
                    <form @submit.prevent="SubmitMovies(movie)">
                        <div class="shadow sm:rounded-md">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div class="w-full">
                                    <div class="">
                                        <label for="first-name" class="block text-sm font-medium text-gray-700">
                                            Name</label>
                                        <input v-model="form.name" type="text" autocomplete="given-name"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                        <small class="text-red-600" v-if="errors.name">{{ errors.name }}</small>
                                    </div>
                                    <div class="mt-3">
                                        <label for="first-name" class="block text-sm font-medium text-gray-700">
                                            Embed</label>
                                        <textarea v-model="form.embed_html" type="number" min="0"
                                            autocomplete="given-name"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            rows="5"></textarea>
                                        <small class="text-red-600" v-if="errors.embed_html">{{ errors.embed_html
                                            }}</small>
                                    </div>
                                    <div class="mt-3">
                                        <label for="first-name" class="block text-sm font-medium text-gray-700">
                                            Casts</label>
                                        <multiselect v-model="form.casts" :options="casts" :multiple="true"
                                            :close-on-select="false" :clear-on-select="false" :preserve-search="true"
                                            placeholder="Add Tags" label="name" track-by="id">
                                        </multiselect>
                                        <small class="text-red-600" v-if="errors.lang">{{ errors.tags }}</small>
                                    </div>
                                    <div class="mt-3">
                                        <label for="first-name" class="block text-sm font-medium text-gray-700">
                                            Tags</label>
                                        <div>
                                            <multiselect v-model="form.tags" :options="tags" :multiple="true"
                                                :close-on-select="false" :clear-on-select="false"
                                                :preserve-search="true" placeholder="Add Tags" label="tag_name"
                                                track-by="id">
                                            </multiselect>
                                        </div>
                                        <small class="text-red-600" v-if="errors.format">{{ errors.format }}</small>
                                    </div>
                                </div>
                                <div class="mt-5 text-center">
                                    <button class="px-4 py-2 bg-indigo-500 rounded hover:bg-indigo-700 text-white">Add
                                        trailer</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </AdminAuthenticatedLayout>
</template>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
