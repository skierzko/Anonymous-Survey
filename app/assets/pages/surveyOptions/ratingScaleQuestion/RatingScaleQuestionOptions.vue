<script setup lang="ts">
import { SurveyQuestionOption } from '../../models/SurveyQuestionOption';
import { CirclePlus } from 'lucide-vue-next';
import RatingScaleQuestion from './RatingScaleQuestionOption.vue';
import Btn from '../../../components/Btn.vue';

const props = defineProps<{
    options: SurveyQuestionOption[],
}>()

const addOption = (index: number) => {
    props.options.splice(index, 0, {
        id: undefined,
        uuid: '',
        title: '',
        visible: true,
        position: index,
    });
    rewriteOptionsPositions();
};

const moveUp = (index: number): void => {
  if (index <= 0 || index >= props.options.length) return
  props.options.splice(index - 1, 2, props.options[index], props.options[index - 1]);
  rewriteOptionsPositions();
}

const moveDown = (index: number): void => {
  if (index < 0 || index >= props.options.length - 1) return
  props.options.splice(index, 2, props.options[index + 1], props.options[index]);
  rewriteOptionsPositions();
}

const remove = (index: number): void => {
    props.options.splice(index, 1);
    rewriteOptionsPositions();
}

const rewriteOptionsPositions = () => {
    props.options.forEach((option, index) => option.position = index);
}
</script>

<template>
    <div class="p-4">
        <div class="grid grid-cols-1 gap-1">
            <RatingScaleQuestion
                v-for="(option, index) in options"
                :key="'survey_option_' + index"
                :option="option"
                :index="index"
                :is-first="index === 0"
                :is-last="index === options.length - 1"
                @move-up="moveUp"
                @move-down="moveDown"
                @remove="remove"
                @add-option="addOption"
            />
        </div>
        
        <Btn class="ml-0! mt-1" @click="addOption(options.length)">
            Add subquery
            <CirclePlus class="inline-block" :size="20" :stroke-width="1.3" />
        </Btn>
    </div>
</template>