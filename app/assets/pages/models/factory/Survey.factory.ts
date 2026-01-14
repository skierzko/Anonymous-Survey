import type { Survey } from "../Survey";

export function createSurvey(): Survey {
  return {
    id: undefined,
    user_id: undefined,
    title: "",
    draft: false,
    slug: "",
    password_required: false,
    password: "",
    questions: [],

    public_at: "",
    created_at: "",
    updated_at: "",
    deleted_at: "",
  };
}