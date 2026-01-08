<script setup lang="ts">
import Btn from '../../components/Btn.vue';

</script>

<template>
    <section class="p-2 flex items-center">
        <div class="flex-1 text-xl">
            
            <RouterLink to="/">
                <Btn type="text">Anonymous Survey</Btn>
            </RouterLink>
        </div>
        <div>
            <RouterLink to="/login">
                <Btn>Login</Btn>
            </RouterLink>

            <RouterLink to="/register">
                <Btn>Register</Btn>
            </RouterLink>
        </div>
    </section>
</template>