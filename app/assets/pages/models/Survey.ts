import { SurveyQuestion } from "./SurveyQuestion";

export interface Survey {
    id?: number,
    user_id?: number,

    title: string,
    draft: boolean,
    slug: string,
    password: string,
    options?: SurveyQuestion[],

    public_at: string,
    created_at: string,
    updated_at: string,
    deleted_at: string,
}