<script setup lang="ts">
import { ref, provide } from 'vue';
import axios from 'axios';
import Btn from '../components/Btn.vue';
import UserBoardLayout from './layout/UserBoardLayout.vue';
import { User } from '../types/User';
import { SURVEY_COMPONENT_MAP, SurveyComponentsKeys } from '../types/SurveyComponentMap';
import { TriangleAlert } from 'lucide-vue-next';
import InputText from '../components/InputText.vue';
import OnOff from '../components/OnOff.vue';
import Pill from '../components/Pill.vue';
import Separator from '../components/Separator.vue';
import { Survey } from './models/Survey';
import { createSurvey } from './models/factory/Survey.factory';
import type { SurveyQuestionHandle, SurveyQuestionRegistry } from './registers/SurveyQuestionRegistry';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const props = defineProps<{
    csrfToken: string,
    userLogged?: User,
    id?: number,
}>()

const errors = ref<{
    title?: boolean,
    password?: boolean,
}>();

const survey = ref<Survey>(createSurvey());

const addQuestion = (index: number, type?: SurveyComponentsKeys) => {
    if (! survey.value.questions) {
        return;
    }

    survey.value.questions.splice(index, 0, {
        type: type ?? 'change_query_type',
        title: '',
        visible: true,
        options: [],
        minOptionsLimit: 1,
        maxOptionsLimit: 1,
        draft: false,
        required: true,
        optional: false,
        position: index,
        extraOptions: {},
    })
};

const moveUp = (index: number): void => {
    if (
        ! survey.value.questions ||
        index <= 0 ||
        index >= survey.value.questions.length
    ) {
        return;
    }

    survey.value.questions.splice(index - 1, 2, survey.value.questions[index], survey.value.questions[index - 1]);
}

const moveDown = (index: number): void => {
    if (
        ! survey.value.questions ||
        index < 0 ||
        index >= survey.value.questions.length - 1
    ) {
        return
    }
  
  survey.value.questions.splice(index, 2, survey.value.questions[index + 1], survey.value.questions[index]);
}

const remove = (index: number): void => {
    if (! survey.value.questions) {
        return;
    }
    
    survey.value.questions.splice(index, 1);
}

const save = async (): Promise<void> => {
    if (! validateAllData()) {
        toast.warning(
            surveyQuestionsHandles.length 
                ? 'Correct the data in the form before saving the data'
                : 'Add at least one question before saving', {
            position: toast.POSITION.TOP_RIGHT,
            autoClose: 2500,
        });

        return;
    }

    await axios.post('/survey/save', survey.value);
}

const surveyQuestionsHandles: SurveyQuestionHandle[] = [];
const surveyQuestionRegisters: SurveyQuestionRegistry = {
    register(handle) {
        surveyQuestionsHandles.push(handle)
    },
    unregister(handle) {
        const index = surveyQuestionsHandles.indexOf(handle)
        if (index !== -1) {
            surveyQuestionsHandles.splice(index, 1)
        }
    },
}

provide('survey-question-registry', surveyQuestionRegisters)

const isReadyToSave = ref<boolean>(false);

function validateAllData(): boolean {
    validLocalData();

    if (surveyQuestionsHandles.length === 0) {
        return false;
    }


    let isValid = true
    for (const h of surveyQuestionsHandles) {
        if (!h.valid()) {
            isValid = false
        }
    }

    isReadyToSave.value = isValid;

    return isValid;
}

function validLocalData(): boolean {
    errors.value = {
        title: isTitleError(),
        password: isPasswordError(),
    }

    return Object.values(errors.value).every(value => value === false);
}

const isTitleError = (): boolean => {
    return survey.value.title.trim().length === 0;
}

const isPasswordError = (): boolean => {
    return survey.value.passwordRequired && survey.value.password.trim().length < 6;
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
                                <InputText
                                    v-model="survey.title" placeholder="Title"
                                    :error="errors?.title ? 'The field cannot remain empty' : ''"
                                />
                                <OnOff v-model="survey.draft" label="Draft" />
                                <OnOff v-model="survey.passwordRequired" label="Password required" />
                                <InputText
                                    v-if="survey.passwordRequired"
                                    v-model="survey.password"
                                    placeholder="Password"
                                    label="Password:"
                                    :error="errors?.password ? 'Enter at least 6 characters' : ''"
                                />
                                <Btn v-if="false" type="dark" @click="validateAllData">
                                    <div class="flex items-center">
                                        <div class="flex-1">Check the form</div>
                                        <div class="text-xs">{{ isReadyToSave ? 'PASSED' : 'REJECTED' }}</div>
                                    </div>
                                </Btn>
                                <Btn type="success" class="w-full" @click="save">Save</Btn>
                                <Separator class="pt-6" fullVisibility :clickable="false">Details</Separator>
                                <p class="flex gap-2 items-center text-sm text-gray-600">
                                    Created questions:
                                    <Pill>{{ survey.questions?.length }}</Pill>
                                </p>
                                <Separator class="pt-6" fullVisibility :clickable="false">Time details</Separator>
                                <p class="text-sm text-gray-600">
                                    First save:
                                    {{ survey.createdAt }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    Last save:
                                    {{ survey.updatedAt }}
                                </p>
                                
                                <!-- 
                                <Btn type="primary" @click="addQuestion(surveyOptions.length, 'dropdown-options')">Dropdown options</Btn>
                                <Btn type="primary" @click="addQuestion(surveyOptions.length, 'date-choice')">Date choice</Btn> -->
                            </div>
                        </div>
                    </div>
                    <div class="flex-1 mt-16 md:mt-0">
                        <div class="text-xl mb-4">Survey questions</div>

                        <div class="grid gap-4 grid-cols-1">
                            <template v-for="(surveyOption, index) in survey.questions" :key="'query-' + index">
                                <component
                                    :is="SURVEY_COMPONENT_MAP[surveyOption.type].c"
                                    :question="surveyOption"
                                    :index="index"
                                    :is-first="index === 0"
                                    :is-last="index === (survey.questions?.length ?? 0) - 1"
                                    @move-up="moveUp"
                                    @move-down="moveDown"
                                    @remove="remove"
                                    @add-question="addQuestion"
                                />
                            </template>
                        </div>

                        <p
                            v-if="(survey.questions?.length ?? 0) === 0"
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