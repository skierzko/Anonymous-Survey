<script setup lang="ts">
import { ref, provide, onMounted, watch } from 'vue';
import Btn from '../components/Btn.vue';
import UserBoardLayout from './layout/UserBoardLayout.vue';
import { User } from '../types/User';
import { SURVEY_COMPONENT_MAP, SurveyComponentsKeys } from '../types/SurveyComponentMap';
import { TriangleAlert, Globe, Trash2, ExternalLink } from 'lucide-vue-next';
import InputText from '../components/InputText.vue';
import OnOff from '../components/OnOff.vue';
import Pill from '../components/Pill.vue';
import Separator from '../components/Separator.vue';
import { Survey } from './models/Survey';
import { createSurvey } from './models/factory/Survey.factory';
import type { SurveyQuestionHandle, SurveyQuestionRegistry } from './registers/SurveyQuestionRegistry';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import { useSurveyStore } from '../stores/survey';
import dayjs from 'dayjs';
import { useRouter } from 'vue-router';
import Confirm from '../components/Confirm.vue';
import NotifyBar from '../components/NotifyBar.vue';

const surveyStore = useSurveyStore();
const router = useRouter();

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

onMounted(async () => {
    await loadSurvey();
});

const loadSurvey = async (): Promise<void> => {
    if (! props.id) {
        surveyStore.isDeleted = false;
        return;
    }

    await surveyStore.fetchSurveyByUserAndSurveyId(props.id);

    if (surveyStore.surveys.length !== 1) {
        toast.error('Survey not found', {
            position: toast.POSITION.TOP_RIGHT,
            autoClose: 2500,
        });

        router.push('/user-board');

        return;
    }
    
    survey.value = surveyStore.surveys[0];
};

