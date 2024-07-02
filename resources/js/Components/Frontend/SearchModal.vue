<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from "@headlessui/vue";

import axios from "axios";
import {debounce} from "lodash";

const isOpen = ref(false);
const isLoding = ref(false);
const results = ref([]);

const search = debounce(async (term) => {
    if (term) {

    isLoding.value = true;
    let response = await axios.get('/api/search', {params:{search:term}});
    results.value = response.data;
    isLoding.value = false;
} else {
    results.value = []
}
}, 250);




function closeModal() {
    isOpen.value = false;
    isLoding.value = false;
}
function openModal() {
    isOpen.value = true;
}
</script>
<template>

    <div class="relative pointer-events-auto">
        <button
            type="button"
            wire:click="showSearch"
            v-bind="$attrs"
            @click="openModal"
            class="w-52 md:w-72 flex items-center text-sm leading-6 text-gray-400 rounded-md ring-1 ring-gray-900/10 shadow-sm py-1.5 pl-2 pr-3 hover:ring-gray-300 dark:bg-gray-700 dark:highlight-white/5 dark:hover:bg-gray-900"
        >
            <svg
                width="24"
                height="24"
                fill="none"
                aria-hidden="true"
                class="mr-3 flex-none"
            >
                <path
                    d="m19 19-3.5-3.5"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                ></path>
                <circle
                    cx="11"
                    cy="11"
                    r="6"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                ></circle></svg
            >Quick search...<span
                class="ml-auto pl-3 flex-none text-xs font-semibold"
                >⌘K</span
            >
        </button>
    </div>
    <TransitionRoot appear :show="isOpen" as="template">
        <Dialog as="div" @close="closeModal" class="relative z-10">
            <TransitionChild
                as="template"
                enter="duration-300 ease-out"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="duration-200 ease-in"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div class="fixed inset-0 bg-black/25" />
            </TransitionChild>

            <div class="fixed inset-0 overflow-y-auto">
                <div
                    class="fixed inset-0 z-50 flex justify-center items-start mt-20"
                >
                    <TransitionChild
                        as="template"
                        enter="duration-300 ease-out"
                        enter-from="opacity-0 scale-95"
                        enter-to="opacity-100 scale-100"
                        leave="duration-200 ease-in"
                        leave-from="opacity-100 scale-100"
                        leave-to="opacity-0 scale-95"
                    >
                        <DialogPanel
                            class="w-full max-w-xl transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all"
                        >
                            <DialogTitle
                                as="h3"
                                class="text-lg font-medium leading-6 text-gray-900"
                            >
                                Payment successful
                            </DialogTitle>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">

                                <div class="flex flex-col">
                                    <input @input="(e) => search(e.target.value)" type="text" class="rounded w-full dark:bg-gray-700"
                                        placeholder="Search Movie">
                                    <div v-if="isLoding" class="border border-blue-300 shadow rounded-md p-4 w-full mx-auto mt-4">
                                        <div class="animate-pulse flex space-x-4">
                                            <div class="rounded-full bg-gray-200 h-10 w-10"></div>
                                            <div class="flex-1 space-y-6 py-1">
                                                <div class="h-2 bg-gray-200 rounded"></div>
                                                <div class="space-y-3">
                                                    <div class="grid grid-cols-3 gap-4">
                                                        <div class="h-2 bg-gray-200 rounded col-span-2"></div>
                                                        <div class="h-2 bg-gray-200 rounded col-span-1"></div>
                                                    </div>
                                                    <div class="h-2 bg-gray-200 rounded"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="" v-if="results.length > 0 && !isLoding">
                                        <div v-for="result in results" :key="result.id"
                                        class="p-2 m-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-500 dark:hover:bg-gray-700 cursor-pointer rounded-md">
                                                    <Link :href="result.url">
                                                            {{result.title}}
                                                        </Link>
                                                        </div>
                                                </div>
                                                <div v-if="results.length === 0" class="p-10 text-lg text-center text-gray-400">No Results</div>
                                </div>

                                </p>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
