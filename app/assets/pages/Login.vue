<script setup lang="ts">
import Btn from '../components/Btn.vue';
import NoLoginLayout from './layout/NoLoginLayout.vue';
</script>

<template>
    <NoLoginLayout>
        <template v-slot:presentation_section>
            <div class="card px-6 py-4 max-w-[800px] rounded-2xl text-center mx-4">
                <h1 class="p-2 leading-10 text-4xl sm:leading-14">Login</h1>
            </div>
        </template>
        <template v-slot:default>
            <section class="p-6 py-20 border-t-2 bg-white">
                <div class="mb-8 sm:flex">
                    <h2 class="flex-1 text-3xl">Login</h2>
                    <span>Don't have an account yet? <RouterLink to="/register"><Btn type="link" class="p-0! m-0!">Join us!</Btn></RouterLink></span>
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
                        <Btn type="primary" class="text-">Login</Btn>
                    </form>
                </div>
            </section>
        </template>
    </NoLoginLayout>
</template>

<style lang="scss" scoped>
    .slider {
        font-family: 'Inter', 'Segoe UI', sans-serif;
        background: linear-gradient(270deg, #667eea, #764ba2, #6b8cff);
        background-size: 600% 600%;
        animation: gradientBG 12s ease infinite;

        .card {
            backdrop-filter: blur(12px);
            animation: fadeInUp 1s ease forwards;

            @keyframes gradientBG {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        }
    }
</style>