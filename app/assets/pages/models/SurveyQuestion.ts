import { SurveyQuestionOption } from "./SurveyQuestionOption";

export interface SurveyQuestion {
    id?: number,
    survey_id?: number,

    type: string,
    title: string,
    visible: boolean,
    minOptionsLimit: number,
    maxOptionsLimit: number,
    draft: boolean,
    optional: boolean,

    options: SurveyQuestionOption[],

    created_at?: string,
    updated_at?: string,
    deleted_at?: string,
}