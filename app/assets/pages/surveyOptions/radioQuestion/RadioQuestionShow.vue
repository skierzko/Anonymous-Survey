<script setup lang="ts">
import { SurveyQuestion } from '../../models/SurveyQuestion';
import Pill from '../../../components/Pill.vue';

const currentOptions = new Map<number, string>();

const props = defineProps<{
    question: SurveyQuestion,
}>()
</script>

<template>
    <div
        class="bg-gray-100 rounded-xs p-2"
        :class="[! question.visible && 'opacity-30']"
    >
        <Pill v-if="question.required" variant="danger" size="xs">Required</Pill>
        <div class="grid gap-2 p-2 select-none">
            {{ question.title }}
            <div v-for="(option, index) in question.options" :key="option.id" class="ml-6">
                <input
                    type="radio"
                    class="cursor-pointer"
                    :id="option.uuid"
                    :name="question.uuid"
                    :value="option.uuid"
                    v-model="currentOptions"
                    /> <label :for="option.uuid" class="ml-2 cursor-pointer" >{{ option.title }}</label>
            </div>
        </div>
    </div>
</template>