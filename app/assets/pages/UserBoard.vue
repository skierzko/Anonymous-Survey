<script setup lang="ts">
import { ref } from 'vue';
import Btn from '../components/Btn.vue';
import UserBoardLayout from './layout/UserBoardLayout.vue';
import { Survey } from '../types/Survey';
import { DiamondPlus } from 'lucide-vue-next';

const list = ref<Survey[]>([]);

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
                    :class="[list.length === 0 && 'items-center']"
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
                        <div v-if="list.length">
                            List...
                        </div>
                        <div v-else class="text-center text-gray-500">
                            No surveys yet. Create your first one! <DiamondPlus :stroke-with="1" class="inline-block" />
                        </div>
                    </div>
                </div>
            </section>
        </template>
    </UserBoardLayout>
</template>