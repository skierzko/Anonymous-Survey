<script setup lang="ts">
import { ref, onMounted } from 'vue';
import Cookies from 'js-cookie'
import Btn from './Btn.vue';

const showBanner = ref<boolean>(true);

onMounted(() => {
    const accepted = Cookies.get('cookiesAccepted')
    if (accepted === 'true') {
        showBanner.value = false;
    }
})

function acceptCookies() {
  Cookies.set('cookiesAccepted', 'true', { expires: 365 })
  showBanner.value = false
}
</script>

<template>
    <Teleport to="body">
        <div
            v-if="showBanner"
            class="fixed sm:flex max-w-full w-[80%] min-w-[250px] items-center bottom-10 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white px-4 py-2 rounded shadow-lg text-center"
        >
            <div class="flex-1">
                <slot />
            </div>
            <div class="py-2">
                <Btn @click="acceptCookies" class="ml-4 bg-green-600 text-white hover:bg-green-700">
                    I understand
                </Btn>
            </div>
        </div>
    </Teleport>
</template>

