<script setup lang="ts">
import { ref } from 'vue';
import { SurveyQuestion } from '../../models/SurveyQuestion';
import Pill from '../../../components/Pill.vue';
import InputDate from '../../../components/InputDate.vue';

const props = defineProps<{
    question: SurveyQuestion,
}>()

const dates = ref<{dateStart: string, dateEnd: string}>({
    dateStart: '',
    dateEnd: '',
});

const single = props.question.extraOptions.viewSingleDate ?? false;
</script>

<template>
    <div
        class="bg-gray-100 rounded-xs p-2"
        :class="[! question.visible && 'opacity-30']"
    >
        <Pill v-if="question.required" variant="danger" size="xs">
            Required
            {{ question.minOptionsLimit > 0 ? `(min ${question.minOptionsLimit})` : '' }}
            {{ question.maxOptionsLimit > 0 ? `(max ${question.maxOptionsLimit})` : '' }}
        </Pill>
        <div class="p-2 select-none">
            {{ question.title }}
        </div>
        <div class="grid gap-2 grid-cols-3 p-2 select-none">
            <InputDate v-model="dates.dateStart" :label="single ? 'Date' : 'From'" />
            <InputDate v-if="single === false" v-model="dates.dateEnd" label="To" />
        </div>
    </div>
</template>