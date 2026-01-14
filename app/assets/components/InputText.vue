<script setup lang="ts">
import { computed } from "vue";

interface Props {
    modelValue: string;
    label?: string;
    placeholder?: string;
    error?: string;
    disabled?: boolean;
    id?: string;
}

const props = defineProps<Props>();
const emit = defineEmits<{
    (e: "update:modelValue", value: string): void;
}>();

const inputId = computed(() => props.id ?? `input-${Math.random().toString(36).slice(2)}`);

function onInput(event: Event) {
    const target = event.target as HTMLInputElement;
    emit("update:modelValue", target.value);
}
</script>

<template>
    <div class="flex flex-col gap-1">
        <label
            v-if="label"
            :for="inputId"
            class="text-sm font-medium text-gray-700"
        >
            {{ label }}
        </label>

        <input
            :id="inputId"
            type="text"
            :value="modelValue"
            :placeholder="placeholder"
            :disabled="disabled"
            @input="onInput"
            class="
                w-full rounded-lg border px-3 py-2 text-sm bg-white
                focus:outline-none focus:ring-2 transition
                disabled:cursor-not-allowed disabled:bg-gray-100
            "
            :class="[
                error && 'border-red-500 focus:ring-red-300',
                ! error && 'border-gray-300 focus:ring-blue-300 focus:border-blue-500'
            ]"
        />

        <p v-if="error" class="text-xs text-red-500">
            {{ error }}
        </p>
    </div>
</template>
