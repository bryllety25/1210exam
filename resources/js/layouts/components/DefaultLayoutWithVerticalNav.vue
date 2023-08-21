<script setup>
import VerticalNavLayout from '@layouts/components/VerticalNavLayout.vue'
import VerticalNavLink from '@layouts/components/VerticalNavLink.vue'
import { useTheme } from 'vuetify'

// Components
import Footer from '@/layouts/components/Footer.vue'
import UserProfile from '@/layouts/components/UserProfile.vue'

const vuetifyTheme = useTheme()


</script>

<template>
  <VerticalNavLayout>
    <!-- 👉 navbar -->
    <template #navbar="{ toggleVerticalOverlayNavActive }">
      <div class="d-flex h-100 align-center">
        <!-- 👉 Vertical nav toggle in overlay mode -->
        <IconBtn
          class="ms-n3 d-lg-none"
          @click="toggleVerticalOverlayNavActive(true)"
        >
          <VIcon icon="bx-menu" />
        </IconBtn>

        <VSpacer />

        <UserProfile />
      </div>
    </template>

    <template #vertical-nav-content>
      <VerticalNavLink
        :item="{
          title: 'Task',
          icon: 'bx-home',
          to: '/task',
        }"
      />
      
    </template>


    <slot />

    <!-- 👉 Footer -->
    <template #footer>
      <Footer />
    </template>
  </VerticalNavLayout>
</template>

<style lang="scss" scoped>
.meta-key {
  border: thin solid rgba(var(--v-border-color), var(--v-border-opacity));
  border-radius: 6px;
  block-size: 1.5625rem;
  line-height: 1.3125rem;
  padding-block: 0.125rem;
  padding-inline: 0.25rem;
}
</style>
