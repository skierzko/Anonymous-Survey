<script setup lang="ts">
import { ref, watch } from 'vue';
import { SurveyQuestion } from '../../models/SurveyQuestion';
import { Answer, SurveyResult } from '../../models/SurveyResult';

const props = defineProps<{
    question: SurveyQuestion,
    results: SurveyResult[],
    currentResultId: number | null,
}>()

const surveyResult = ref<SurveyResult|null>(null);
const answerResult = ref<Answer|null>(null);
watch(() => props.currentResultId, () => {
    const resultsFiltered = props.results.filter(item => {
        return item.id === props.currentResultId;
    });

    if (resultsFiltered.length === 0) {
        surveyResult.value = null;
        answerResult.value = null;
        return;
    }
    surveyResult.value = resultsFiltered.length ? resultsFiltered[0] : null;
    
    const answerFiltered = surveyResult.value?.results.answers.filter(item => {
        return item.uuid === props.question.uuid;
    })
    answerResult.value = answerFiltered?.length ? answerFiltered[0] : null;
})
</script>

<template>
    <div class="bg-gray-100 rounded-sm">
        <div class="bg-gray-200 p-2">
            {{ question.title }}
        </div>

        <div class="p-2">
            <div
                v-for="option in question.options"
                class="ml-2 px-2 mb-0.5"
                :class="[
                    answerResult?.value.includes(option.uuid) && 'font-bold bg-blue-600 text-white rounded-sm'
                ]"
            >
                {{ option.title }}
            </div>
        </div>
    </div>
</template>