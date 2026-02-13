export interface Answer {
    uuid: string,
    value: any,
}

export interface Result {
    answers: Answer[],
}

export interface SurveyResult {
    id: number,
    surveuId: number,

    results: Result,

    createdAt: string,
    updatedAt: string,
    deletedAt: string,
}