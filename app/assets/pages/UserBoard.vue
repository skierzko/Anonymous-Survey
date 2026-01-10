<script setup lang="ts">
import UserBoardLayout from './layout/UserBoardLayout.vue';
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
                User board
            </section>
        </template>
    </UserBoardLayout>
</template>