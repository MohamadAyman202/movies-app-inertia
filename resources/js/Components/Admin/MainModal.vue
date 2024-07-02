<script setup>
import { defineProps, defineEmits } from 'vue';

defineProps({
    show: {
        type: Boolean,
        default: false
    }
});

const emit = defineEmits(['close']);
</script>

<template>
    <Teleport to="body">
        <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-lg overflow-hidden w-500">
                <div class="p-4 border-b">
                    <slot name="header"></slot>
                </div>
                <div class="p-4">
                    <slot name="body"></slot>
                </div>
                <div class="p-4 border-t text-right">
                    <button @click="$emit('close')"
                        class=" bg-slate-500 text-white px-4 py-2 rounded me-3">Close</button>
                    <slot name="footer" />
                </div>
            </div>
        </div>
    </Teleport>
</template>

<style scoped>
.w-500 {
    width: 500px;
}
</style>
