<script setup lang="ts">
import Btn from '../components/Btn.vue';
import NoLoginLayout from './layout/NoLoginLayout.vue';
</script>

<template>
    <NoLoginLayout>
        <template v-slot:presentation_section>
            <div class="card px-6 py-4 max-w-[800px] rounded-2xl text-center mx-4">
                <h1 class="p-2 leading-10 text-4xl sm:leading-14">Register</h1>
            </div>
        </template>
        <template v-slot:default>
            <section class="p-6 py-20 border-t-2 bg-white">
                <div class="mb-8 sm:flex">
                    <div class="flex-1 text-3xl">Register</div>
                    <div>You have an account? <RouterLink to="/login"><Btn type="link" class="p-0! m-0!">Log in!</Btn></RouterLink></div>
                </div>
                
                <div>
                    <form class="max-w-md mx-auto">
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 mb-2">Email:</label>
                            <input type="email" id="email" class="w-full px-3 py-2 border rounded" required>
                        </div>
                        <div class="mb-6">
                            <label for="password" class="block text-gray-700 mb-2">Password:</label>
                            <input type="password" id="password" class="w-full px-3 py-2 border rounded" required>
                        </div>
                        <div class="mb-6">
                            <label for="confirm-password" class="block text-gray-700 mb-2">Confirm Password:</label>
                            <input type="password" id="confirm-password" class="w-full px-3 py-2 border rounded" required>
                        </div>
                        <Btn type="primary" class="text-">Register</Btn>
                    </form>
                </div>
            </section>
        </template>
    </NoLoginLayout>
</template>