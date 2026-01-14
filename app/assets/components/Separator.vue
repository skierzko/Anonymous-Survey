<script setup lang="ts">

interface Props {
    label?: string|null,
    fullVisibility?: boolean,
    clickable?: boolean
}

withDefaults(defineProps<Props>(), {
    label: 'Add option here',
    fullVisibility: false,
    clickable: true,
});
</script>

<template>
    <div
        class="flex py-2 justify-center items-center hover:opacity-100"
        :class="[
            clickable && 'cursor-pointer',
            fullVisibility && 'opacity-100',
            ! fullVisibility && 'opacity-20',
        ]"
    >
        <div class="h-[1px] flex-1 border-b"></div>
        <span class="px-2 text-center uppercase text-xs text-gray-500 bg-gray-100">
            <slot>{{ label }}</slot>
        </span>
        <div class="h-[1px] flex-1 border-b"></div>
    </div>
</template>