<script setup>
import logo from '@images/logo.svg?raw';
import { useVuelidate } from '@vuelidate/core';
import { email, required } from '@vuelidate/validators';
import axios from 'axios';
import { useToast } from 'vue-toast-notification';

const form = ref({
  name: '',
  email: '',
  password: '',
})

const router = useRouter()
const rules = {
  name: { required },
  email: { required, email },
  password: { required },
}

const v$ = useVuelidate(rules, form)

const $toast = useToast();

async function register() {
  this.v$.$touch()
  if (!this.v$.$invalid) {
    try {
      let response = await axios.post('/api/auth/register', form.value);
      $toast.success("Register Success");
      router.push('/login')
    } catch (error) {
      if (error.response.status == 422) {
        error.response.data.forEach(value => {
          console.log(value);
          $toast.error(value.message);
        })
      }
    }

  }
  else {
    $toast.error("Invalid");
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
          Adventure starts here 🚀
        </h5>
        <p class="mb-0">
          Make your app management easy and fun!
        </p>
      </VCardText>

      <VCardText>
        <VForm @submit.prevent="register()">
          <VRow>
            <!-- Username -->
            <VCol cols="12">
              <VTextField v-model="form.name" autofocus label="Name" @input="v$.name.$touch" @blur="v$.name.$touch"
                :error-messages="v$.name.$errors.map(e => e.$message)" placeholder="Johndoe" />
            </VCol>
            <!-- email -->
            <VCol cols="12">
              <VTextField v-model="form.email" label="Email" @input="v$.email.$touch" @blur="v$.email.$touch"
                :error-messages="v$.email.$errors.map(e => e.$message)" placeholder="johndoe@email.com" type="email" />
            </VCol>

            <!-- password -->
            <VCol cols="12">
              <VTextField v-model="form.password" label="Password" placeholder="············"
                :type="isPasswordVisible ? 'text' : 'password'"
                :append-inner-icon="isPasswordVisible ? 'bx-hide' : 'bx-show'" @input="v$.password.$touch"
                @blur="v$.password.$touch" :error-messages="v$.password.$errors.map(e => e.$message)"
                @click:append-inner="isPasswordVisible = !isPasswordVisible" />

              <br />
              <VBtn block type="submit">
                Sign up
              </VBtn>
            </VCol>

            <!-- login instead -->
            <VCol cols="12" class="text-center text-base">
              <span>Already have an account?</span>
              <RouterLink class="text-primary ms-2" to="/login">
                Sign in instead
              </RouterLink>
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
