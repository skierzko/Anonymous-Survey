<script setup lang="ts">
import { computed } from "vue";

interface Props {
    modelValue: string;
    id?: string;
    label?: string;
    placeholder?: string;
    error?: string;
    disabled?: boolean;
    cols?: number;
    rows?: number;
}

const props = withDefaults(defineProps<Props>(), {
    cols: 10,
    rows: 4,
});

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

        <textarea
            :id="inputId"
            type="text"
            :value="modelValue"
            :placeholder="placeholder"
            :disabled="disabled"
            :cols="cols"
            :rows="rows"
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
        ></textarea>

        <p v-if="error" class="text-xs text-red-500">
            {{ error }}
        </p>
    </div>
</template>
