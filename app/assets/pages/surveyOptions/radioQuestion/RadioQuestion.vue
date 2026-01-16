<script setup lang="ts">
import { ref, provide, inject, onMounted, onUnmounted } from 'vue';
import type { SurveyOptionRegistry, SurveyOptionHandle } from '../../registers/SurveyOptionRegistry'; 
import type { SurveyQuestionRegistry, SurveyQuestionHandle } from '../../registers/SurveyQuestionRegistry'; 
import { SurveyQuestion } from '../../models/SurveyQuestion';
import { ArrowBigUp, ArrowBigDown, Trash2, Eye, EyeOff, CircleDot } from 'lucide-vue-next';
import Btn from '../../../components/Btn.vue';
import RadioQuestionOptions from './RadioQuestionOptions.vue';
import Separator from '../../../components/Separator.vue';
import InputText from '../../../components/InputText.vue';
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
}>();

const valid = (): boolean => {
    errors.value = {
        title: isTitleError(),
        options: isOptionsError(),
        optionsEmpty: isOptionsEmptyError(),
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
</script>

<template>
    <Separator @click="emit('addQuestion', index)" label="Add query here" />
    <div
        class="bg-gray-100 rounded-xs p-2"
        :class="[! question.visible && 'opacity-30']"
    >
        <div class="flex gap-1 items-center mb-3">
            <CircleDot class="mr-2" />
            <div class="flex-1 text-gray-500 font-bold text-xs">
                Single choice
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
                class="w-3/4 p-1 rounded-xs"
                placeholder="Enter your question"
                label="Title:"
                :error="errors?.title ? 'The field cannot remain empty' : ''"
            />
            <OnOff v-model="question.draft" label="Mark as draft" />
            <OnOff v-model="question.required" label="Response is required" />
            <div v-if="errors?.optionsEmpty" class="px-4 pt-4 text-xs text-red-500">The list of answers cannot be empty</div>
            <RadioQuestionOptions :options="question.options" />
        </div>
    </div>
    <Separator v-if="isLast" label="Add query here" @click="emit('addQuestion', index + 1)" />
</template>