<script setup lang="ts">
import CookiesInfo from '../../components/CookiesInfo.vue';
import Footer from './Footer.vue';
import TopBar from './TopBar.vue';
import PresentationSection from './PresentationSection.vue';
</script>

<template>
    <CookiesInfo>
        This website uses only essential cookies that are necessary for the proper functioning of the system and the user login process.
        These cookies are not used for analytical or marketing purposes and do not require user consent.
    </CookiesInfo>

    <TopBar isLogged />

    <PresentationSection>
        <slot name="presentation_section"></slot>
    </PresentationSection> 

    <slot></slot>

    <Footer />
</template>