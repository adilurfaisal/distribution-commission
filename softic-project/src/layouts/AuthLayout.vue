<template>
  <q-layout view="hHh lpR fFf">
    <q-page-container class="auth-container">
      <q-page class="row justify-center items-center">
        <router-view></router-view>
      </q-page>
    </q-page-container>
  </q-layout>
</template>

<script>
import { defineComponent, ref } from 'vue'
export default defineComponent({
  name: "MainLayout",
});
</script>

<style scoped>
.auth-container{
  background: #1c212c;
}
</style>