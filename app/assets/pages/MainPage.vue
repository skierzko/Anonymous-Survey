<script setup lang="ts">
import CookiesInfo from '../components/CookiesInfo.vue';
import Footer from './layout/Footer.vue';
import NoLoginLayout from './layout/NoLoginLayout.vue';
import PresentationSection from './layout/PresentationSection.vue';
import TopBar from './layout/TopBar.vue';
</script>

<template>
    <NoLoginLayout>
        <template v-slot:presentation_section>
            <div class="card px-6 py-4 my-20 max-w-[800px] rounded-2xl text-center bg-white/10 mx-4">
                <h1 class="p-2 leading-10 text-4xl sm:leading-14">Create surveys and share them anonymously for completion</h1>
                <p class="mb-4 p-4">Join the people who are already creating their anonymous surveys.</p>

                <a href="#" class="inline-block bg-white text-black mb-6 px-6 py-2 rounded-full font-semibold hover:bg-gray-200 transition duration-300">
                    Let's start! 🚀
                </a>
            </div>
        </template>
        <template v-slot:default>
            <section class="p-6 py-20 border-t-2 bg-gray-200">
                <h2 class="mb-16 text-3xl">How it works</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="p-4 bg-green-200 border-b-2 rounded-sm shadow-sm hover:shadow-md transition duration-300">
                        <h3 class="text-xl mb-2 text-green-900">Create an Account</h3>
                        <p class="text-green-700 mb-2">Creating an account is fast, simple, and gives you instant access to everything our platform has to offer.</p>
                        <p class="text-green-700 mb-2">Once registered, you can create and generate unlimited surveys tailored exactly to your needs.</p>
                        <p class="text-green-700 mb-2">Manage your projects with ease, collect responses in real time, and access your results anytime, anywhere.</p>
                        <p class="text-green-700 mb-2">No complicated setup, no unnecessary steps — just sign up and start building powerful surveys that deliver real insights.</p>
                    </div>
                    <div class="p-4 bg-blue-200 border-b-2 rounded-sm shadow-sm hover:shadow-md transition duration-300">
                        <h3 class="text-xl mb-2 text-blue-900">Design Your Survey</h3>
                        <p class="text-blue-700 mb-2">Create surveys exactly the way you want with a wide range of ready-to-use components at your fingertips.</p>
                        <p class="text-blue-700 mb-2">From simple questions to more advanced structures, everything is designed to be intuitive and flexible.</p>
                        <p class="text-blue-700 mb-2">Share your surveys instantly via a public link or protect them with a password for full control over access.</p>
                        <p class="text-blue-700 mb-2">Track performance in real time with clear, easy-to-read statistics — see how many times your survey was opened, completed, or abandoned.</p>
                        <p class="text-blue-700 mb-2">Turn data into insight and optimize your surveys effortlessly.</p>
                    </div>
                    <div class="p-4 bg-rose-200 border-b-2 rounded-sm shadow-sm hover:shadow-md transition duration-300">
                        <h3 class="text-xl mb-2 text-rose-900">Share and Collect Responses</h3>
                        <p class="text-rose-700 mb-2">Distribute your surveys in seconds and start collecting responses instantly.</p>
                        <p class="text-rose-700 mb-2">Share a simple link or secure access with a password to reach exactly the right audience.</p>
                        <p class="text-rose-700 mb-2">Responses are gathered in real time, giving you immediate visibility into participation and engagement.</p>
                        <p class="text-rose-700 mb-2">Whether you’re collecting feedback, conducting research, or validating ideas, our platform makes it easy to reach users and turn responses into actionable insights — faster than ever.</p>
                    </div>
                </div>
            </section>

            <section class="p-6 py-20 border-t-2 bg-white">
                <h2 class="mb-8 text-3xl">View sample surveys</h2>
                <div>
                    <div class="p-6 bg-gray-100 rounded-sm shadow-sm hover:shadow-md transition duration-300 mb-4">
                        <h3 class="text-xl mb-2">Sample Survey 1</h3>
                        <p class="text-gray-700 mb-2">This is a placeholder for a sample survey description.</p>
                    </div>
                    <div class="p-6 bg-gray-100 rounded-sm shadow-sm hover:shadow-md transition duration-300 mb-4">
                        <h3 class="text-xl mb-2">Sample Survey 2</h3>
                        <p class="text-gray-700 mb-2">This is a placeholder for a sample survey description.</p>
                    </div>
                    <div class="p-6 bg-gray-100 rounded-sm shadow-sm hover:shadow-md transition duration-300 mb-4">
                        <h3 class="text-xl mb-2">Sample Survey 3</h3>
                        <p class="text-gray-700 mb-2">This is a placeholder for a sample survey description.</p>
                    </div>
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
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.35);
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