<script setup lang="ts">
import { ref } from 'vue'

const props = defineProps<{
    component: string,
    props: Record<string, any>
}>()

const count = ref<number>(0)
</script>

<template>
    <div>
        <router-view />
    </div>
</template>

<style scoped>
.app {
    font-family: sans-serif;
    padding: 40px;
}

button {
    padding: 8px 16px;
    font-size: 16px;
}
</style>