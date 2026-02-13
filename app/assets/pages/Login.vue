<script setup lang="ts">
import { ref, reactive } from 'vue';
import Btn from '../components/Btn.vue';
import NoLoginLayout from './layout/NoLoginLayout.vue';
import { User } from '../types/User';
import { useRouter } from 'vue-router'
import { login as loginService } from "../pages/services/login";
import NotifyBar from '../components/NotifyBar.vue';
import Pill from '../components/Pill.vue';


const props = defineProps<{
    csrfToken: string,
    userLogged?: User,
}>()

interface LoginForm {
    email: string;
    password: string;
}

const form = reactive<LoginForm>({
    email: '',
    password: '',
});

const testMode = ref<boolean>(true);
const sending = ref<boolean>(false);
const successful = ref<boolean>(false);
const errors = ref<[]>([]);
const router = useRouter()

const login = async (): Promise<void> => {
    if (sending.value) {
        return;
    }

    errors.value = [];
    sending.value = true;

    await loginService.post(
        '',
        {
            email: form.email,
            password: form.password,
            _csrf_token: props.csrfToken,
        },
        {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            withCredentials: true,
        }
    )
    .then((response) => {
        if (response.data.status === true) {
            successful.value = true;
            router.push('/user-board')
            return;
        }

        errors.value = response.data.errors;
    })
    .finally(() => {
        sending.value = false;
    });
};

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
                    <span>Don't have an account yet? <RouterLink to="/register"><Btn variant="link" class="p-0! m-0!">Join us!</Btn></RouterLink></span>
                </div>

                <div>
                    <div v-if="successful" class="text-center">
                        <p class="mb-4 font-bold text-xl text-green-700">Login successfully!</p>
                        <p>You will be redirected to your user page shortly.</p>
                    </div>
                    <form v-else class="max-w-md mx-auto">
                        <div class="mb-4">
                            <NotifyBar v-if="testMode" variant="default" class="block!">
                                A demo mode is available, and you can log in using the credentials provided below.
                                <div class="grid grid-cols-[80px_1fr] mt-4">
                                    <p class="font-bold">Email:</p>
                                    <p class="cursor-pointer" @click="form.email = 'admin@localhost.test'">admin@localhost.test</p>
                                    <p class="font-bold">Password:</p>
                                    <p class="cursor-pointer" @click="form.password = 'password_admin'">password_admin</p>
                                </div>
                            </NotifyBar>

                            <NotifyBar v-if="testMode" variant="danger" class="block! mt-4">
                                The database is refreshed every <b>30 minutes</b>, and all entered data will be permanently lost.
                            </NotifyBar>
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 mb-2">Email:</label>
                            <input v-model="form.email" type="email" id="email" class="w-full px-3 py-2 border rounded" required>
                        </div>
                        <div class="mb-6">
                            <label for="password" class="block text-gray-700 mb-2">Password:</label>
                            <input v-model="form.password" type="password" id="password" class="w-full px-3 py-2 border rounded" required @keyup.enter="login">
                        </div>
                        <Btn variant="primary" @click="login">
                            {{ sending ? 'Sending...' : 'Login' }}
                        </Btn>
                    </form>
                </div>
            </section>
        </template>
    </NoLoginLayout>
</template>