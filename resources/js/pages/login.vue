<script setup>
import logo from '@images/logo.svg?raw';
import { useVuelidate } from '@vuelidate/core';
import { email, required } from '@vuelidate/validators';
import axios from 'axios';
import { useToast } from 'vue-toast-notification';

const form = ref({
  email: '',
  password: '',
  remember: false,
})
const $cookies = inject('$cookies');
const router = useRouter()
const rules = {
  email: { required, email },
  password: { required },
}

const v$ = useVuelidate(rules, form)

const $toast = useToast();


async function login() {
  this.v$.$touch()
  if (!this.v$.$invalid) {
    try {
      let response = await axios.post('/api/auth/login', form.value);
      $cookies.set('authorization', response.data.token)
      $toast.success("Login Success");
      router.push('/task')

    } catch (error) {
      $toast.error("Unauthorized Access");

    }
  }
  else {
    $toast.error("Unauthorized Access");
  }
}

const isPasswordVisible = ref(false)
</script>

<template>
  <div class="auth-wrapper d-flex align-center justify-center pa-4">
    <VCard class="auth-card pa-4 pt-7" max-width="448">
      <VCardItem class="justify-center">
        <template #prepend>
          <div class="d-flex">
            <div class="d-flex text-primary" v-html="logo" />
          </div>
        </template>

        <VCardTitle class="text-2xl font-weight-bold">
          Task Management System
        </VCardTitle>
      </VCardItem>

      <VCardText class="pt-2">
        <h5 class="text-h5 mb-1">
          Welcome to Task Management System! 👋🏻
        </h5>
        <p class="mb-0">
          Please sign-in to your account and start the adventure
        </p>
      </VCardText>

      <VCardText>
        <VForm @submit.prevent="login()">
          <VRow>
            <!-- email -->
            <VCol cols="12">
              <VTextField v-model="form.email" autofocus placeholder="johndoe@email.com" label="Email" type="email" />
            </VCol>

            <!-- password -->
            <VCol cols="12">
              <VTextField v-model="form.password" label="Password" placeholder="············"
                :type="isPasswordVisible ? 'text' : 'password'"
                :append-inner-icon="isPasswordVisible ? 'bx-hide' : 'bx-show'"
                @click:append-inner="isPasswordVisible = !isPasswordVisible" />

              <br />
              <!-- login button -->
              <VBtn block type="submit">
                Login
              </VBtn>
            </VCol>

            <!-- create account -->
            <VCol cols="12" class="text-center text-base">
              <span>New on our platform?</span>
              <RouterLink class="text-primary ms-2" to="/register">
                Create an account
              </RouterLink>
            </VCol>

            <VCol cols="12" class="d-flex align-center">
            </VCol>
          </VRow>
        </VForm>
      </VCardText>
    </VCard>
  </div>
</template>

<style lang="scss">
@use "@core-scss/template/pages/page-auth.scss";
</style>
