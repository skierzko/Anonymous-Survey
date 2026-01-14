export interface SurveyQuestionOption {
    id?: number,
    survey_question_id?:number,

    title: string,
    visible: boolean,

    created_at?: string,
    updated_at?: string,
    deleted_at?: string,
}