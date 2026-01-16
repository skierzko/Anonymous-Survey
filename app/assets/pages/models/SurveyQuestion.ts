import { SurveyQuestionOption } from "./SurveyQuestionOption";

export interface SurveyQuestion {
    id?: number,
    surveyId?: number,

    type: string,
    title: string,
    visible: boolean,
    minOptionsLimit: number,
    maxOptionsLimit: number,
    draft: boolean,
    required: boolean,
    optional: boolean,

    options: SurveyQuestionOption[],
    extraOptions: Record<string, any>,

    createdAt?: string,
    updatedAt?: string,
    deletedAt?: string,
}