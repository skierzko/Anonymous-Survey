<script setup lang="ts">
import Btn from '../../../components/Btn.vue';
import InputText from '../../../components/InputText.vue';
import Separator from '../../../components/Separator.vue';
import { SurveyQuestionOption } from '../../models/SurveyQuestionOption';
import { ArrowBigUp, ArrowBigDown, Trash2, Eye, EyeOff } from 'lucide-vue-next';

const props = defineProps<{
    option: SurveyQuestionOption,
    index: number,
    isFirst: boolean,
    isLast: boolean,
}>()

const emit = defineEmits<{
    (e: 'moveUp', index: number): void,
    (e: 'moveDown', index: number): void,
    (e: 'addOption', index: number): void,
    (e: 'remove', index: number): void,
}>();

const toggleVisibility = () => {
    props.option.visible = !props.option.visible;
}
</script>

<template>
    <Separator class="w-2/3" @click="emit('addOption', index)" />
    <div class="flex gap-1 items-center">
        <InputText v-model="option.title" class="w-2/3 rounded-xs" placeholder="Enter one of the answers" />
        <Btn class="p-1!" :disabled="isFirst" @click="! isFirst && emit('moveUp', index)">
            <ArrowBigUp :size="20" :stroke-width="1.3" />
        </Btn>
        <Btn class="p-1!" :disabled="isLast" @click="! isLast && emit('moveDown', index)">
            <ArrowBigDown :size="20" :stroke-width="1.3" />
        </Btn>
        <Btn class="p-1!">
            <Eye v-if="option.visible" :size="20" :stroke-width="1.3" @click="toggleVisibility" />
            <EyeOff v-else :size="20" :stroke-width="1.3" @click="toggleVisibility" />
        </Btn>
        <Btn type="danger" class="p-1!" @click="emit('remove', index)">
            <Trash2 :size="20" :stroke-width="1.3" />
        </Btn>
    </div>
    <Separator v-if="isLast" class="w-2/3" @click="emit('addOption', index + 1)"  />
</template>