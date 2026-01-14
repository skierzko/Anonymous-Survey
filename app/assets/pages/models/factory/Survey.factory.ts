import type { Survey } from "../Survey";

export function createSurvey(): Survey {
  return {
    id: undefined,
    user_id: undefined,
    name: "",
    draft: false,
    slug: "",
    password: "",
    options: [],

    public_at: "",
    created_at: "",
    updated_at: "",
    deleted_at: "",
  };
}