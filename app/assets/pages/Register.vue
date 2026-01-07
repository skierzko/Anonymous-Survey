<script setup lang="ts">
import { f } from 'vue-router/dist/router-CWoNjPRp.mjs';
import Btn from '../components/Btn.vue';
import CookiesInfo from '../components/CookiesInfo.vue';
import Footer from './layout/Footer.vue';
import TopBar from './layout/TopBar.vue';
import PresentationSection from './layout/PresentationSection.vue';
</script>

<template>
    <CookiesInfo>
        This website uses only essential cookies that are necessary for the proper functioning of the system and the user login process.
        These cookies are not used for analytical or marketing purposes and do not require user consent.
    </CookiesInfo>

    <TopBar />

    <PresentationSection class="min-h-[200px]">
        <div class="card px-6 py-4 max-w-[800px] rounded-2xl text-center mx-4">
            <h1 class="p-2 leading-10 text-4xl sm:leading-14">Register</h1>
        </div>
    </PresentationSection> 

    <section class="p-6 py-20 border-t-2 bg-white">
        <h2 class="mb-8 text-3xl">Register</h2>
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

    <Footer />
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