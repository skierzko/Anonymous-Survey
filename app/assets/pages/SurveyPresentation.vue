<script setup lang="ts">
import { onMounted } from 'vue';
import NoLoginLayout from './layout/NoLoginLayout.vue';
import { useSurveyStore } from '../stores/survey';
import { SURVEY_COMPONENT_MAP } from '../types/SurveyComponentMap';

const surveyStore = useSurveyStore();

const props = defineProps<{
    slug: string | null;
}>();

onMounted(() => {
    surveyStore.fetchSurveyBySlug(props.slug!);
});
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
                                v-if="SURVEY_COMPONENT_MAP[surveyQuestion.type].s !== null"
                                :is="SURVEY_COMPONENT_MAP[surveyQuestion.type].s"
                                :question="surveyQuestion"
                            />
                        </template>
                    </div>
                </template>
            </section>
        </template>
    </NoLoginLayout>
</template>