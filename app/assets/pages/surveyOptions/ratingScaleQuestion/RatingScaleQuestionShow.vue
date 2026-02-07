<script setup lang="ts">
import { ref } from 'vue';
import { SurveyQuestion } from '../../models/SurveyQuestion';
import Pill from '../../../components/Pill.vue';

const currentOptions = ref<Record<string, number>>({})

const props = defineProps<{
    question: SurveyQuestion,
}>()
</script>

<template>
    <div
        class="bg-gray-100 rounded-xs p-2"
        :class="[! question.visible && 'opacity-30']"
    >
        <Pill v-if="question.required" variant="danger" size="xs">
            Required
            (low = bad, high = good)
        </Pill>
        <div class="grid gap-2 p-2 select-none">
            {{ question.title }}
            <div
                v-for="(option, index) in question.options"
                :key="option.id"
                class="grid gap-2 ml-6"
                :style="`grid-template-columns: repeat(${question.maxOptionsLimit - question.minOptionsLimit + 2}, minmax(0, 1fr))`"

            >
                {{ option.title }}

                <template v-for="(n, index) in Array.from({ length: question.maxOptionsLimit - question.minOptionsLimit + 1 }, (_, i) => i + question.minOptionsLimit)">
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
        </div>
    </div>
</template>