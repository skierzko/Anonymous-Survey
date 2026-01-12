<script setup lang="ts">
import { ref } from 'vue';
import Btn from '../components/Btn.vue';
import UserBoardLayout from './layout/UserBoardLayout.vue';
import { Question } from '../types/Question';
import { User } from '../types/User';
import { SURVEY_COMPONENT_MAP } from '../types/SurveyComponentMap';

const props = defineProps<{
    csrfToken: string,
    userLogged?: User,
}>()

const surveyOptions = ref<Question[]>([]);

const addQuestion = (index: number, type?: string) => {
    surveyOptions.value.splice(index, 0, {
        type: type ?? 'change_query_type',
        title: 'Change question',
        visible: true,
        options: [],
    })
};

const moveUp = (index: number): void => {
  if (index <= 0 || index >= surveyOptions.value.length) return
  surveyOptions.value.splice(index - 1, 2, surveyOptions.value[index], surveyOptions.value[index - 1]);
}

const moveDown = (index: number): void => {
  if (index < 0 || index >= surveyOptions.value.length - 1) return
  surveyOptions.value.splice(index, 2, surveyOptions.value[index + 1], surveyOptions.value[index]);
}

const remove = (index: number): void => {
    surveyOptions.value.splice(index, 1);
}
</script>

<template>
    <UserBoardLayout>
        <template v-slot:presentation_section>
            <div class="px-6 py-4 max-w-[800px] rounded-2xl text-center mx-4">
                <h1 class="p-2 leading-10 text-4xl sm:leading-14">Survey Creator</h1>
            </div>
        </template>
        <template v-slot:default>
            <section class="p-6 py-20 border-t-2 bg-gray-200">
                <div class="flex gap-4">
                    <div>
                        <div class="text-xl mb-4">Options</div>

                        <div class="grid grid-cols-1 gap-2">
                            <Btn type="primary" @click="addQuestion(surveyOptions.length, 'radio_question_survey')">Single choice</Btn>
                            <!-- <Btn type="primary" @click="addQuestion(surveyOptions.length, 'multi-choice')">Multi choice</Btn>
                            <Btn type="primary" @click="addQuestion(surveyOptions.length, 'verbal-response')">Verbal response</Btn>
                            <Btn type="primary" @click="addQuestion(surveyOptions.length, 'dropdown-options')">Dropdown options</Btn>
                            <Btn type="primary" @click="addQuestion(surveyOptions.length, 'linear-scale')">Linear scale</Btn>
                            <Btn type="primary" @click="addQuestion(surveyOptions.length, 'date-choice')">Date choice</Btn> -->
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="text-xl mb-4">Survey questions</div>

                        <div class="grid gap-4 grid-cols-1">
                            <template v-for="(surveyOption, index) in surveyOptions">
                                <component
                                    :is="SURVEY_COMPONENT_MAP[surveyOption.type].c"
                                    :question="surveyOption"
                                    :index="index"
                                    :is-first="index === 0"
                                    :is-last="index === surveyOptions.length - 1"
                                    @move-up="moveUp"
                                    @move-down="moveDown"
                                    @remove="remove"
                                    @add-question="addQuestion"
                                />
                            </template>
                        </div>

                        <p v-if="surveyOptions.length === 0">Add first question</p>
                    </div>
                </div>
            </section>
        </template>
    </UserBoardLayout>
</template>