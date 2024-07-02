<script setup>
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import { Head, Link, usePage, router, useForm } from '@inertiajs/vue3';
import Pagination from "@/Components/Admin/Pagination.vue";
import PageHeader from "@/Components/Admin/PageHeader.vue";
import MainModal from "@/Components/Admin/MainModal.vue";
import Table from "@/Components/Admin/Table.vue";
import TableHead from "@/Components/Admin/TableHead.vue";
import TableRow from "@/Components/Admin/TableRow.vue";
import TableData from "@/Components/Admin/TableData.vue";
import { Inertia } from '@inertiajs/inertia';
import { ref, watch, defineProps } from 'vue';
import ButtonGenerate from '@/Components/Admin/ButtonGenerate.vue';

const props = defineProps({
    episodes: Object,
    tvShow: Object,
    season: Object,
    filters: Object,
});
const page = usePage();
const flashMessageSuccess = ref('');
const flashMessageError = ref('');
const showModal = ref(false);
const episode_number = ref("");
const selectedEpisode = ref(null);
const search = ref(props.filters.search || '');
const prePage = ref(5);

watch(search, (value) => {
    router.get(route('admin.tv-show.index'), {
        search: value,
        prePage: prePage.value
    }, {
        preserveState: true,
        replace: true,
    })
});

function getEpisode() {
    router.get(router('admin.tv-show.index'), {
        prePage: prePage.value,
        search: search.value
    }, {
        preserveState: true,
        replace: true
    });
}

function closeAlert() {
    flashMessageSuccess.value = null;
    flashMessageError.value = null;

}

function openModal(episode) {
    selectedEpisode.value = episode.id;
    showModal.value = true;
}

function closeModal() {
    showModal.value = false;
}

function deleteEpisode(episodeId) {
    router.delete(route("admin.episodes.destroy", episodeId), {
        onSuccess: () => {
            flashMessageSuccess.value = "Successfully deleted episode.";
            closeModal();
        }
    });
}


function generateEpisode() {
    router.post(route("admin.episodes.store", [props.tvShow.id, props.season.id]), {
        episode_number: episode_number.value,
    }, {
        onFinish: () => {
            episode_number.value = '';
            flashMessageSuccess.value = page.props.flash.success
            flashMessageError.value = page.props.flash.error
        },
    });
}
</script>

<template>

    <Head title="Episode" />

    <AdminAuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Episodes Index</h2>
            </div>
        </template>

        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 w-full lg:px-8">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <section class="container mx-auto p-6 font-mono">
                        <div class="flex justify-end items-center">
                            <div class="flex items-center mb-5 bg-white p-3">

                                <label for="" class="form-label me-3">Episode Id</label>
                                <input type="text" name="" v-model="episode_number" id=""
                                    class="form-control rounded-lg" placeholder="Episode Tmdb Id"
                                    aria-describedby="helpId" />
                                <small id="helpId" v-if="props.errors" class="text-red-500 block">Help
                                    text</small>
                                <button @click="generateEpisode"
                                    class="px-5 ms-3 py-2 bg-green-600 hover:bg-green text-white rounded-lg flex justify-center items-center">
                                    Generate
                                </button>
                            </div>

                        </div>
                        <div class="text-white mb-3 bg-green-600 w-full p-3 rounded-lg flex justify-between px-5"
                            v-if="flashMessageSuccess">
                            <small class="text-xl">{{ flashMessageSuccess }}</small>
                            <small @click="closeAlert" class="text-xl cursor-pointer">X</small>
                        </div>
                        <div class="text-white mb-3 bg-red-600 w-full p-3 rounded-lg flex justify-between px-5"
                            v-if="flashMessageError">
                            <small class="text-xl">{{ flashMessageError }}</small>
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
                                        <select v-model="prePage" @change="getEpisode"
                                            class="px-4 py-3 w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 text-sm">
                                            <option value="5">5 Per Page</option>
                                            <option value="10">10 Per Page</option>
                                            <option value="15">15 Per Page</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="w-full overflow-x-auto ">
                                <Table>
                                    <template #tableHead>
                                        <TableHead>Name</TableHead>
                                        <TableHead>Slug</TableHead>
                                        <TableHead>Episode Number</TableHead>
                                        <TableHead>Is Public</TableHead>
                                        <TableHead>Manage</TableHead>
                                    </template>
                                    <TableRow v-for="(episode, i) in episodes.data" :key="i">
                                        <TableData>{{ episode.name }}</TableData>
                                        <TableData>{{ episode.slug }}</TableData>
                                        <TableData>{{ episode.episode_number }}</TableData>
                                        <TableData>
                                            <span class=" rounded text-sm bg-green-600 text-white py-2 px-5"
                                                v-if="episode.is_public">
                                                Published
                                            </span>
                                            <span class=" rounded bg-red-600 text-sm text-white py-2 px-5"
                                                v-else="episode.is_public">
                                                Unpublished
                                            </span>
                                        </TableData>
                                        <TableData>
                                            <Link
                                                :href="route('admin.episodes.edit', [tvShow.id, season.id, episode.id])"
                                                class="cursor-pointer bg-green-500 px-5 py-2 rounded-md me-3 hover:bg-green-700 text-white">
                                            Edit</Link>
                                            <button
                                                class="cursor-pointer bg-red-500 px-5 py-2 rounded-md me-3 hover:bg-red-700 text-white"
                                                @click="openModal(episode)">Delete</button>
                                        </TableData>
                                    </TableRow>
                                </Table>
                                <Pagination :links="episodes.links" />
                            </div>
                        </div>
                        <MainModal :show="showModal" @close="closeModal">
                            <template #header>
                                <p class="text-red-500 font-semibold text-xl">Delete Episode</p>
                            </template>
                            <template #body>
                                <p class="text-3xl text-red-500 text-center">Are You Sure Delete Episode</p>
                            </template>
                            <template #footer>
                                <button @click="deleteEpisode(selectedEpisode)"
                                    class="bg-red-500 text-white px-4 py-2 rounded">Delete</button>

                            </template>
                        </MainModal>
                    </section>
                </div>
            </div>
        </div>
    </AdminAuthenticatedLayout>
</template>
