<script setup lang="ts">
import { ref } from 'vue';
import { Survey } from '../models/Survey';
import Pill from '../../components/Pill.vue';
import OnlineDot from '../../components/OnlineDot.vue';
import { ChevronRight, Key, ListTree, Pencil, Globe, MessagesSquare } from 'lucide-vue-next';
import dayjs from 'dayjs';
import Btn from '../../components/Btn.vue';
import Modal from '../../components/Modal.vue';
import SurveyResultQuestions from './surveyResults/SurveyResultQuestions.vue';

const props = defineProps<{ survey: Survey }>();

const publicAt = props.survey.publicAt ? dayjs(props.survey.publicAt).format('YYYY-MM-DD HH:mm') : null;
</script>

<template>
    <div
        class="flex items-center mt-4 sm:mt-0 mb-4 p-2 border-1 border-gray-400 bg-gray-100 rounded-sm"
        :class="[survey.isPublic && 'border-b-2 border-green-600']"
    >
        <div class="flex-1">
            <div class="sm:flex">
                <div class="flex-1">
                    <Pill>
                        <RouterLink :to="'/survey/' + survey.id">
                            <span class="hover:font-bold">{{ survey.title }}</span>
                        </RouterLink>
                    </Pill>
                </div>
                <div class="flex mt-2 sm:mt-0">
                    <div>
                        <Modal>
                            <template #title>
                                <h3 class="text-lg font-bold">Survey Results</h3>
                            </template>
                            <template #default="{ showModal }">
                                <Btn class="p-0! m-0!" variant="ghost" @click="showModal()">
                                    <Pill variant="success" title="Number of responses">
                                        <MessagesSquare :size="18" class="mr-1"  />
                                        {{ survey?.results?.length ?? 0 }}
                                    </Pill>
                                </Btn>
                            </template>
                            <template #modal="{ hideModal }">
                                <SurveyResultQuestions :survey="survey" />
                            </template>
                        </Modal>
                    </div>
                    <div>
                        <Pill>
                            <Pencil v-if="survey.draft" :size="18" class="mr-1"  />
                            <Globe v-else :size="18" class="mr-1"  />
                            {{ survey.draft  ? 'DRAFT' : 'READY' }}
                        </Pill>
                    </div>
                    <div>
                        <Pill>
                            <Key :size="18" class="mr-1" />
                            {{ survey.passwordRequired  ? 'ON' : 'OFF' }}
                        </Pill>
                    </div>
                    <div>
                        <Pill>
                            <ListTree :size="18" class="mr-1"  />
                            {{ survey.questions.length }}
                        </Pill>
                    </div>
                </div>
            </div>
            <div class="pl-2 mt-2 sm:mt-0 sm:pl-0 sm:flex items-center">
                <div class="flex-1 sm:pl-3 text-xs text-gray-600">
                    <b>Slug: </b>
                    {{ survey.slug }}
                </div>
                <OnlineDot :offline="survey.isPublic === false" class="hidden! sm:inline-block" />
                <div class="sm:px-1 text-xs text-gray-600" :class="[! survey.publicAt && 'opacity-50']">
                    <b>Public at: </b>
                    {{ publicAt ?? 'unpublished'}}
                </div>
            </div>
        </div>
        <div>
            <Btn variant="ghost" class="m-0! p-0! hover:scale-150!">
                <RouterLink :to="'/survey/' + survey.id">
                    <ChevronRight :size="20" />
                </RouterLink>
            </Btn>
        </div>
    </div>
</template>