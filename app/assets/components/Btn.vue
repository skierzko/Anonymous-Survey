<script setup lang="ts">
type btnType = 'default' | 'primary' | 'danger' | 'success' | 'warning' | 'info' | 'light' | 'dark' | 'link' | 'text' | 'ghost' | 'outline';

interface Props {
    disabled?: boolean;
    href?: string;
    variant?: btnType;
}

withDefaults(defineProps<Props>(), {
    disabled: false,
    href: undefined,
    variant: 'default'
});
</script>

<template>
    <component
        :is="href ? 'a' : 'div'"
        class="inline-block py-2 px-4 mx-0 rounded-sm cursor-pointer transition duration-300 select-none align-top"
        :class="[
            disabled && 'opacity-50 cursor-not-allowed',
            !disabled && 'active:scale-80',
            variant === 'default' && 'bg-gray-200 text-black hover:bg-gray-300',
            variant === 'primary' && 'bg-blue-600 text-white hover:bg-blue-700',
            variant === 'danger' && 'bg-red-700 text-white hover:bg-red-800',
            variant === 'success' && 'bg-green-600 text-white hover:bg-green-700',
            variant === 'warning' && 'bg-yellow-500 text-white hover:bg-yellow-600',
            variant === 'info' && 'bg-teal-600 text-white hover:bg-teal-700',
            variant === 'light' && 'bg-white text-black hover:bg-gray-100',
            variant === 'dark' && 'bg-gray-800 text-white hover:bg-gray-900',
            variant === 'link' && 'bg-transparent text-blue-600 hover:underline hover:bg-transparent',
            variant === 'text' && 'bg-transparent text-black hover:underline hover:bg-transparent',
            variant === 'ghost' && 'bg-transparent text-black hover:bg-gray-100',
            variant === 'outline' && 'bg-transparent border border-black text-black hover:bg-gray-100',
        ]"
    >
        <slot />
    </component>
</template>