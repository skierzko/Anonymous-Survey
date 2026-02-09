<script setup lang="ts">
import { ref, inject, onMounted } from 'vue';
import type { SurveyQuestionHandle, SurveyQuestionRegistry } from '../../registers/SurveyQuestionRegistry';
import { SurveyQuestion } from '../../models/SurveyQuestion';
import Pill from '../../../components/Pill.vue';

const currentOption = ref(null);
const error = ref<string>('');

const props = defineProps<{
    question: SurveyQuestion,
}>()

/** Registry to parent */

const surveyQuestionRegistry = inject<SurveyQuestionRegistry>('survey-question-registry')
if (!surveyQuestionRegistry) {
  throw new Error('survey-question-registry not provided')
}

const valid = (): boolean => {
    error.value = '';
    const isAnyChecked = currentOption.value === null && props.question.required;
    error.value = isAnyChecked ? 'This question is required' : '';
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
        <div class="grid gap-2 p-2 select-none">
            {{ question.title }}
            <div v-for="(option, index) in question.options" :key="option.id" class="ml-6">
                <input
                    type="radio"
                    class="cursor-pointer"
                    :id="option.uuid"
                    :name="question.uuid"
                    :value="option.uuid"
                    v-model="currentOption"
                    /> <label :for="option.uuid" class="ml-2 cursor-pointer" >{{ option.title }}</label>
            </div>
        </div>
        <div v-if="error" class="text-red-700 col-span-2 text-sm ml-6">This question is required</div>
    </div>
</template>