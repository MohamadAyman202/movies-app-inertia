<script setup>
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import PageHeader from "@/Components/Admin/PageHeader.vue";
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const page = usePage();
const flashMessage = ref(page.props.flash.success);
const form = useForm({
    tv_tmdb_id: '',
});

function SubmitTvShow() {
    form.post(route('admin.tv-show.store'));
}

function closeAlert() {
    flashMessage.value = null;
}
</script>

<template>

    <Head title="Casts" />
    <AdminAuthenticatedLayout>
        <template #header>
            <PageHeader LinkText="Tv Show Index " HeadLink="Create Tv" :route="route('admin.tv-show.index')" />
        </template>
        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="text-white mb-3 bg-red-600 w-full p-3 rounded-lg flex justify-between px-5"
                    v-if="flashMessage">
                    {{ flashMessage }}
                    <small class="text-xl">{{ flashMessage }}</small>
                    <small @click="closeAlert" class="text-xl cursor-pointer">X</small>
                </div>
                <div class="w-full flex mb-4 p-2 justify-end">

                </div>
                <section class="">
                    <form @submit.prevent="SubmitTvShow">
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div class="w-full">
                                    <div class="">
                                        <label for="first-name" class="block text-sm font-medium text-gray-700">Tv
                                            Tmdb Id</label>
                                        <input v-model="form.tv_tmdb_id" type="text" autocomplete="given-name"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                    </div>
                                </div>
                                <div class="mt-5 text-center">
                                    <button
                                        class="px-4 rounded py-2 bg-indigo-500 hover:bg-indigo-700 text-white">Generate</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </AdminAuthenticatedLayout>
</template>
