<script setup lang="ts">
interface Props {
    disabled?: boolean;
    href?: string;
}

withDefaults(defineProps<Props>(), {
    disabled: false,
    href: undefined,
});
</script>

<template>
    <component
        :is="href ? 'a' : 'div'"
        class="inline-block py-2 px-4 bg-gray-200 mx-1 rounded-sm cursor-pointer transition duration-300 select-none"
        :class="[
            disabled && 'opacity-50 cursor-not-allowed',
            !disabled && 'hover:bg-gray-300 active:scale-80'
        ]"
    >
        <slot />
    </component>
</template>