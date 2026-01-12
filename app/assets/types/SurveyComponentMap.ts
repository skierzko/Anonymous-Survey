import type { Component } from 'vue'
import RadioQuestionSurvey from '../pages/surveyOptions/radioQuestion/RadioQuestionSurvey.vue';
import ChangeQueryType from '../pages/surveyOptions/changeQueryType/ChangeQueryType.vue';
import CheckboxQuestionSurvey from '../pages/surveyOptions/checkboxQuestion/CheckboxQuestionSurvey.vue';

interface Details {
    c: Component,
    name: string,
    visible: boolean,
}

export const SURVEY_COMPONENT_MAP: Record<string, Details> = {
    change_query_type: {
        c: ChangeQueryType,
        name: 'Change query type',
        visible: false,
    },
    radio_question_survey: {
        c: RadioQuestionSurvey,
        name: 'Single choice',
        visible: true,
    },
    checkbox_question_survey: {
        c: CheckboxQuestionSurvey,
        name: 'Multi choice',
        visible: true,
    },
};