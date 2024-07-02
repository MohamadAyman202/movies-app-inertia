<script setup>
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import PageHeader from "@/Components/Admin/PageHeader.vue";


const props = defineProps({
    genre: Object
});
const form = useForm({
    title: props.genre.title,
});
function SubmitGenre(genre) {
    form.patch(route('admin.genres.update', genre));
}
</script>

<template>

    <Head title="Edit Genre" />

    <AdminAuthenticatedLayout>
        <template #header>
            <PageHeader LinkText="Genre Index" HeadLink="Edit Genre" :route="route('admin.genres.index')" />

        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="w-full flex mb-4 p-2 justify-end">

                </div>
                <section class="">
                    <form @submit.prevent="SubmitGenre(props.genre)">
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div class="w-full">
                                    <div class="">
                                        <label for="first-name" class="block text-sm font-medium text-gray-700">Title
                                            Genre</label>
                                        <input v-model="form.title" type="text" autocomplete="given-name"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                    </div>
                                </div>
                                <div class="mt-5 text-center">
                                    <button class="px-4 rounded py-2 bg-indigo-500 hover:bg-indigo-700 text-white">Update
                                        Genre</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </AdminAuthenticatedLayout>
</template>
