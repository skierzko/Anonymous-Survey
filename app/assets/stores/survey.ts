import { defineStore } from "pinia";
import { api } from "../pages/services/api";
import { Survey } from "../pages/models/Survey";

export const useSurveyStore = defineStore('survey', {
    state: () => ({
        surveys: [] as Survey[],
        loading: false,
        error: null as string | null,
    }),

    actions: {
        async fetchSurveysByUser() {
            this.loading = true;
            this.error = null;

            try {
                const { data } = await api.get('/surveys');
                this.surveys = data;
            } catch (e: any) {
                this.error = e.message;
            } finally {
                this.loading = false;
            }
        },
        async fetchSurveyByUserAndSurveyId(surveyId: number) {
            this.loading = true;
            this.error = null;

            try {
                const { data } = await api.get('/survey/' + surveyId);
                this.surveys = data;
            } catch (e: any) {
                this.error = e.message;
            } finally {
                this.loading = false;
            }
        },
    },
});
