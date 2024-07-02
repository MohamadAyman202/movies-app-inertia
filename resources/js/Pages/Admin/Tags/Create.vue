<script setup>
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import PageHeader from "@/Components/Admin/PageHeader.vue";


const form = useForm({
    tag_name: '',
});
function SubmitTag() {
    form.post(route('admin.tags.store'));
}
</script>

<template>

    <Head title="Tags" />

    <AdminAuthenticatedLayout>
        <template #header>
            <PageHeader LinkText="Tags Index" HeadLink="Create Tags" :route="route('admin.tags.index')" />
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="w-full flex mb-4 p-2 justify-end">

                </div>
                <section class="">
                    <form @submit.prevent="SubmitTag">
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div class="w-full">
                                    <div class="">
                                        <label for="first-name" class="block text-sm font-medium text-gray-700">Tag
                                            name</label>
                                        <input v-model="form.tag_name" type="text" autocomplete="given-name"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                    </div>
                                </div>
                                <div class="mt-5 text-center">
                                    <button class="px-4 py-2 rounded bg-indigo-500 hover:bg-indigo-700 text-white">Create
                                        Tag</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </AdminAuthenticatedLayout>
</template>
