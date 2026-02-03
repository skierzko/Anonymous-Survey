import { defineStore } from "pinia";
import { api } from "../pages/services/api";
import { Survey } from "../pages/models/Survey";

export const useSurveyStore = defineStore('survey', {
    state: () => ({
        surveys: [] as Survey[],
        loading: false,
        saving: false,
        deleting: false,
        isDeleted: false,
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
            this.isDeleted = false;
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
        async saveSurvey(survey: Survey) {
            this.saving = true;
            this.error = null;

            try {
                await api.post('/survey/save', survey);
            } catch (e: any) {
                this.error = e.message;
            } finally {
                this.saving = false;
            }
        },
        async deleteSurvey(surveyId: number) {
            this.deleting = true;
            this.error = null;

            try {
                await api.delete('/survey/' + surveyId);
                this.surveys = this.surveys.filter(survey => survey.id !== surveyId);
                this.isDeleted = true;
            } catch (e: any) {
                this.error = e.message;
            } finally {
                this.deleting = false;
            }
        }
    },
});
