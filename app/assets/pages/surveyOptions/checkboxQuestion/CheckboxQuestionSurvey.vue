<script setup lang="ts">
import { Question } from '../../../types/Question';
import { ArrowBigUp, ArrowBigDown, Trash2, Eye, EyeOff, SquareStack } from 'lucide-vue-next';
import Btn from '../../../components/Btn.vue';
import CheckboxQuestionSurveyOptions from './CheckboxQuestionSurveyOptions.vue';
import Separator from '../../../components/Separator.vue';
import InputText from '../../../components/InputText.vue';
import InputNumber from '../../../components/InputNumber.vue';
import OnOff from '../../../components/OnOff.vue';

const props = defineProps<{
    question: Question,
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
            />

            <div class="flex gap-2">
                <InputNumber
                    v-model="question.minOptionsLimit"
                    label="Min. selected options"
                    />
                <InputNumber
                    v-model="question.maxOptionsLimit"
                    label="Max. selected options"
                />
            </div>

            <OnOff v-model="question.draft" label="Check as draft" />


            <CheckboxQuestionSurveyOptions :options="question.options" />
        </div>
    </div>
    <Separator v-if="isLast" label="Add query here" @click="emit('addQuestion', index + 1)"  />
</template>