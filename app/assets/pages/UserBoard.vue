<script setup lang="ts">
import Btn from '../components/Btn.vue';
import UserBoardLayout from './layout/UserBoardLayout.vue';
import { DiamondPlus } from 'lucide-vue-next';
import { User } from '../types/User';
import SurveyList from './userBoard/SurveyList.vue';

const props = defineProps<{
    csrfToken: string,
    userLogged?: User,
}>()

</script>

<template>
    <UserBoardLayout>
        <template v-slot:presentation_section>
            <div class="px-6 py-4 max-w-[800px] rounded-2xl text-center mx-4">
                <h1 class="p-2 leading-10 text-4xl sm:leading-14">User board</h1>
            </div>
        </template>
        <template v-slot:default>
            <section class="p-6 py-20 border-t-2 bg-gray-200">
                <div class="text-xl">User board</div>

                <p class="my-6">
                    Welcome to the surveys dashboard. Here you can view existing surveys, create new ones, delete them, and monitor participant engagement.
                </p>

                <div
                    class="gap-4 sm:flex"
                    
                >
                    <div class="sm:w-[200px]">
                        <RouterLink to="/survey-creator">
                            <Btn type="success">
                                <DiamondPlus class="inline-block" />
                                Add survey
                            </Btn>
                        </RouterLink>
                    </div>
                    <div class="flex-4">
                        <SurveyList />
                    </div>
                </div>
            </section>
        </template>
    </UserBoardLayout>
</template>