<script setup lang="ts">
interface Props {
    disabled?: boolean;
    href?: string;
    type?: string;
}

withDefaults(defineProps<Props>(), {
    disabled: false,
    href: undefined,
    type: 'default'
});
</script>

<template>
    <component
        :is="href ? 'a' : 'div'"
        class="inline-block py-2 px-4 mx-1 rounded-sm cursor-pointer transition duration-300 select-none"
        :class="[
            disabled && 'opacity-50 cursor-not-allowed',
            !disabled && 'active:scale-80',
            type === 'default' && 'bg-gray-200 text-black hover:bg-gray-300',
            type === 'primary' && 'bg-blue-600 text-white hover:bg-blue-700',
            type === 'danger' && 'bg-red-700 text-white hover:bg-red-800',
            type === 'success' && 'bg-green-600 text-white hover:bg-green-700',
            type === 'warning' && 'bg-yellow-500 text-white hover:bg-yellow-600',
            type === 'info' && 'bg-teal-600 text-white hover:bg-teal-700',
            type === 'light' && 'bg-white text-black hover:bg-gray-100',
            type === 'dark' && 'bg-gray-800 text-white hover:bg-gray-900',
            type === 'link' && 'bg-transparent text-blue-600 hover:underline hover:bg-transparent',
            type === 'text' && 'bg-transparent text-black hover:underline hover:bg-transparent',
            type === 'ghost' && 'bg-transparent text-black hover:bg-gray-100',
            type === 'outline' && 'bg-transparent border border-black text-black hover:bg-gray-100',
        ]"
    >
        <slot />
    </component>
</template>