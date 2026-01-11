<script setup lang="ts">
import { onMounted } from 'vue';
import CookiesInfo from '../../components/CookiesInfo.vue';
import Footer from './sections/Footer.vue';
import TopBar from './sections/TopBar.vue';
import PresentationSection from './sections/PresentationSection.vue';
import { useAuthStore } from '../../stores/auth';

const auth = useAuthStore();

onMounted(async () => {
  if (!auth.user && !auth.loading) {
    await auth.fetchUser()
  }
})
</script>

<template>
    <CookiesInfo>
        This website uses only essential cookies that are necessary for the proper functioning of the system and the user login process.
        These cookies are not used for analytical or marketing purposes and do not require user consent.
    </CookiesInfo>

    <TopBar :isLogged="auth.isAuthenticated" />

    <PresentationSection>
        <slot name="presentation_section"></slot>
    </PresentationSection> 

    <slot></slot>

    <Footer />
</template>