export interface SurveyQuestionOption {
    id?: number,
    surveyQuestionId?:number,

    title: string,
    visible: boolean,

    createdAt?: string,
    updatedAt?: string,
    deletedAt?: string,
}