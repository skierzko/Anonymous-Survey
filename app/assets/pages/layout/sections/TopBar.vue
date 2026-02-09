<script setup lang="ts">
import { useRouter } from 'vue-router'
import Btn from '../../../components/Btn.vue';
import { useAuthStore } from '../../../stores/auth';
import { CircleUser, LogOut, UserStar, Form } from 'lucide-vue-next';

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
                <Btn variant="text">Anonymous Survey</Btn>
            </RouterLink>
        </div>
        <div class="grid grid-cols-2 gap-1">
            <template v-if="isLogged">
                <RouterLink to="/user-board">
                    <Btn>
                        User board
                        <CircleUser :size="22" :stroke-width="1.3" class="inline-block" />
                    </Btn>
                </RouterLink>

                <Btn @click="logout">
                    Logout
                    <LogOut :size="22" :stroke-width="1.3" class="inline-block" />
                </Btn>
            </template>
            <template v-else>
                <RouterLink to="/login">
                    <Btn>
                        Login
                        <UserStar :size="22" :stroke-width="1.3" class="inline-block" />
                    </Btn>
                </RouterLink>

                <RouterLink to="/register">
                    <Btn>
                        Register
                        <Form :size="22" :stroke-width="1.3" class="inline-block" />
                    </Btn>
                </RouterLink>
            </template>
            
        </div>
    </section>
</template>