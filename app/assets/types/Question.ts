import { QuestionOption } from "./QuestionOption";

export interface Question {
    type: string,
    title: string,
    visible: boolean,
    options: QuestionOption[],
    minOptionsLimit: number,
    maxOptionsLimit: number,
    draft: boolean,
    optional: boolean,
}