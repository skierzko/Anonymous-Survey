<script setup lang="ts">
import { ref, inject, onMounted } from 'vue';
import type { SurveyQuestionHandle, SurveyQuestionRegistry } from '../../registers/SurveyQuestionRegistry';
import { SurveyQuestion } from '../../models/SurveyQuestion';
import Pill from '../../../components/Pill.vue';
import InputDate from '../../../components/InputDate.vue';

const error = ref<string>('');

const props = defineProps<{
    question: SurveyQuestion,
}>()

const dates = ref<{dateStart: string, dateEnd: string}>({
    dateStart: '',
    dateEnd: '',
});

const single = ref<boolean>(props.question.extraOptions.viewSingleDate ?? false);

/** Registry to parent */

const surveyQuestionRegistry = inject<SurveyQuestionRegistry>('survey-question-registry')
if (!surveyQuestionRegistry) {
  throw new Error('survey-question-registry not provided')
}

const valid = (): boolean => {
    error.value = '';

    const startDate: Date | null = dates.value.dateStart ? new Date(dates.value.dateStart) : null;
    const endDate: Date | null = dates.value.dateEnd ? new Date(dates.value.dateEnd) : null;
    const isEmpty = single.value ? startDate === null : startDate === null && endDate === null;
    const startDateAfterEndDate = !single.value && startDate && endDate && startDate > endDate;

    if (isEmpty) {
        if (props.question.required) {
            error.value = 'This question is required';
        }
    } else if (startDateAfterEndDate) {
        error.value = 'Start date must be before end date';
    } else if (startDate === null && endDate) {
        error.value = 'Start date is required if end date is provided';
    } else if (single.value === false && endDate === null && startDate) {
        error.value = 'End date is required if start date is provided';
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
        <Pill v-if="question.required" variant="danger" size="xs">
            Required
        </Pill>
        <div class="p-2 select-none">
            {{ question.title }}
        </div>
        <div class="sm:flex md:grid md:grid-cols-3 gap-2 p-2 select-none">
            <InputDate v-model="dates.dateStart" :label="single ? 'Date' : 'From'" />
            <InputDate v-if="single === false" v-model="dates.dateEnd" label="To" />
        </div>
        <div v-if="error" class="text-red-700 col-span-2 text-sm ml-6">{{ error }}</div>
    </div>
</template>