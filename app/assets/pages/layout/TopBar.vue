<script setup lang="ts">
import axios from 'axios';
import { useRouter } from 'vue-router'
import Btn from '../../components/Btn.vue';
import { useAuthStore } from '../../stores/auth';

interface Props {
    isLogged: boolean,
}

withDefaults(defineProps<Props>(), {
    isLogged: false,
});

const auth = useAuthStore()
const router = useRouter()

const logout =  async () => {
    await auth.logout()
    router.push('/')
};
</script>

<template>
    <section class="p-2 flex items-center">
        <div class="flex-1 text-xl">
            
            <RouterLink to="/">
                <Btn type="text">Anonymous Survey</Btn>
            </RouterLink>
        </div>
        <div>
            <template v-if="isLogged">
                <RouterLink to="/user-board">
                    <Btn>User board</Btn>
                </RouterLink>

                <Btn @click="logout">Logout</Btn>
            </template>
            <template v-else>
                <RouterLink to="/login">
                    <Btn>Login</Btn>
                </RouterLink>

                <RouterLink to="/register">
                    <Btn>Register</Btn>
                </RouterLink>
            </template>
            
        </div>
    </section>
</template>