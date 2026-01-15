export interface SurveyQuestionHandle {
  valid: () => boolean
}

export interface SurveyQuestionRegistry {
  register: (handle: SurveyQuestionHandle) => void
  unregister: (handle: SurveyQuestionHandle) => void
}