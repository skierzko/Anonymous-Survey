import type { Component } from 'vue'
import RadioQuestionSurvey from '../pages/surveyOptions/radioQuestion/RadioQuestion.vue';
import ChangeQueryType from '../pages/surveyOptions/changeQueryType/ChangeQueryType.vue';
import CheckboxQuestionSurvey from '../pages/surveyOptions/checkboxQuestion/CheckboxQuestion.vue';
import OpenQuestion from '../pages/surveyOptions/openQuestion/OpenQuestion.vue';
import RatingScaleQuestion from '../pages/surveyOptions/ratingScaleQuestion/RatingScaleQuestion.vue';
import DateRangeQuestion from '../pages/surveyOptions/dateRangeQuestion/DateRangeQuestion.vue';

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
    open_question_survey: {
        c: OpenQuestion,
        name: 'Open question',
        visible: true,
    },
    rating_scale_question_survey: {
        c: RatingScaleQuestion,
        name: 'Rating scale',
        visible: true,
    },
    date_range_question_survey: {
        c: DateRangeQuestion,
        name: 'Date range',
        visible: true,
    },
} satisfies Record<string, Details>;

export type SurveyComponentsKeys = keyof typeof SURVEY_COMPONENT_MAP