<script setup lang="ts">
import { ref } from 'vue';
import Btn from './Btn.vue';

const show = ref<boolean>(false);

const showModal = () => {
    show.value = true;
};

const hideModal = () => {
    show.value = false;
};

defineExpose({
    showModal,
    hideModal
});
</script>

<template>
    <slot :showModal="showModal" />
    <teleport to="body">
        <div
            v-if="show"
            class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
        >
            <div class="h-[90vh] overflow-scroll bg-white rounded-sm w-full max-w-[70%]">
                <div class="flex items-center justify-end relative">
                    <div class="flex-1"></div>
                    <div class="flex-1 text-center">
                        <slot name="title" />
                    </div>
                    <div class="flex-1 flex justify-end">
                        <Btn variant="ghost" class="text-xs" @click="hideModal()">Close X</Btn>
                    </div>
                </div>
                <div class="px-4 py-2">
                    <slot name="modal" :hideModal="hideModal" />
                </div>
            </div>
        </div>
    </teleport>
</template>