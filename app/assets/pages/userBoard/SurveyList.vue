<script setup lang="ts">
import { onMounted } from 'vue';
import { useSurveyStore } from '../../stores/survey'; 
import { DiamondPlus } from 'lucide-vue-next';
import SurveyRow from './SurveyRow.vue';

const surveyStore = useSurveyStore();

onMounted(() => {
  surveyStore.fetchSurveysByUser();
});
</script>

<template>
    <div v-if="surveyStore.loading" class="text-center">
        Loading...
    </div>
    <div v-else-if="surveyStore.surveys.length" class="sm:w-3/4">
        <SurveyRow v-for="survey in surveyStore.surveys" :survey="survey" />
    </div>
    <div v-else class="text-center text-gray-500">
        No surveys yet. Create your first one! <DiamondPlus :stroke-with="1" class="inline-block" />
    </div>
</template>