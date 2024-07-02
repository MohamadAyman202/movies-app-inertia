<script setup>
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import { Head, Link, usePage, router } from '@inertiajs/vue3';
import Pagination from "@/Components/Admin/Pagination.vue";
import PageHeader from "@/Components/Admin/PageHeader.vue";
import MainModal from "@/Components/Admin/MainModal.vue";
import { ref, watch, defineProps } from 'vue';

const props = defineProps({
    tags: Object,
    filters: Object,
});
const page = usePage();
const flashMessage = ref(page.props.flash.success);
const showModal = ref(false);
const selectedTag = ref(null);
const search = ref(props.filters.search || '');
const prePage = ref(15);

watch(search, (value) => {
    router.get(route('admin.tags.index'), {
        search: value,
        prePage: prePage.value
    }, {
        preserveState: true,
        replace: true,
    })
});

function getTags() {
    router.get(router('admin.tags.index'), {
        prePage: prePage.value,
        search: search.value
    }, {
        preserveState: true,
        replace: true
    });
}

function closeAlert() {
    flashMessage.value = null;
}

function openModal(tag) {
    selectedTag.value = tag;
    showModal.value = true;
}

function closeModal() {
    showModal.value = false;
}

function deleteTag(slug) {
    router.delete(route("admin.tags.destroy", slug), {
        onSuccess: () => {
            flashMessage.value = "Tag deleted successfully.";
            closeModal();
        }
    });
}
</script>

<template>

    <Head title="Tags" />

    <AdminAuthenticatedLayout>
        <template #header>
            <PageHeader LinkText="Create Tag" HeadLink="Tags Index" :route="route('admin.tags.create')" />
        </template>

        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 w-full lg:px-8">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <section class="container mx-auto p-6 font-mono">
                        <div class="text-white mb-3 bg-green-600 w-full p-3 rounded-lg flex justify-between px-5"
                            v-if="flashMessage">
                            <small class="text-xl">{{ flashMessage }}</small>
                            <small @click="closeAlert" class="text-xl cursor-pointer">X</small>
                        </div>
                        <div class="w-full mb-8 overflow-hidden bg-white rounded-lg shadow-lg">
                            <div class="p-2 m-2">
                                <div class="flex justify-between">
                                    <div class="flex-1">
                                        <div class="relative">
                                            <div class="absolute flex items-center ml-2 h-full">
                                                <svg class="w-4 h-4 fill-current text-primary-gray-dark"
                                                    viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M15.8898 15.0493L11.8588 11.0182C11.7869 10.9463 11.6932 10.9088 11.5932 10.9088H11.2713C12.3431 9.74952 12.9994 8.20272 12.9994 6.49968C12.9994 2.90923 10.0901 0 6.49968 0C2.90923 0 0 2.90923 0 6.49968C0 10.0901 2.90923 12.9994 6.49968 12.9994C8.20272 12.9994 9.74952 12.3431 10.9088 11.2744V11.5932C10.9088 11.6932 10.9495 11.7869 11.0182 11.8588L15.0493 15.8898C15.1961 16.0367 15.4336 16.0367 15.5805 15.8898L15.8898 15.5805C16.0367 15.4336 16.0367 15.1961 15.8898 15.0493ZM6.49968 11.9994C3.45921 11.9994 0.999951 9.54016 0.999951 6.49968C0.999951 3.45921 3.45921 0.999951 6.49968 0.999951C9.54016 0.999951 11.9994 3.45921 11.9994 6.49968C11.9994 9.54016 9.54016 11.9994 6.49968 11.9994Z">
                                                    </path>
                                                </svg>
                                            </div>

                                            <input v-model="search" type="text" placeholder="Search by title"
                                                class="px-8 py-3 w-full md:w-2/6 rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 text-sm" />
                                        </div>
                                    </div>
                                    <div class="flex">
                                        <select v-model="prePage" @change="getTags"
                                            class="px-4 py-3 w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 text-sm">
                                            <option value="5">5 Per Page</option>
                                            <option value="10">10 Per Page</option>
                                            <option value="15">15 Per Page</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="w-full overflow-x-auto">
                                <table class="w-full">
                                    <thead>
                                        <tr
                                            class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b border-gray-600">
                                            <th class="px-4 py-3">Name</th>
                                            <th class="px-4 py-3">Slug</th>
                                            <th class="px-4 py-3 w-1/4">Manage</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white">
                                        <tr class="text-gray-700" v-for="(tag, i) in tags.data" :key="i">
                                            <td class="px-4 py-3 border">
                                                {{ tag.tag_name }}
                                            </td>
                                            <td class="px-4 py-3 text-ms font-semibold border">{{ tag.slug }}</td>

                                            <td class="px-4 py-3 text-sm border">
                                                <Link :href="route('admin.tags.edit', tag.slug)"
                                                    class=" cursor-pointer bg-green-500 px-5 py-2 rounded-md me-3 hover:bg-green-700 text-white">
                                                Edit</Link>
                                                <button
                                                    class=" cursor-pointer bg-red-500 px-5 py-2 rounded-md me-3 hover:bg-red-700 text-white"
                                                    @click="openModal(tag)">Delete</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <Pagination :links="tags.links" />
                            </div>
                        </div>
                        <MainModal :show="showModal" @close="closeModal">
                            <template #header>
                                <p class="text-red-500 font-semibold text-xl">Delete Tag</p>
                            </template>
                            <template #body>
                                <p class="text-3xl text-red-500 text-center">Are You Sure Delete Tag</p>
                            </template>
                            <template #footer>
                                <button @click="deleteTag(selectedTag.slug)"
                                    class="bg-red-500 text-white px-4 py-2 rounded">Delete</button>

                            </template>
                        </MainModal>
                    </section>
                </div>
            </div>
        </div>
    </AdminAuthenticatedLayout>
</template>
