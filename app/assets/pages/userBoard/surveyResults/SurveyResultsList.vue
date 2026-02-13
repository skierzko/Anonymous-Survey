<script setup lang="ts">
import Btn from '../../../components/Btn.vue';
import { SurveyResult } from '../../models/SurveyResult';

defineProps<{
  results: SurveyResult[]
  currentResultId: number | null
}>()

const emit = defineEmits<{
    (e: 'setResultId', resultId: number | null): void,
}>();

const sendEmit = (resultId: number | null) => {
    emit('setResultId', resultId);
}
</script>

<template>
    <div>Anonymous survey responses: </div>
    <div class="flex mb-4">
        <Btn
            :variant="currentResultId === null ? 'primary' : 'default'"
            class="p-1! m-0!"
            @click="sendEmit(null)"
        >
            Select:
        </Btn>
        <Btn
            v-for="result in results"
            :variant="currentResultId === result.id ? 'primary' : 'default'"
            class="p-1! m-0!"
            @click="sendEmit(result.id)"
        >
            {{ result.id }}
        </Btn>
    </div>
</template>