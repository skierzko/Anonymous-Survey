<script setup lang="ts">
defineProps<{
    offline: boolean,
}>();
</script>

<template>
    <div
        class="w-[14px] h-[14px] inline-block flex-none rounded-full  p-1"
        :class="[
            offline && 'bg-gray-400/30',
            ! offline && 'bg-emerald-500/30',
        ]"
    >
        <div
            class="size-1.5 rounded-full "
            :class="[
                offline && 'bg-gray-400',
                ! offline && 'bg-emerald-500',
            ]"
        ></div>
    </div>
</template>