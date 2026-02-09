<script setup lang="ts">
import { ref, provide, onMounted } from 'vue';
import NoLoginLayout from './layout/NoLoginLayout.vue';
import { useSurveyStore } from '../stores/survey';
import { SURVEY_COMPONENT_MAP } from '../types/SurveyComponentMap';
import NotifyBar from '../components/NotifyBar.vue';
import type { SurveyQuestionHandle, SurveyQuestionRegistry } from './registers/SurveyQuestionRegistry';
import Btn from '../components/Btn.vue';
import { toast } from 'vue3-toastify';

const surveyStore = useSurveyStore();
const isReadyToSave = ref<boolean>(false);

const props = defineProps<{
    slug: string | null;
}>();

onMounted(() => {
    surveyStore.fetchSurveyBySlug(props.slug!);
});

const surveyQuestionsHandles: SurveyQuestionHandle[] = [];
const surveyQuestionRegisters: SurveyQuestionRegistry = {
    register(handle) {
        surveyQuestionsHandles.push(handle)
    },
    unregister(handle) {
        const index = surveyQuestionsHandles.indexOf(handle)
        if (index !== -1) {
            surveyQuestionsHandles.splice(index, 1)
        }
    },
}

provide('survey-question-registry', surveyQuestionRegisters)

const  send = () => {
    if (! validateAllData()) {
        toast.error('Survey is not ready to be sent', {
            position: toast.POSITION.TOP_RIGHT,
            autoClose: 2500,
        });

        return;
    }

    toast.success('Survey sent successfully', {
            position: toast.POSITION.TOP_RIGHT,
            autoClose: 2500,
        });
}

const validateAllData = (): boolean => {
    if (surveyQuestionsHandles.length === 0) {
        return false;
    }

    let isValid = true
    for (const h of surveyQuestionsHandles) {
        if (!h.valid()) {
            isValid = false
        }
    }

    isReadyToSave.value = isValid;

    return isValid;
}
</script>

<template>
    <NoLoginLayout :load-user-data="false">
        <template v-slot:presentation_section>
            <div class="px-6 py-4 max-w-[800px] rounded-2xl text-center mx-4">
                <h1 class="p-2 leading-10 text-4xl sm:leading-14">Survey Presentation</h1>
                <div>{{ surveyStore.loading ? 'Loading survey...' : surveyStore.surveys[0]?.title }}</div>
            </div>
        </template>
        <template v-slot:default>
            <section class="p-6 py-20 border-t-2 bg-gray-200">
                <div
                    v-if="surveyStore.loading"
                    class="text-center text-xl text-gray-500"
                >
                    Loading data...
                </div>

                <div v-else-if="surveyStore.surveys[0]?.isPublic === false || surveyStore.surveys.length === 0" class="text-center text-xl text-gray-500">
                    This survey is not public. Please contact the survey creator for more information.
                </div>

                <template v-else>
                    <div class="grid gap-4 grid-cols-1">
                        <template v-for="(surveyQuestion, index) in surveyStore.surveys[0]?.questions" :key="'query-' + index">
                            <component
                                v-if="SURVEY_COMPONENT_MAP[surveyQuestion.type].s !== null && surveyQuestion.visible && surveyQuestion.draft === false"
                                :is="SURVEY_COMPONENT_MAP[surveyQuestion.type].s"
                                :question="surveyQuestion"
                            />
                            <NotifyBar v-else-if="surveyQuestion.visible && surveyQuestion.draft === false">
                                Commponent not found for question type: {{ surveyQuestion.type }}
                            </NotifyBar>
                        </template>
                        <div class="flex justify-end mt-4">
                            <Btn variant="primary" @click="send()">
                                Send survey
                            </Btn>
                            
                        </div>
                    </div>
                </template>
            </section>
        </template>
    </NoLoginLayout>
</template>