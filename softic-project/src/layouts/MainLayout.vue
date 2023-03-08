<template>
  <q-layout view="hHh lpR fFf">
    <q-header elevated class="bg-primary text-white">
      <q-toolbar>
        <q-btn
          flat
          round
          color="white"
          icon="arrow_back"
          v-if="this.$route.name != 'menu'"
          @click="$router.go(-1)"
        />
        <q-toolbar-title>
          <q-avatar>
            <img src="https://www.softic.ai/_nuxt/img/star-icon1.0a463ed.png" />
          </q-avatar>
          SOFTIC
        </q-toolbar-title>

        <q-btn-dropdown
          class="q-px-md"
          auto-close
          stretch
          flat
          :label="auth.name"
          dropdown-icon="keyboard_arrow_down"
        >
          <q-list>
            <q-item clickable v-close-popup :to="{ name: 'profile' }">
              <q-item-section>
                <q-item-label>Profile</q-item-label>
              </q-item-section>
            </q-item>
            <q-item clickable v-close-popup @click="logout_confirm()">
              <q-item-section>
                <q-item-label>Logout</q-item-label>
              </q-item-section>
            </q-item>
          </q-list>
        </q-btn-dropdown>
      </q-toolbar>
    </q-header>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>
import { Dialog } from "quasar";
import { defineComponent, ref } from "vue";
import route from "src/router/index";
import { api } from "boot/axios";
export default defineComponent({
  name: "MainLayout",
  data() {
    return {
      auth: JSON.parse(localStorage.getItem("auth.data")),
    };
  },
  mounted() {
    api.defaults.headers.common["Authorization"] =
      "Bearer " + localStorage.getItem("auth.token");
  },
  methods: {
    logout_confirm() {
      Dialog.create({
        title: "Confirm",
        message: "Are you want to logout?",
        cancel: true,
        persistent: true,
      })
        .onOk(() => {
          // console.log('>>>> OK')
          localStorage.removeItem("auth.token");
          localStorage.removeItem("auth.data");
          window.location.href = "/";
        })
        .onCancel(() => {
          // console.log('>>>> Cancel')
        })
        .onDismiss(() => {
          // console.log('I am triggered on both OK and Cancel')
        });
    },
  },
});
</script>