const addQuestion = (index: number, type?: SurveyComponentsKeys) => {
    if (! survey.value.questions) {
        return;
    }

    survey.value.questions.splice(index, 0, {
        uuid: '',
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

    await surveyStore.saveSurvey(survey.value);

    toast.success(
        props.id ? 'Survey updated successfully' : 'Survey created successfully', {
        position: toast.POSITION.TOP_RIGHT,
        autoClose: 1000,
    });

    if (props.id) {
        return;
    }

    setTimeout(() => {  
        // router.push('/survey/' + surveyStore.surveys[0].id); // Spa reload
        window.location.href = `/survey/${surveyStore.surveys[0].id}`; // Full reload
    }, 1000);
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

watch(() => survey.value.isPublic, (newValue) => {
    if (newValue) {
        survey.value.draft = false;
    }
});

watch(() => survey.value.draft, (newValue) => {
    if (newValue) {
        survey.value.isPublic = false;
    }
});

const refs = {
    confirm: ref<InstanceType<typeof Confirm>>(),
};

const deleteSurvey = async (): Promise<void> => {
    if (! props.id) {
        return;
    }

    await surveyStore.deleteSurvey(props.id)

    toast.success('Survey deleted successfully', {
        position: toast.POSITION.TOP_RIGHT,
        autoClose: 2500,
    });

    setTimeout(() => {
        router.push('/user-board');
    }, 2500);
}

const linkToSurvey = () => {
    const baseUrl = window.location.origin;
    return props.id ?  baseUrl + `/survey/show/${survey.value.slug}` : '';
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
            <section v-if="surveyStore.isDeleted" class="p-6 py-20 border-t-2 bg-gray-200">
                <div class="text-center text-xl text-gray-500">
                    <p>Survey has been deleted.</p>
                    <p>
                        Go to <router-link to="/user-board" class="text-blue-600 underline">your dashboard</router-link> to manage your surveys.
                    </p>
                </div>
            </section>
            <section v-else class="p-6 py-20 border-t-2 bg-gray-200">
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
                                <OnOff v-model="survey.isPublic">
                                    <div class="flex gap-2 items-center">
                                        Make public
                                        <Globe class="inline" :size="18" :stroke-width="1.3" />
                                    </div>
                                </OnOff>
                                <OnOff v-model="survey.passwordRequired" label="Password required" />
                                <InputText
                                    v-if="survey.passwordRequired"
                                    v-model="survey.password"
                                    placeholder="Password"
                                    label="Password:"
                                    :error="errors?.password ? 'Enter at least 6 characters' : ''"
                                />
                                <Btn v-if="false" variant="dark" @click="validateAllData">
                                    <div class="flex items-center">
                                        <div class="flex-1">Check the form</div>
                                        <div class="text-xs">{{ isReadyToSave ? 'PASSED' : 'REJECTED' }}</div>
                                    </div>
                                </Btn>
                                <Btn variant="success" class="w-full" @click="save">
                                    <div v-if="surveyStore.saving" class="flex items-center">
                                        <div class="animate-spin mr-2 border-2 border-white border-t-transparent rounded-full w-4 h-4"></div>
                                        Saving...
                                    </div>
                                    <div v-else>
                                        {{ props.id ? 'Update the survey' : 'Create the survey' }}
                                    </div>
                                </Btn>

                                <Separator class="pt-6" fullVisibility :clickable="false">Details</Separator>
                                <p class="flex gap-2 items-center text-sm text-gray-600">
                                    Created questions:
                                    <Pill>{{ survey.questions?.length }}</Pill>
                                </p>
                                <Separator class="pt-6" fullVisibility :clickable="false">Time details</Separator>
                                <p class="text-sm text-gray-600">
                                    Created:
                                    {{ dayjs(survey.createdAt).format('YYYY-MM-DD HH:mm') }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    Updated:
                                    {{ dayjs(survey.updatedAt).format('YYYY-MM-DD HH:mm') }}
                                </p>
                                <p v-if="survey.publicAt" class="text-sm text-gray-600">
                                    Publicated:
                                    {{ dayjs(survey.publicAt).format('YYYY-MM-DD HH:mm') }}
                                </p>

                                <Confirm v-if="props.id"class="w-full">
                                    <template #default="{ showConfirm }">
                                        <div class="flex justify-center">
                                            <Btn
                                                v-if="props.id"
                                                variant="link"
                                                class="text-center text-red-700"
                                                @click="showConfirm()"
                                            >
                                                <div>
                                                    <Trash2 class="inline" />
                                                    Delete survey
                                                </div>
                                            </Btn>
                                        </div>
                                    </template>
                                    <template #confirm>
                                        <div class="flex justify-center">
                                            <Btn
                                                variant="link"
                                                class="flex! gap-1 items-center text-red-700"
                                                @click="deleteSurvey()"
                                            >
                                                <Trash2 />
                                                <div>
                                                    Click to delete
                                                </div>
                                            </Btn>
                                        </div>
                                    </template>
                                </Confirm>
                                
                                <!-- 
                                <Btn variant="primary" @click="addQuestion(surveyOptions.length, 'dropdown-options')">Dropdown options</Btn>
                                <Btn variant="primary" @click="addQuestion(surveyOptions.length, 'date-choice')">Date choice</Btn> -->
                            </div>
                        </div>
                    </div>
                    <div class="flex-1 mt-16 md:mt-0">
                        <div class="text-xl mb-4">Survey questions</div>

                        <NotifyBar v-if="survey.isPublic && survey.id" class="mb-4">
                            <template #icon>
                                <ExternalLink />
                            </template>
                            <template #default>
                                Your survey link:
                                <RouterLink
                                    :to="`/survey/show/${survey.slug}`"
                                    class="ml-1 text-blue-600 underline"
                                > 
                                    {{ linkToSurvey() }}
                                </RouterLink>
                            </template>
                        </NotifyBar>

                        <div
                            v-if="props.id && surveyStore.loading"
                            class="text-center text-xl text-gray-500"
                        >
                            Loading data...
                        </div>
                        <template v-else>
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
                        </template>
                    </div>
                </div>
            </section>
        </template>
    </UserBoardLayout>
</template>