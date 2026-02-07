<script setup lang="ts">
import { computed } from "vue";

type Variant = 'default' | 'primary' | 'danger' | 'success' | 'warning' | 'info' | 'light' | 'dark' | 'link' | 'text' | 'ghost' | 'outline';
type Size = 'xs' | 'sm' | 'md' | 'lg';

interface Props {
    variant?: Variant;
    size?: Size;
}

const props = withDefaults(defineProps<Props>(), {
    variant: 'default',
    size: 'md',
});

const baseClasses = "flex gap-2 p-4 items-center rounded-xs font-medium select-none";

const variantClasses: Record<Variant, string> = {
    default: "bg-gray-100 text-gray-700",
    primary: "bg-blue-100 text-blue-700",
    danger: "bg-red-100 text-red-700",
    success: "bg-green-100 text-green-700",
    warning: "bg-yellow-100 text-yellow-800",
    info: "bg-cyan-100 text-cyan-700",
    light: "bg-gray-50 text-gray-500",
    dark: "bg-gray-800 text-white",
    link: "bg-transparent text-blue-600 underline",
    text: "bg-transparent text-gray-700",
    ghost: "bg-transparent text-gray-700 hover:bg-gray-100",
    outline: "bg-transparent text-gray-700 border border-gray-300",
};

const sizeClasses: Record<Size, string> = {
    xs: "text-xs",
    sm: "text-xs",
    md: "text-sm",
    lg: "text-sm",
};

const classes = computed(() => [
    baseClasses,
    variantClasses[props.variant],
    sizeClasses[props.size],
]);
</script>

<template>
    <div :class="classes">
        <slot name="icon" />
        <slot />
    </div>
</template>