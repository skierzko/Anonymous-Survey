import { SurveyQuestion } from "./SurveyQuestion";

export interface Survey {
    id?: number,
    userId?: number,

    title: string,
    draft: boolean,
    slug: string,
    passwordRequired: boolean,
    password: string,
    questions?: SurveyQuestion[],
    extraOptions: Record<string, boolean | string | number>,

    publicAt: string,
    createdAt: string,
    updatedAt: string,
    deletedAt: string,
}