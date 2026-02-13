<script setup lang="ts">
import { ref, watch } from 'vue';
import { SurveyQuestion } from '../../models/SurveyQuestion';
import { Answer, SurveyResult } from '../../models/SurveyResult';
import Pill from '../../../components/Pill.vue';

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
            <template
                v-for="(option, index) in question.options"
                :key="option.id"
            >
                <div
                    class="w-[calc(100% - 10px)] sm:grid gap-2"
                    :style="`grid-template-columns: repeat(${question.maxOptionsLimit - question.minOptionsLimit + 2}, minmax(0, 1fr))`"
                >
                    <div>
                        <Pill variant="light" class="w-full! whitespace-nowrap py-2!">
                            {{ option.title }}
                        </Pill>
                    </div>
                    
                    <template v-for="(n, index) in Array.from({ length: question.maxOptionsLimit - question.minOptionsLimit + 1 }, (_, i) => i + question.minOptionsLimit)">
                        <div>
                            <div
                                class="text-center"
                                :class="[
                                    answerResult?.value[option.uuid] === n && 'font-bold bg-blue-600 text-white rounded-sm'
                                ]"
                            >
                                {{ n }}
                            </div>
                        </div>
                    </template>
                </div>
            </template>
        </div>
    </div>
</template>