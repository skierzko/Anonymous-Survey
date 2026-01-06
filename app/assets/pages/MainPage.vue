<script setup lang="ts">
</script>

<template>
    <div class="card">
        <h1 class="p-2">Welcome to Anonymous Survey 🚀</h1>
        <p>
            Join the people who are already creating their anonymous surveys.
        </p>

        <div class="buttons">
            <a href="#" class="btn btn-primary">Let's start!</a>
        </div>
    </div>
</template>

<style lang="scss">
    body {
        margin: 0;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: 'Inter', 'Segoe UI', sans-serif;
        background: linear-gradient(270deg, #667eea, #764ba2, #6b8cff);
        background-size: 600% 600%;
        animation: gradientBG 12s ease infinite;
        color: #fff;

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .card {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(12px);
            border-radius: 24px;
            padding: 60px 70px;
            max-width: 520px;
            text-align: center;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.35);
            animation: fadeInUp 1s ease forwards;
            opacity: 0;
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

        h1 {
            font-size: 3rem;
            margin-bottom: 15px;
            letter-spacing: 0.5px;
        }

        p {
            font-size: 1.15rem;
            line-height: 1.6;
            opacity: 0.9;
            margin-bottom: 35px;
        }

        .buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 14px 34px;
            border-radius: 50px;
            font-size: 1rem;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s ease;
        }

        .btn-primary {
            background: #fff;
            color: #764ba2;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
        }

        .btn-secondary {
            border: 2px solid rgba(255, 255, 255, 0.7);
            color: #fff;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-3px);
        }

        footer {
            margin-top: 40px;
            font-size: 0.85rem;
            opacity: 0.7;
        }
    }
</style>