<script setup lang="ts">
import { ref } from 'vue';
import { SurveyQuestion } from '../../models/SurveyQuestion';
import Pill from '../../../components/Pill.vue';
import InputTextarea from '../../../components/InputTextarea.vue';

const props = defineProps<{
    question: SurveyQuestion,
}>()

const text = ref<string>('');
</script>

<template>
    <div
        class="bg-gray-100 rounded-xs p-2"
        :class="[! question.visible && 'opacity-30']"
    >
        <Pill v-if="question.required" variant="danger" size="xs">
            Required
            {{ question.minOptionsLimit > 0 ? `(min ${question.minOptionsLimit})` : '' }}
            {{ question.maxOptionsLimit > 0 ? `(max ${question.maxOptionsLimit})` : '' }}
        </Pill>
        <div class="grid gap-2 p-2 select-none">
            {{ question.title }}
            <InputTextarea v-model="text" placeholder="Write your answer here..."></InputTextarea>
        </div>
    </div>
</template>