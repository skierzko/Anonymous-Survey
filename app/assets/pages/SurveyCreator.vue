<script setup lang="ts">
import { ref } from 'vue';
import axios from 'axios';
import Btn from '../components/Btn.vue';
import UserBoardLayout from './layout/UserBoardLayout.vue';
import { User } from '../types/User';
import { SURVEY_COMPONENT_MAP } from '../types/SurveyComponentMap';
import { TriangleAlert } from 'lucide-vue-next';
import InputText from '../components/InputText.vue';
import OnOff from '../components/OnOff.vue';
import Pill from '../components/Pill.vue';
import Separator from '../components/Separator.vue';
import { Survey } from './models/Survey';
import { createSurvey } from './models/factory/Survey.factory';

const props = defineProps<{
    csrfToken: string,
    userLogged?: User,
}>()

const survey = ref<Survey>(createSurvey());

const addQuestion = (index: number, type?: string) => {
    if (! survey.value.options) {
        return;
    }

    survey.value.options.splice(index, 0, {
        type: type ?? 'change_query_type',
        title: '',
        visible: true,
        options: [],
        minOptionsLimit: 1,
        maxOptionsLimit: 1,
        draft: false,
        required: true,
        optional: false,
    })
};

const moveUp = (index: number): void => {
    if (
        ! survey.value.options ||
        index <= 0 ||
        index >= survey.value.options.length
    ) {
        return;
    }

    survey.value.options.splice(index - 1, 2, survey.value.options[index], survey.value.options[index - 1]);
}

const moveDown = (index: number): void => {
    if (
        ! survey.value.options ||
        index < 0 ||
        index >= survey.value.options.length - 1
    ) {
        return
    }
  
  survey.value.options.splice(index, 2, survey.value.options[index + 1], survey.value.options[index]);
}

const remove = (index: number): void => {
    if (! survey.value.options ) {
        return;
    }
    
    survey.value.options.splice(index, 1);
}

const save = async () => {
    // await axios.post()
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
                <div class="md:flex gap-4">
                    <div>
                        <div class="sticky top-1">
                            <div class="text-xl mb-4">Options</div>

                        <div class="grid grid-cols-1 gap-3">
                            <InputText v-model="survey.title" placeholder="Title" />
                            <OnOff v-model="survey.draft" label="Draft" />
                            <Btn type="success" class="w-full" @click="save">Save</Btn>
                            <Separator class="pt-6" fullVisibility :clickable="false">Details</Separator>
                            <p class="flex gap-2 items-center text-sm text-gray-600">
                                Created questions:
                                <Pill>{{ survey.options?.length }}</Pill>
                            </p>
                            <Separator class="pt-6" fullVisibility :clickable="false">Time details</Separator>
                            <p class="text-sm text-gray-600">
                                First save:
                                {{ survey.created_at }}
                            </p>
                            <p class="text-sm text-gray-600">
                                Last save:
                                {{ survey.updated_at }}
                            </p>
                            
                            <!-- 
                            <Btn type="primary" @click="addQuestion(surveyOptions.length, 'verbal-response')">Verbal response</Btn>
                            <Btn type="primary" @click="addQuestion(surveyOptions.length, 'dropdown-options')">Dropdown options</Btn>
                            <Btn type="primary" @click="addQuestion(surveyOptions.length, 'linear-scale')">Linear scale</Btn>
                            <Btn type="primary" @click="addQuestion(surveyOptions.length, 'date-choice')">Date choice</Btn> -->
                        </div>
                        </div>
                    </div>
                    <div class="flex-1 mt-16 md:mt-0">
                        <div class="text-xl mb-4">Survey questions</div>

                        <div class="grid gap-4 grid-cols-1">
                            <template v-for="(surveyOption, index) in survey.options">
                                <component
                                    :is="SURVEY_COMPONENT_MAP[surveyOption.type].c"
                                    :question="surveyOption"
                                    :index="index"
                                    :is-first="index === 0"
                                    :is-last="index === (survey.options?.length ?? 0) - 1"
                                    @move-up="moveUp"
                                    @move-down="moveDown"
                                    @remove="remove"
                                    @add-question="addQuestion"
                                />
                            </template>
                        </div>

                        <p
                            v-if="(survey.options?.length ?? 0) === 0"
                            class="flex gap-4 items-center p-4 bg-sky-800 text-white rounded-xs"
                        >
                            <TriangleAlert />
                            Create the first question by clicking on the button on the right.
                            <Btn @click="addQuestion(0)">Create question</Btn>
                        </p>
                    </div>
                </div>
            </section>
        </template>
    </UserBoardLayout>
</template>