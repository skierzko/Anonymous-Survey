import type { Component } from 'vue'
import RadioQuestionSurvey from '../pages/surveyOptions/radioQuestion/RadioQuestion.vue';
import RadioQuestionShow from '../pages/surveyOptions/radioQuestion/RadioQuestionShow.vue';
import ChangeQueryType from '../pages/surveyOptions/changeQueryType/ChangeQueryType.vue';
import CheckboxQuestionSurvey from '../pages/surveyOptions/checkboxQuestion/CheckboxQuestion.vue';
import OpenQuestion from '../pages/surveyOptions/openQuestion/OpenQuestion.vue';
import RatingScaleQuestion from '../pages/surveyOptions/ratingScaleQuestion/RatingScaleQuestion.vue';
import DateRangeQuestion from '../pages/surveyOptions/dateRangeQuestion/DateRangeQuestion.vue';

interface Details {
    c: Component,
    s: Component | null,
    name: string,
    visible: boolean,
}

export const SURVEY_COMPONENT_MAP: Record<string, Details> = {
    change_query_type: {
        c: ChangeQueryType,
        s: null,
        name: 'Change query type',
        visible: false,
    },
    radio_question_survey: {
        c: RadioQuestionSurvey,
        s: RadioQuestionShow,
        name: 'Single choice',
        visible: true,
    },
    checkbox_question_survey: {
        c: CheckboxQuestionSurvey,
        s: null,
        name: 'Multi choice',
        visible: true,
    },
    open_question_survey: {
        c: OpenQuestion,
        s: null,
        name: 'Open question',
        visible: true,
    },
    rating_scale_question_survey: {
        c: RatingScaleQuestion,
        s: null,
        name: 'Rating scale',
        visible: true,
    },
    date_range_question_survey: {
        c: DateRangeQuestion,
        s: null,
        name: 'Date range',
        visible: true,
    },
} satisfies Record<string, Details>;

export type SurveyComponentsKeys = keyof typeof SURVEY_COMPONENT_MAP