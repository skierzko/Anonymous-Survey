<script setup lang="ts">
import { ref, reactive, inject, onMounted } from 'vue';
import type { SurveyQuestionShowHandle, SurveyQuestionShowRegistry } from '../../registers/SurveyQuestionShowRegistry';
import { SurveyQuestion } from '../../models/SurveyQuestion';
import Pill from '../../../components/Pill.vue';

const currentOptions = ref<Record<string, number>>({});
const errors = reactive<Record<string, string>>({});

const props = defineProps<{
    question: SurveyQuestion,
}>()

const isSmallScreen = ref<boolean>(window.matchMedia("(max-width: 640px)").matches);

/** Registry to parent */

const surveyQuestionRegistry = inject<SurveyQuestionShowRegistry>('survey-question-show-registry')
if (!surveyQuestionRegistry) {
  throw new Error('survey-question-show-registry not provided')
}

const valid = (): boolean => {
    Object.keys(errors).forEach(key => delete errors[key]);

    for (const index in props.question.options) {
        const option = props.question.options[index];
        const value = currentOptions.value[option.uuid];
        if (value === undefined) {
            if (props.question.required) {
                errors[option.uuid] = 'This question is required';
            }
        } else {
            if (value < props.question.minOptionsLimit || value > props.question.maxOptionsLimit) {
                errors[option.uuid] = `Value must be between ${props.question.minOptionsLimit} and ${props.question.maxOptionsLimit}`;
            }
        }
        
    }

    return errors && Object.keys(errors).length === 0;
}

const getAnswer = () => {
    return {
        uuid: props.question.uuid,
        value: currentOptions.value,
    };
}

const surveyQuestionHandle: SurveyQuestionShowHandle = { valid, getAnswer }

onMounted(() => {
    surveyQuestionRegistry.register(surveyQuestionHandle)
})
</script>

<template>
    <div
        class="bg-gray-100 rounded-xs p-2"
        :class="[
            ! question.visible && 'opacity-30',
            Object.keys(errors).length > 0 && 'border border-red-700'
        ]"
    >
        <Pill v-if="question.required" variant="danger" size="xs">
            Required
        </Pill>
        <Pill variant="warning" size="xs">
            (low = bad, high = good)
        </Pill>
        <div class="p-2 select-none">
            {{ question.title }}

            <div class="[&>*:nth-child(odd)]:bg-gray-100 [&>*:nth-child(even)]:bg-gray-200">
                <template
                    v-for="(option, index) in question.options"
                    :key="option.id"
                >
                    <div
                        class="w-[calc(100%-1.5rem)] grid gap-2 ml-6"
                        :style="[
                            isSmallScreen && 'grid-template-columns: 150px 20px 1fr',
                            isSmallScreen === false && `grid-template-columns: repeat(${question.maxOptionsLimit - question.minOptionsLimit + 2}, minmax(0, 1fr))`,
                        ]"
                    >
                        <div :class="errors[option.uuid] ? 'text-red-700' : ''">
                            {{ option.title }}
                        </div>

                        <template v-if="isSmallScreen">
                            <div>
                                {{ currentOptions[option.uuid] ?? '0' }}
                            </div>
                            <div>
                                <input
                                    v-model="currentOptions[option.uuid]"
                                    type="range"
                                    class="w-full cursor-pointer"
                                    :min="question.minOptionsLimit"
                                    :max="question.maxOptionsLimit"
                                />
                            </div>
                        </template>
                        <template
                            v-else
                            v-for="(n, index) in Array.from({ length: question.maxOptionsLimit - question.minOptionsLimit + 1 }, (_, i) => i + question.minOptionsLimit)"
                            :key="index">
                            <div>
                                <input
                                    type="radio"
                                    class="cursor-pointer"
                                    :id="option.uuid + index"
                                    :name="option.uuid + index"
                                    :value="index + 1"
                                    v-model="currentOptions[option.uuid]"
                                    /> <label :for="option.uuid + index" class="ml-2 cursor-pointer" >{{ n }}</label>
                            </div>
                        </template>
                    </div>
                    <div v-if="errors[option.uuid]" class="text-red-700 col-span-2 text-sm ml-6">{{ errors[option.uuid] }}</div>
                </template>
            </div>
            
        </div>
    </div>
</template>