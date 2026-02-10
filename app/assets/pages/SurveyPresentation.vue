<script setup lang="ts">
import { ref, provide, onMounted } from 'vue';
import NoLoginLayout from './layout/NoLoginLayout.vue';
import { useSurveyStore } from '../stores/survey';
import { SURVEY_COMPONENT_MAP } from '../types/SurveyComponentMap';
import NotifyBar from '../components/NotifyBar.vue';
import type { SurveyQuestionShowHandle, SurveyQuestionShowRegistry } from './registers/SurveyQuestionShowRegistry';
import Btn from '../components/Btn.vue';
import { toast } from 'vue3-toastify';
import { api } from './services/api';
import { MessageSquareShare } from 'lucide-vue-next';

const surveyStore = useSurveyStore();
const isReadyToSave = ref<boolean>(false);
const isSended = ref<boolean>(false);

const props = defineProps<{
    slug: string | null;
}>();

onMounted(() => {
    surveyStore.fetchSurveyBySlug(props.slug!);
});

const surveyQuestionsHandles: SurveyQuestionShowHandle[] = [];
const surveyQuestionRegisters: SurveyQuestionShowRegistry = {
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

provide('survey-question-show-registry', surveyQuestionRegisters)

const  send = async () => {
    if (! validateAllData()) {
        toast.error('Survey is not ready to be sent', {
            position: toast.POSITION.TOP_RIGHT,
            autoClose: 2500,
        });

        return;
    }

    await api.post(`/survey/show/${props.slug}`, {
            answers: surveyQuestionsHandles.map(handle => handle.getAnswer()),
        })
        .then((response) => {
            if (response.data.status) {
                isSended.value = true;

                toast.success('Survey sent successfully', {
                    position: toast.POSITION.TOP_RIGHT,
                    autoClose: 2500,
                });
            } else {
                toast.error(response.data.error ?? 'Failed to send survey', {
                    position: toast.POSITION.TOP_RIGHT,
                    autoClose: 2500,
                });
            }
        })
        .catch(() => {
            toast.error('Failed to send survey', {
                position: toast.POSITION.TOP_RIGHT,
                autoClose: 2500,
            });
        });
}

const validateAllData = (): boolean => {
    if (surveyQuestionsHandles.length === 0) {
        return false;
    }

    let isValid = true
    for (const h of surveyQuestionsHandles) {
        if (!h.valid()) {
            isValid = false;
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

                <div v-else-if="isSended" class="text-center text-xl text-gray-500">
                    The survey has been sent. Thank you for your participation!
                </div>

                <div v-else-if="surveyStore.surveys[0]?.isPublic === false || surveyStore.surveys.length === 0" class="text-center text-xl text-gray-500">
                    This survey is not public. Please contact the survey creator for more information.
                </div>

                <template v-else>
                    <div class="grid gap-4 grid-cols-1">
                        <div>
                            <NotifyBar
                                v-if="! isReadyToSave"
                                variant="default"
                                class="block! text-center"
                            >
                                <p class="p-2">
                                    You are invited to participate in a survey aimed at collecting opinions and experiences
                                    necessary for further analysis and the improvement of ongoing activities. Participation
                                    in the survey is voluntary, and completing it will take only a few minutes. Please read
                                    the questions carefully and provide responses based on your own experiences.
                                </p>
                            </NotifyBar>
                        </div>

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

                        <div>
                            <NotifyBar
                                v-if="! isReadyToSave"
                                variant="default"
                                class="block! text-center"
                            >
                                <p class="p-2">
                                    This survey has been designed to collect reliable and valuable information that will help 
                                    better understand respondents’ opinions and experiences. The results will be used exclusively 
                                    for analytical and improvement purposes, supporting informed decision-making and 
                                    the enhancement of ongoing activities.
                                </p>
                                <p class="p-2">
                                    Participation in the survey is <strong>completely anonymous</strong>. This means that none of the responses 
                                    provided will be linked to any individual or used to identify respondents in any way. 
                                    The survey includes both required and optional fields — respondents may choose which 
                                    questions to answer, except for those marked as mandatory.
                                </p>
                                <p class="p-2">
                                    Completing the survey will take only a few minutes. Once all responses have been provided, 
                                    please submit the form using the <strong>survey submission button located below</strong>. Thank you for your 
                                    time and contribution — every response is valuable.
                                </p>
                            </NotifyBar>
                        </div>
                        <div class="flex justify-center mt-4">
                            <Btn
                                class="flex! gap-2 px-10! py-4"
                                variant="primary"
                                @click="send()"
                            >
                                <MessageSquareShare />
                                Send survey
                            </Btn>
                        </div>
                    </div>
                </template>
            </section>
        </template>
    </NoLoginLayout>
</template>