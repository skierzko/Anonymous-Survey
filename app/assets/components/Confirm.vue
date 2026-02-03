<script setup lang="ts">
import { ref } from 'vue';

interface Props {
    time?: number;
}

const props = withDefaults(defineProps<Props>(), {
    time: 3000
});

const show = ref<boolean>(false);

const showConfirm = () => {
    show.value = true;

    setTimeout(() => {
        show.value = false;
    }, props.time);
}

defineExpose({
    showConfirm
});
</script>

<template>
    <div v-if="show" >
        <slot name="confirm"></slot>
    </div>
    <div v-else>
        <slot :showConfirm="showConfirm"></slot>
    </div>
</template>