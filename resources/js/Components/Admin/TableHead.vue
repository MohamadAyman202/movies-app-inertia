<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    class: {
        type: String,
        required:false
    }
});
</script>

<template>
    <th :class="['px-4', 'py-3', props.class]">
        <slot />
    </th>
</template>
