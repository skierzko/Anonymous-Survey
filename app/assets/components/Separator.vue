<script setup lang="ts">

interface Props {
    label?: string|null,
}

withDefaults(defineProps<Props>(), {
    label: 'Add option here'
});
</script>

<template>
    <div class="py-2 opacity-20 flex justify-center items-center hover:opacity-100 cursor-pointer">
        <div class="h-[1px] flex-1 border-b"></div>
        <span class="px-2 text-center uppercase text-xs text-gray-500 bg-gray-100">
            <slot>{{ label }}</slot>
        </span>
        <div class="h-[1px] flex-1 border-b"></div>
    </div>
</template>