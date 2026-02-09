<script setup lang="ts">
import { ref, inject, onMounted } from 'vue';
import type { SurveyQuestionHandle, SurveyQuestionRegistry } from '../../registers/SurveyQuestionRegistry';
import { SurveyQuestion } from '../../models/SurveyQuestion';
import Pill from '../../../components/Pill.vue';
import InputTextarea from '../../../components/InputTextarea.vue';

const props = defineProps<{
    question: SurveyQuestion,
}>()

const text = ref<string>('');
const error = ref<string>('');

/** Registry to parent */

const surveyQuestionRegistry = inject<SurveyQuestionRegistry>('survey-question-registry')
if (!surveyQuestionRegistry) {
  throw new Error('survey-question-registry not provided')
}

const valid = (): boolean => {
    error.value = '';
    
    const isEmpty = text.value.trim() === '';
    const lessThanMinLimit = text.value.length < props.question.minOptionsLimit;
    const moreThanMaxLimit = text.value.length > props.question.maxOptionsLimit;
    const overTheLimits = lessThanMinLimit || moreThanMaxLimit;

    if (isEmpty) {
        if (props.question.required && overTheLimits) {
           error.value = 'This question is required';
        }
    } else if (lessThanMinLimit) {
            error.value = `Answer must be at least ${props.question.minOptionsLimit} characters long`;
    } else if (moreThanMaxLimit) {
            error.value = `Answer must be at most ${props.question.maxOptionsLimit} characters long`;
    }

    return error.value === '';
}
const surveyQuestionHandle: SurveyQuestionHandle = { valid }

onMounted(() => {
    surveyQuestionRegistry.register(surveyQuestionHandle)
})
</script>

<template>
    <div
        class="bg-gray-100 rounded-xs p-2"
        :class="[
            ! question.visible && 'opacity-30',
            error && 'border border-red-700'
        ]"
    >
        <Pill v-if="question.required" variant="danger" size="xs">Required</Pill>
        <Pill variant="warning" size="xs">
            {{ question.minOptionsLimit > 0 ? `(min ${question.minOptionsLimit})` : '' }}
            {{ question.maxOptionsLimit > 0 ? `(max ${question.maxOptionsLimit})` : '' }}
        </Pill>
        <div class="grid gap-2 p-2 select-none">
            {{ question.title }}
            <InputTextarea v-model="text" placeholder="Write your answer here..."></InputTextarea>
        </div>
        <div v-if="error" class="text-red-700 col-span-2 text-sm ml-6">
            {{ error }}
        </div>
    </div>
</template>