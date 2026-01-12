import { QuestionOption } from "./QuestionOption";

export interface Question {
    type: string,
    title: string,
    visible: boolean,
    options: QuestionOption[],
}