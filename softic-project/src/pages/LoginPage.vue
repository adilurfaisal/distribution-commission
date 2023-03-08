<template>
  <q-form class="col-10 col-md-3 col-lg-2" @submit="login_submit">
    <q-card class="q-pa-md q-ma-none shadow-6 bg-grey-10">
      <q-card-section class="q-mt-xl q-mb-md">
        <div class="row">
          <div class="col-12 text-center">
            <q-img
              src="https://www.softic.ai/_nuxt/img/star-icon1.0a463ed.png"
              spinner-color="red"
              ratio="1"
              width="100px"
              style="max-width: 90%"
              img-class="rounded-borders"
            ></q-img>
          </div>
        </div>
      </q-card-section>
      <q-card-section>
        <div class="q-gutter-md">
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
              (val) => (val && val.length > 0) || 'Please type something',
            ]"
            hide-bottom-space
            @keyup.enter="login_submit()"
          >
            <template v-slot:prepend>
              <q-icon name="person" />
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
            :rules="[
              (val) => (val && val.length > 0) || 'Please type something',
            ]"
            hide-bottom-space
            @keyup.enter="login_submit()"
          >
            <template v-slot:prepend>
              <q-icon name="lock" />
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
              label="Sign In"
              style="max-width: 120px"
            />
          </div>
          <div class="col-12">
            <p class="text-no-wrap text-grey text-caption text-left">
              <q-btn
                :to="{ name: 'register' }"
                flat
                style="color: #ff0080"
                label="I don't have account"
              />
            </p>
          </div>
        </div>
      </q-card-actions>
    </q-card>
  </q-form>
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
        email: "",
        password: "",
      },
    };
  },
  methods: {
    login_submit: function () {
      let _this = this;
      Loading.show();
      api
        .post("/login", _this.user)
        .then((res) => {
          let data = res.data;
          if (data.success) {
            Notify.create({
              color: "purple",
              message: "Successfully login!",
              icon: "check",
            });
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
          if (error.message) {
            Notify.create({
              color: "negative",
              message: error.message,
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
