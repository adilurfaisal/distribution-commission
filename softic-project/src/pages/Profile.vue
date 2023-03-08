<template>
  <div class="row flex flex-center">
    <q-form class="col-12 col-md-4 q-mt-md" @submit="create_account">
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
              readonly
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
              readonly
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
              v-model="user.rule_name"
              label="Rule"
              readonly
              hide-bottom-space
            >
              <template v-slot:prepend>
                <q-icon name="switch_access_shortcut_add" />
              </template>
            </q-input>
            <q-input
              dark
              dense
              square
              filled
              v-model="user.promo_code"
              :type="promoShow ? 'password' : 'text'"
              label="Promo Code"
              readonly
              hide-bottom-space
            >
              <template v-slot:prepend>
                <q-icon name="lock" />
              </template>
              <template v-slot:append>
                <q-icon
                  :name="promoShow ? 'visibility_off' : 'visibility'"
                  class="cursor-pointer"
                  @click="promoShow = !promoShow"
                />
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
        name: "",
        email: "",
        rule_name: "",
        promo_code: "",
      },
      promoShow: true,
    };
  },
  async mounted() {
    await this.getProfile();
  },
  methods: {
    async getProfile() {
      Loading.show();
      api
        .get("/profile", this.user)
        .then((res) => {
          let data = res.data;
          this.user = data;
        })
        .catch((error) => {})
        .finally(() => {
          Loading.hide();
        });
    },
  },
});
</script>
