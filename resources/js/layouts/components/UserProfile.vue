<script setup>
import avatar1 from '@images/avatars/avatar-1.png';
import axios from 'axios';
const $cookies = inject('$cookies');
const router = useRouter()


let name = 'John Doe';

onMounted(async () => {
  let response = await axios.get('/api/auth/me', {
    headers: {
      Authorization: 'Bearer ' + $cookies.get('authorization')
    }
  });
  name = response.data.data.name
})



function logout() {
  $cookies.remove('authorization');
  router.push('/login')
}

</script>

<template>
  <VBadge dot location="bottom right" offset-x="3" offset-y="3" color="success" bordered>
    <VAvatar class="cursor-pointer" color="primary" variant="tonal">
      <VImg :src="avatar1" />

      <!-- SECTION Menu -->
      <VMenu activator="parent" width="230" location="bottom end" offset="14px">
        <VList>
          <!-- 👉 User Avatar & Name -->
          <VListItem>

            <VListItemTitle class="font-weight-semibold">
              {{ name }}
            </VListItemTitle>
            <VListItemSubtitle>Admin</VListItemSubtitle>
          </VListItem>
          <VDivider class="my-2" />

          <!-- 👉 Logout -->
          <VListItem @click="logout">
            <template #prepend>
              <VIcon class="me-2" icon="bx-log-out" size="22" />
            </template>

            <VListItemTitle>Logout</VListItemTitle>
          </VListItem>
        </VList>
      </VMenu>
      <!-- !SECTION -->
    </VAvatar>
  </VBadge>
</template>
