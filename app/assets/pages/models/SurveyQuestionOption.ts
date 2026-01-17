export interface SurveyQuestionOption {
    id?: number,
    surveyQuestionId?:number,

    title: string,
    visible: boolean,
    position: number,

    createdAt?: string,
    updatedAt?: string,
    deletedAt?: string,
}