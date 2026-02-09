<script setup lang="ts">
import { onMounted } from 'vue';
import { SURVEY_COMPONENT_MAP, SurveyComponentsKeys } from '../../../types/SurveyComponentMap';
import { SurveyQuestion } from '../../models/SurveyQuestion';
import { Trash2 } from 'lucide-vue-next';
import Separator from '../../../components/Separator.vue';
import Btn from '../../../components/Btn.vue';

const props = defineProps<{
    question: SurveyQuestion,
    index: number,
    isFirst: boolean,
    isLast: boolean,
}>()

const emit = defineEmits<{
    (e: 'addQuestion', index: number): void,
    (e: 'remove', index: number): void,
}>();

const setQuestionType = (type: SurveyComponentsKeys) => {
    props.question.type = type;

    if (type === 'open_question_survey') {
        props.question.minOptionsLimit = 1;
        props.question.maxOptionsLimit = 6000;
    }

    if (type === 'rating_scale_question_survey') {
        props.question.minOptionsLimit = 1;
        props.question.maxOptionsLimit = 10;
    }

    if (type === 'date_range_question_survey') {
        props.question.extraOptions = {
            viewSingleDate: false,
        };
    }
}

onMounted(() => {
    props.question.position = props.index;
})
</script>

<template>
    <Separator @click="emit('addQuestion', index)" label="Add query here" />
    <div class="flex gap-1 p-2 bg-gray-100 rounded-xs items-center">
        <div>Select type: </div>
        <template
            v-for="(surveyComponent, key) in SURVEY_COMPONENT_MAP"
            :key="key"
        >
            <Btn v-if="surveyComponent.visible" @click="setQuestionType(key)">
                {{ surveyComponent.name }}
            </Btn>
        </template>
        <Btn variant="danger" @click="emit('remove', index)">
            <Trash2 :size="20" :stroke-width="1.3" />
        </Btn>
    </div>
    <Separator v-if="isLast" @click="emit('addQuestion', index)" label="Add query here" />
</template>