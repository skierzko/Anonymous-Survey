<script setup lang="ts">
import { computed } from "vue";

type Variant = "default" | "primary" | "success" | "warning" | "danger";
type Size = "sm" | "md" | "lg";

interface Props {
    variant?: Variant;
    size?: Size;
}

const props = withDefaults(defineProps<Props>(), {
    variant: "default",
    size: "md",
});

const baseClasses = "inline-flex items-center rounded-xl font-medium select-none";

const variantClasses: Record<Variant, string> = {
    default: "bg-gray-100 text-gray-700",
    primary: "bg-blue-100 text-blue-700",
    success: "bg-green-100 text-green-700",
    warning: "bg-yellow-100 text-yellow-800",
    danger: "bg-red-100 text-red-700",
};

const sizeClasses: Record<Size, string> = {
    sm: "text-xs px-2 py-0.5",
    md: "text-sm px-3 py-0.5",
    lg: "text-sm px-4 py-0.5",
};

const classes = computed(() => [
    baseClasses,
    variantClasses[props.variant],
    sizeClasses[props.size],
]);
</script>

<template>
    <span :class="classes">
        <slot />
    </span>
</template>
