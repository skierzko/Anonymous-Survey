<script setup lang="ts">
import { computed } from "vue";

interface Props {
    modelValue: number | null;
    label?: string;
    placeholder?: string;
    error?: string;
    disabled?: boolean;
    id?: string;
    min?: number;
    max?: number;
    step?: number;
}

const props = defineProps<Props>();
const emit = defineEmits<{
    (e: "update:modelValue", value: number | null): void;
}>();

const inputId = computed(
    () => props.id ?? `input-${Math.random().toString(36).slice(2)}`
);

function onInput(event: Event) {
    const target = event.target as HTMLInputElement;

    // pusty input → null
    if (target.value === "") {
        emit("update:modelValue", null);
        return;
    }

    const value = Number(target.value);

    // zabezpieczenie przed NaN
    if (!Number.isNaN(value)) {
        emit("update:modelValue", value);
    }
}
</script>

<template>
    <div class="flex flex-col gap-1">
        <label v-if="label" :for="inputId" class="text-sm font-medium text-gray-700">
            {{ label }}
        </label>

        <input
            type="number"
            inputmode="decimal"
            :id="inputId"
            :value="modelValue ?? ''"
            :placeholder="placeholder"
            :disabled="disabled"
            :min="min"
            :max="max"
            :step="step"
            class="
                w-full rounded-lg border px-3 py-2 text-sm bg-white
                focus:outline-none focus:ring-2 transition
                disabled:cursor-not-allowed disabled:bg-gray-100
            "
            :class="[
                error && 'border-red-500 focus:ring-red-300',
                !error && 'border-gray-300 focus:ring-blue-300 focus:border-blue-500'
            ]"
            @input="onInput"
        />

        <p v-if="error" class="text-xs text-red-500">
            {{ error }}
        </p>
    </div>
</template>
