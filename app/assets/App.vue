<script setup lang="ts">
import { ref } from 'vue'
import { User } from './types/User';

const props = defineProps<{
    csrfToken: string,
    userLogged?: User,
}>()

const count = ref<number>(0)
</script>

<template>
    <div>
        <router-view v-bind="props" />
    </div>
</template>