<template>
  <div id="app" :class="{ 'mobile-menu-open': mobileMenuOpen }">
    <router-view />
  </div>
</template>

<script setup>
import { ref } from 'vue'

const mobileMenuOpen = ref(false)
</script>

<style>
#app {
  min-height: 100vh;
  background-color: var(--color-background);
}
</style>