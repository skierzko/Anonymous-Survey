<script setup lang="ts">
import { ref, provide, inject, onMounted, onUnmounted } from 'vue'
import type { SurveyOptionRegistry, SurveyOptionHandle } from '../../registers/SurveyOptionRegistry';
import type { SurveyQuestionRegistry, SurveyQuestionHandle } from '../../registers/SurveyQuestionRegistry'; 
import { SurveyQuestion } from '../../models/SurveyQuestion';
import { ArrowBigUp, ArrowBigDown, Trash2, Eye, EyeOff, SquareStack } from 'lucide-vue-next';
import Btn from '../../../components/Btn.vue';
import CheckboxQuestionOptions from './CheckboxQuestionOptions.vue';
import Separator from '../../../components/Separator.vue';
import InputText from '../../../components/InputText.vue';
import InputNumber from '../../../components/InputNumber.vue';
import OnOff from '../../../components/OnOff.vue';
import { SurveyQuestionOption } from '../../models/SurveyQuestionOption';

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
    options?: boolean,
    optionsEmpty?: boolean,
    minOptionsLimit?: boolean,
    maxOptionsLimit?: boolean,
}>();

const valid = (): boolean => {
    errors.value = {
        title: isTitleError(),
        options: isOptionsError(),
        optionsEmpty: isOptionsEmptyError(),
        minOptionsLimit: isMinOptionsLimitError(),
        maxOptionsLimit: isMaxOptionsLimitError(),
    };

    validateAllOptions();

    return Object.values(errors.value).every(value => value === false);
}

const isTitleError = (): boolean => {
    return props.question.title.trim().length === 0;
}

const isOptionsError = (): boolean => {
    return props.question.options.filter((option: SurveyQuestionOption) => {
        return option.title.trim().length === 0
    }).length > 0;
}

const isOptionsEmptyError = (): boolean => {
    return props.question.options.length === 0;
}

const isMinOptionsLimitError = (): boolean => {
    return props.question.minOptionsLimit < 0 ||
        props.question.minOptionsLimit > props.question.maxOptionsLimit ||
        props.question.minOptionsLimit > props.question.options.length;
}

const isMaxOptionsLimitError = (): boolean => {
    return props.question.maxOptionsLimit < 0 ||
        props.question.maxOptionsLimit > props.question.options.length ||
        props.question.maxOptionsLimit < props.question.minOptionsLimit;
}

function validateAllOptions(): boolean {
    let isValid = true
    for (const h of surveyOptionsHandles) {
        if (!h.valid()) {
            isValid = false
        }
    }
    return isValid;
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

/** Registry from children */

const surveyOptionsHandles: SurveyOptionHandle[] = [];
const surveyOptionsRegisters: SurveyOptionRegistry = {
    register(handle) {
        surveyOptionsHandles.push(handle)
    },
    unregister(handle) {
        const index = surveyOptionsHandles.indexOf(handle)
        if (index !== -1) {
            surveyOptionsHandles.splice(index, 1)
        }
    },
}

provide('survey-option-registry', surveyOptionsRegisters)

/** Other */

const toggleVisibility = () => {
    props.question.visible = !props.question.visible;
}

onMounted(() => {
    props.question.position = props.index;
})
</script>

<template>
    <Separator @click="emit('addQuestion', index)" label="Add query here" />
    <div
        class="bg-gray-100 rounded-xs p-2"
        :class="[! question.visible && 'opacity-30']"
    >
        <div class="flex gap-1 items-center mb-3">
            <SquareStack class="mr-2" />
            <div class="flex-1 text-gray-500 font-bold text-xs">
                Multi choice
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
                <Btn class="p-1!" :variant="question.visible ? 'default' : 'info'">
                    <Eye v-if="question.visible" :size="20" :stroke-width="1.3" @click="toggleVisibility" />
                    <EyeOff v-else :size="20" :stroke-width="1.3" @click="toggleVisibility" />
                </Btn>
            </div>
            <div class="ml-6">
                <Btn variant="danger" class="p-1!" @click="emit('remove', index)">
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
            <div class="flex gap-2">
                <InputNumber
                    v-model="question.minOptionsLimit"
                    label="Min. selected options"
                    :min="0"
                    :max="30"
                    :error="errors?.minOptionsLimit ? 'The field contains errors' : ''"
                />
                <InputNumber
                    v-model="question.maxOptionsLimit"
                    label="Max. selected options"
                    :min="0"
                    :max="30"
                    :error="errors?.maxOptionsLimit ? 'The field contains errors' : ''"
                />
            </div>
            <OnOff v-model="question.draft" label="Mark as draft" />
            <OnOff v-model="question.required" label="Response is required" />
            <div v-if="errors?.optionsEmpty" class="px-4 pt-4 text-xs text-red-500">The list of answers cannot be empty</div>
            <CheckboxQuestionOptions :options="question.options" />
        </div>
    </div>
    <Separator v-if="isLast" label="Add query here" @click="emit('addQuestion', index + 1)" />
</template>