import type { Survey } from "../Survey";

export function createSurvey(): Survey {
  return {
    id: undefined,
    userId: undefined,
    title: "",
    draft: false,
    slug: "",
    passwordRequired: false,
    password: "",
    questions: [],
    extraOptions: {},
    isPublic: false,

    publicAt: "",
    createdAt: "",
    updatedAt: "",
    deletedAt: "",
  };
}