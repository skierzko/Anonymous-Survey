<script setup lang="ts">
import { User } from '../types/User';
import NoLoginLayout from './layout/NoLoginLayout.vue';

const props = defineProps<{
    csrfToken: string,
    userLogged?: User,
}>()
</script>

<template>
    <NoLoginLayout>
        <template v-slot:presentation_section>
            <div class="card px-6 py-4 my-20 max-w-[800px] rounded-2xl text-center bg-white/10 mx-4">
                <h1 class="p-2 leading-10 text-4xl sm:leading-14">Create surveys and share them anonymously for completion</h1>
                <p class="mb-4 p-4">Join the people who are already creating their anonymous surveys.</p>

                <RouterLink
                    to="/login"
                    class="inline-block bg-white text-black mb-6 px-6 py-2 rounded-full font-semibold hover:bg-gray-200 transition duration-300"
                >
                    Let's start! 🚀
                </RouterLink>

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
                    <RouterLink to="/survey/show/01khbj4dd6r0kpcv42dy28ec74">
                        <div class="p-6 bg-gray-100 rounded-sm shadow-sm hover:shadow-md transition duration-300 mb-4">
                            <h3 class="text-xl mb-2">Survey about games</h3>
                            <p class="text-gray-700 mb-2">This survey gathers insights into participants’ opinions, preferences, and experiences related specifically to this game-focused questionnaire.</p>
                        </div>
                    </RouterLink>
                    
                    <RouterLink to="/survey/show/01khbks4zf8hmyxfy0gfjrav2q">
                        <div class="p-6 bg-gray-100 rounded-sm shadow-sm hover:shadow-md transition duration-300 mb-4">
                            <h3 class="text-xl mb-2">Survey about movies</h3>
                            <p class="text-gray-700 mb-2">This survey collects participants’ opinions, preferences, and viewing experiences related to movies.</p>
                        </div>
                    </RouterLink>

                    <RouterLink to="/survey/show/01khbbnzx7p9vnf7eedwdwve0f">
                        <div class="p-6 bg-gray-100 rounded-sm shadow-sm hover:shadow-md transition duration-300 mb-4">
                            <h3 class="text-xl mb-2">Survey about programming</h3>
                            <p class="text-gray-700 mb-2">This survey explores participants’ programming experience, preferred technologies, and development practices.</p>
                        </div> 
                    </RouterLink>
                    
                </div>
            </section>
        </template>
    </NoLoginLayout>
</template>