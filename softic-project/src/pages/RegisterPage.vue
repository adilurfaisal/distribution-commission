<template>
  <div class="row">
    <q-form class="col-12 q-mt-md" @submit="create_account" ref="form">
      <q-card class="q-pa-md q-ma-none shadow-6 bg-grey-10">
        <q-card-section>
          <div class="q-gutter-md">
            <q-input
              dark
              dense
              square
              filled
              v-model="user.name"
              label="Name"
              lazy-rules
              :rules="[
                (val) => (val && val.length > 0) || 'Please type something',
              ]"
              hide-bottom-space
            >
              <template v-slot:prepend>
                <q-icon name="person" />
              </template>
            </q-input>
            <q-input
              type="email"
              dark
              dense
              square
              filled
              v-model="user.email"
              label="Email"
              lazy-rules
              :rules="[
                (val, rules) =>
                  rules.email(val) || 'Please enter a valid email address',
              ]"
              hide-bottom-space
            >
              <template v-slot:prepend>
                <q-icon name="alternate_email" />
              </template>
            </q-input>
            <q-input
              dark
              dense
              square
              filled
              v-model="user.password"
              type="password"
              label="Password"
              lazy-rules
              :rules="[(val) => (val && val.length > 0) || 'Password empty']"
              hide-bottom-space
            >
              <template v-slot:prepend>
                <q-icon name="lock" />
              </template>
            </q-input>
            <q-input
              dark
              dense
              square
              filled
              v-model="user.c_password"
              type="password"
              label="Re-Password"
              lazy-rules
              :rules="[
                (val) => (val && val.length > 0) || 'Re-Password empty!',
                (val) => val == user.password || 'Password not matched!',
              ]"
              hide-bottom-space
            >
              <template v-slot:prepend>
                <q-icon name="lock" />
              </template>
            </q-input>
            <q-input
              dark
              dense
              square
              filled
              v-model="user.promo_code"
              label="Promo Code"
              hide-bottom-space
            >
              <template v-slot:prepend>
                <q-icon name="handshake" />
              </template>
            </q-input>
          </div>
        </q-card-section>
        <q-card-actions>
          <div class="row full-width items-center">
            <div class="col-12 row justify-end">
              <q-btn
                type="submit"
                outline
                rounded
                size="md"
                color="red-4"
                class="full-width text-white"
                label="Create"
                style="max-width: 120px"
              />
            </div>
          </div>
        </q-card-actions>
      </q-card>
    </q-form>
  </div>
</template>
<script>
import { Notify, Loading } from "quasar";
import { defineComponent } from "vue";
import { api } from "boot/axios";

export default defineComponent({
  name: "LoginPage",
  data() {
    return {
      user: {
        name: null,
        email: null,
        password: null,
        c_password: null,
        promo_code: null,
      },
    };
  },
  methods: {
    create_account: function () {
      Loading.show();
      api
        .post("/register", this.user)
        .then((res) => {
          let data = res.data;
          if (data.success) {
            Notify.create({
              color: "purple",
              message: data.message,
              icon: "check",
            });

            this.$refs.form.reset();
            this.$refs.form.resetValidation();

            localStorage.setItem("auth.token", data.data.token);
            localStorage.setItem("auth.data", JSON.stringify(data.data));
            setTimeout(function () {
              window.location.href = "/";
            }, 800);
          } else {
            Notify.create({
              color: "negative",
              message: data.message,
              icon: "report_problem",
            });
          }
        })
        .catch((error) => {
          let err = error.response.data;
          if (err.message) {
            Notify.create({
              color: "negative",
              message: err.message,
              icon: "report_problem",
            });
          } else {
            Notify.create({
              color: "negative",
              message: "Something wrong!",
              icon: "report_problem",
            });
          }
        })
        .finally(() => {
          Loading.hide();
        });
    },
  },
});
</script>
