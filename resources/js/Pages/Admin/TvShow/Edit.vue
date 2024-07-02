<script setup>
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import PageHeader from "@/Components/Admin/PageHeader.vue";

import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    tvShow: Object,
    errors: Object
});
const form = useForm({
    name: props.tvShow.name,
    poster_path: props.tvShow.poster_path
});
function SubmitTvShow(tvShow) {
    form.patch(route('admin.tv-show.update', tvShow));
}
</script>

<template>

    <Head title="Tv Show" />

    <AdminAuthenticatedLayout>
        <template #header>
            <PageHeader LinkText="Tv Index " HeadLink="Edit Tv" :route="route('admin.tv-show.index')" />
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="w-full flex mb-4 p-2 justify-end">
                </div>
                <section class="">
                    <form @submit.prevent="SubmitTvShow(props.tvShow)">
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div class="w-full">
                                    <div class="">
                                        <label for="first-name" class="block text-sm font-medium text-gray-700">Tv
                                            name</label>
                                        <input v-model="form.name" type="text" autocomplete="given-name"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                        <small class="text-red-600" v-if="errors.name">{{ errors.name }}</small>
                                    </div>
                                    <div class="mt-3">
                                        <label for="first-name" class="block text-sm font-medium text-gray-700">Tv
                                            Poster Path</label>
                                        <input v-model="form.poster_path" type="text" autocomplete="given-name"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                        <small class="text-red-600" v-if="errors.poster_path">{{ errors.poster_path
                                            }}</small>
                                    </div>
                                </div>
                                <div class="mt-5 text-center">
                                    <button
                                        class="px-4 py-2 bg-indigo-500 rounded hover:bg-indigo-700 text-white">Update
                                        Tv</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </AdminAuthenticatedLayout>
</template>
