<script setup lang="ts">
</script>

<template>
    <section class="slider flex items-center justify-center m-0 text-white">
        <slot></slot>
    </section>
</template>

<style scoped lang="scss">
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