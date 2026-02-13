<script setup lang="ts">
import { ref, reactive } from 'vue';
import Btn from '../components/Btn.vue';
import NoLoginLayout from './layout/NoLoginLayout.vue';
import { User } from '../types/User';
import { register as registerService } from "../pages/services/register";
import NotifyBar from '../components/NotifyBar.vue';

const props = defineProps<{
    csrfToken: string,
    userLogged?: User,
}>()

interface RegisterForm {
    email: string;
    password: string;
    confirmPassword: string;
    agree_terms: boolean;
}

const form = reactive<RegisterForm>({
    email: '',
    password: '',
    confirmPassword: '',
    agree_terms: false,
});

const testMode = ref<boolean>(true);
const sending = ref<boolean>(false);
const successful = ref<boolean>(false);
const errors = ref<[]>([]);

const register = async () => {
    if (sending.value || testMode.value) {
        return;
    }

    errors.value = [];
    sending.value = true;

    const data = new URLSearchParams()
    data.append('registration_form[email]', form.email)
    data.append('registration_form[plainPassword][first]', form.password)
    data.append('registration_form[plainPassword][second]', form.confirmPassword)
    data.append('registration_form[agreeTerms]', form.agree_terms ? 'true' : 'false')
    data.append('registration_form[_token]', props.csrfToken ?? '')

    await registerService.post('', data)
    .then((response) => {
        if (response.data.status) {
            successful.value = true;
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
            <div class="px-6 py-4 max-w-[800px] rounded-2xl text-center mx-4">
                <h1 class="p-2 leading-10 text-4xl sm:leading-14">Register</h1>
            </div>
        </template>
        <template v-slot:default>
            <section class="p-6 py-20 border-t-2 bg-white">
                <div class="mb-8 sm:flex">
                    <div class="flex-1 text-3xl">Register</div>
                    <div>You have an account? <RouterLink to="/login"><Btn variant="link" class="p-0! m-0!">Log in!</Btn></RouterLink></div>
                </div>
                
                <div>
                     <div v-if="successful" class="text-center">
                        <p class="mb-4 font-bold text-xl text-green-700">Account created successfully!</p>
                        <p>Your account has been created, but it is not active yet.</p>
                        <p>Please check your email inbox and click the activation link to verify your account.</p>
                        <p class="my-4">If you don’t see the email, make sure to check your spam or junk folder.</p>
                        <p>
                            <b>Best regards</b>,
                            <br />
                            The Team Anonymous Surveys
                        </p>
                    </div>
                    <form v-else class="max-w-md mx-auto">
                        <div class="mb-4">
                            <NotifyBar v-if="testMode" variant="danger">
                                Registration is temporarily disabled for testing purposes.
                            </NotifyBar>
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 mb-2">Email:</label>
                            <input v-model="form.email" :disabled="testMode" type="email" id="email" class="w-full px-3 py-2 border rounded" required>
                            <div v-if="errors.email" class="text-red-700 text-sm">{{ errors.email }}</div>
                        </div>
                        <div class="mb-6">
                            <label for="password" class="block text-gray-700 mb-2">Password:</label>
                            <input v-model="form.password" :disabled="testMode" type="password" id="password" class="w-full px-3 py-2 border rounded" required>
                            <div v-if="errors.first" class="text-red-700 text-sm">{{ errors.first }}</div>
                        </div>
                        <div class="mb-6">
                            <label for="confirm-password" class="block text-gray-700 mb-2">Confirm Password:</label>
                            <input v-model="form.confirmPassword" :disabled="testMode" type="password" id="confirm-password" class="w-full px-3 py-2 border rounded" required>
                            <div v-if="errors.second" class="text-red-700 text-sm">{{ errors.second }}</div>
                        </div>
                        <Btn :disabled="testMode" variant="primary" @click="register">
                            {{ sending ? 'Sending...' : 'Register' }}
                        </Btn>
                    </form>
                </div>
            </section>
        </template>
    </NoLoginLayout>
</template>