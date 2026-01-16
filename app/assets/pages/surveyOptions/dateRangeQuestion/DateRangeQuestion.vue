<script setup lang="ts">
import { ref, inject, onMounted, onUnmounted } from 'vue'
import type { SurveyQuestionRegistry, SurveyQuestionHandle } from '../../registers/SurveyQuestionRegistry'; 
import { SurveyQuestion } from '../../models/SurveyQuestion';
import { ArrowBigUp, ArrowBigDown, Trash2, Eye, EyeOff, Calendar1 } from 'lucide-vue-next';
import Btn from '../../../components/Btn.vue';
import Separator from '../../../components/Separator.vue';
import InputText from '../../../components/InputText.vue';
import OnOff from '../../../components/OnOff.vue';

const props = defineProps<{
    question: SurveyQuestion,
    index: number,
    isFirst: boolean,
    isLast: boolean,
}>()

const emit = defineEmits<{
    (e: 'moveUp', index: number): void,
    (e: 'moveDown', index: number): void,
    (e: 'addQuestion', index: number): void,
    (e: 'remove', index: number): void,
}>();

/** Validation */

const errors = ref<{
    title?: boolean,
    minOptionsLimit?: boolean,
    maxOptionsLimit?: boolean,
}>();

const valid = (): boolean => {
    errors.value = {
        title: isTitleError(),
        minOptionsLimit: isMinOptionsLimitError(),
        maxOptionsLimit: isMaxOptionsLimitError(),
    };

    return Object.values(errors.value).every(value => value === false);
}

const isTitleError = (): boolean => {
    return props.question.title.trim().length === 0;
}

const isMinOptionsLimitError = (): boolean => {
    return props.question.minOptionsLimit < 0 ||
        props.question.minOptionsLimit > props.question.maxOptionsLimit;
}

const isMaxOptionsLimitError = (): boolean => {
    return props.question.maxOptionsLimit < 0 ||
        props.question.maxOptionsLimit < props.question.minOptionsLimit;
}

/** Registry to parent */

const surveyQuestionRegistry = inject<SurveyQuestionRegistry>('survey-question-registry')
if (!surveyQuestionRegistry) {
  throw new Error('survey-question-registry not provided')
}

const surveyQuestionHandle: SurveyQuestionHandle = { valid }

onMounted(() => {
  surveyQuestionRegistry.register(surveyQuestionHandle)
})

onUnmounted(() => {
  surveyQuestionRegistry.unregister(surveyQuestionHandle)
})

/** Other */

const toggleVisibility = () => {
    props.question.visible = !props.question.visible;
}
</script>

<template>
    <Separator @click="emit('addQuestion', index)" label="Add query here" />
    <div
        class="bg-gray-100 rounded-xs p-2"
        :class="[! question.visible && 'opacity-30']"
    >
        <div class="flex gap-1 items-center mb-3">
            <Calendar1 class="mr-2" />
            <div class="flex-1 text-gray-500 font-bold text-xs">
                Date range
            </div>
            <div>
                <Btn class="p-1!" :disabled="isFirst" @click="emit('moveUp', index)">
                    <ArrowBigUp :size="20" :stroke-width="1.3" />
                </Btn>
            </div>
            <div>
                <Btn class="p-1!" :disabled="isLast" @click="emit('moveDown', index)">
                    <ArrowBigDown :size="20" :stroke-width="1.3" />
                </Btn>
            </div>
            <div>
                <Btn class="p-1!" :type="question.visible ? 'default' : 'info'">
                    <Eye v-if="question.visible" :size="20" :stroke-width="1.3" @click="toggleVisibility" />
                    <EyeOff v-else :size="20" :stroke-width="1.3" @click="toggleVisibility" />
                </Btn>
            </div>
            <div class="ml-6">
                <Btn type="danger" class="p-1!" @click="emit('remove', index)">
                    <Trash2 :size="20" :stroke-width="1.3" />
                </Btn>
            </div>
        </div>
        <div class="grid gap-2 p-2">
            <InputText
                v-model="question.title"
                class="w-3/4 rounded-xs"
                placeholder="Enter your question"
                label="Title:"
                :error="errors?.title ? 'The field cannot remain empty' : ''"
            />
            <OnOff v-model="question.draft" label="Mark as draft" />
            <OnOff v-model="question.required" label="Response is required" />
            <OnOff v-model="question.extraOptions.viewSingleDate" label="Force display of a single date" />
        </div>
    </div>
    <Separator v-if="isLast" label="Add query here" @click="emit('addQuestion', index + 1)" />
</template>