<template>
  <div class="row flex flex-center">
    <q-form class="col-12 col-md-4 q-mt-md" @submit="add_money">
      <q-card class="q-pa-md q-ma-none shadow-6 bg-grey-10">
        <q-card-section>
          <div class="q-gutter-md">
            <q-input
              dark
              dense
              square
              filled
              v-model="form.amount"
              label="Amount"
              mask="#.##"
              fill-mask="0"
              reverse-fill-mask
              lazy-rules
              :rules="[
                (val) => (val && val.length > 0) || 'Please enter amount!',
              ]"
              hide-bottom-space
            >
              <template v-slot:prepend>
                <q-icon name="attach_money" />
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
                label="Add"
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
      form: {
        amount: "",
        trans_type: "add",
      },
    };
  },
  methods: {
    add_money: function () {
      Loading.show();
      api
        .post("/add-money", this.form)
        .then((res) => {
          let data = res.data;
          if (data.success) {
            Notify.create({
              color: "purple",
              message: data.message,
              icon: "check",
            });
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
          this.form.amount = "";
          Loading.hide();
        });
    },
  },
});
</script>
