export interface SurveyOptionHandle {
  valid: () => boolean
}

export interface SurveyOptionRegistry {
  register: (handle: SurveyOptionHandle) => void
  unregister: (handle: SurveyOptionHandle) => void
}