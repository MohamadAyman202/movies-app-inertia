<script setup>
import { ref } from 'vue';
import Navbar from '@/Components/Frontend/Navbar.vue'
import Footer from '@/Components/Frontend/Footer.vue'
import { Link } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">

        <Navbar />

        <!-- Page Content -->
        <main>
            <slot />
        </main>
    </div>
    <Footer />
</template>
