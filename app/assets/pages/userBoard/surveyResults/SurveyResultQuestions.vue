<script setup lang="ts">
import { ref } from 'vue';
import { SURVEY_COMPONENT_MAP } from '../../../types/SurveyComponentMap';
import { Survey } from '../../models/Survey';
import SurveyResultsList from './SurveyResultsList.vue';
import Pill from '../../../components/Pill.vue';
import NotifyBar from '../../../components/NotifyBar.vue';
import Separator from '../../../components/Separator.vue';

const props = defineProps<{ survey: Survey }>();

const currentResultId = ref< number|null >(null);

const setResultId = (resultId: number | null) => {
    currentResultId.value = resultId;
}
</script>

<template>
    <div class="mb-4">
        <Pill>
            Total responses: {{ survey.results.length }}
        </Pill>
    </div>
    <div>
        <SurveyResultsList
            :results="props.survey.results"
            :current-result-id="currentResultId"
            @set-result-id="setResultId"
        />

        <Separator
            class="mb-6"
            :clickable="false"
            fullVisibility
        >
            Results for: {{ currentResultId ? currentResultId : 'all' }}
        </Separator>

        <template v-for="(surveyQuestion, index) in survey.questions" :key="'query-' + index">
            <component
                v-if="SURVEY_COMPONENT_MAP[surveyQuestion.type].r !== null && surveyQuestion.visible && surveyQuestion.draft === false"
                class="mb-4"
                :is="SURVEY_COMPONENT_MAP[surveyQuestion.type].r"
                :question="surveyQuestion"
                :results="props.survey.results"
                :current-result-id="currentResultId"
            />
            <NotifyBar v-else-if="surveyQuestion.visible && surveyQuestion.draft === false">
                Commponent not found for question type: {{ surveyQuestion.type }}
            </NotifyBar>
        </template>
    </div>
</template>