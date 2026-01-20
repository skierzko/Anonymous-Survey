<script setup lang="ts">
import { computed } from "vue";

interface Props {
    modelValue: boolean;
    id?: string;
    label?: string;
    disabled?: boolean;
}

const props = defineProps<Props>();
const emit = defineEmits<{
    (e: "update:modelValue", value: boolean): void;
}>();

const switchId = computed(
    () => props.id ?? `switch-${Math.random().toString(36).slice(2)}`
);

function toggle() {
    if (props.disabled) return;
    emit("update:modelValue", !props.modelValue);
}
</script>

<template>
    <div class="flex items-center gap-3">
        <button
            type="button"
            role="switch"
            :aria-checked="modelValue"
            :id="switchId"
            @click="toggle"
            :disabled="disabled"
            class="
                relative inline-flex h-6 w-11 items-center rounded-full
                transition-colors duration-200 cursor-pointer
                focus:outline-none focus:ring-2 focus:ring-blue-300
                disabled:opacity-50 disabled:cursor-not-allowed
            "
            :class="modelValue ? 'bg-blue-600' : 'bg-gray-300'"
        >
        <span
            class="
            inline-block h-5 w-5 transform rounded-full bg-white
            transition-transform duration-200
            "
            :class="[
                modelValue && 'translate-x-5',
                ! modelValue && 'translate-x-1'
            ]"
        />
        </button>

        <label
            :for="switchId"
            class="text-sm text-gray-700 cursor-pointer select-none"
            @click.prevent="toggle"
        >
            <slot>{{ label }}</slot>
        </label>
    </div>
</template>
