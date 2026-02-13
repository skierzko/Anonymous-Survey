<script setup lang="ts">
import { ref, inject, onMounted } from 'vue';
import type { SurveyQuestionShowHandle, SurveyQuestionShowRegistry } from '../../registers/SurveyQuestionShowRegistry';
import { SurveyQuestion } from '../../models/SurveyQuestion';
import Pill from '../../../components/Pill.vue';
import InputTextarea from '../../../components/InputTextarea.vue';

const props = defineProps<{
    question: SurveyQuestion,
}>()

const text = ref<string>('');
const error = ref<string>('');

/** Registry to parent */

const surveyQuestionRegistry = inject<SurveyQuestionShowRegistry>('survey-question-show-registry')
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

const getAnswer = () => {
    return {
        uuid: props.question.uuid,
        value: text.value,
    };
}

const surveyQuestionHandle: SurveyQuestionShowHandle = { valid, getAnswer }

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
            <InputTextarea v-model="text" :maxlength="question.maxOptionsLimit" placeholder="Write your answer here..."></InputTextarea>
            <Pill>Signs: {{ text.length }}</Pill>
        </div>
        <div v-if="error" class="text-red-700 col-span-2 text-sm ml-6">
            {{ error }}
        </div>
    </div>
</template>