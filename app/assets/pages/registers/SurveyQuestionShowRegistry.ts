export interface SurveyQuestionShowHandle {
  valid: () => boolean
  getAnswer: () => any
}

export interface SurveyQuestionShowRegistry {
  register: (handle: SurveyQuestionShowHandle) => void
  unregister: (handle: SurveyQuestionShowHandle) => void
}