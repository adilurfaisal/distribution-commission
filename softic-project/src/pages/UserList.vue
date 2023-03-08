<template>
  <div class="row flex flex-center">
    <div class="full-width q-pa-md">
      <q-table
        title="User List"
        separator="cell"
        class="my-sticky-header-table q-mb-xl"
        :loading="loading"
        :rows="rows"
        :columns="columns"
        row-key="id"
        :rows-per-page-options="[0]"
        style="max-height: 80vh"
      >
        <template v-slot:header="props">
          <q-tr :props="props" class="bg-table-header">
            <q-th
              v-for="col in props.cols"
              :key="col.name"
              :props="props"
              class="text-black"
            >
              {{ col.label }}
            </q-th>
          </q-tr>
        </template>

        <template v-slot:body="props">
          <q-tr :props="props">
            <q-td key="name" :props="props">
              {{ props.row.name }}
            </q-td>
            <q-td key="email" :props="props">
              {{ props.row.email }}
            </q-td>
            <q-td key="promo_code" :props="props">
              {{ props.row.promo_code }}
            </q-td>
            <q-td key="rule_name" :props="props">
              {{ props.row.rule_name }}
            </q-td>
            <q-td key="rule_id" :props="props">
              <div v-if="auth.rule_id == '1'">
                <q-btn
                  v-if="props.row.rule_id == '2' || props.row.rule_id == '3'"
                  :to="{
                    path: 'commission/' + props.row.id,
                  }"
                  flat
                  round
                  color="primary"
                  icon="visibility"
                />
                <q-btn
                  v-else
                  :to="{
                    path: 'transactions/' + props.row.id,
                  }"
                  flat
                  round
                  color="primary"
                  icon="visibility"
                />
              </div>
            </q-td>
          </q-tr>
        </template>
      </q-table>
    </div>
  </div>
</template>
<script>
import { Notify, Loading } from "quasar";
import { defineComponent } from "vue";
import { api } from "boot/axios";

export default defineComponent({
  name: "UserListPage",
  data() {
    return {
      auth: JSON.parse(localStorage.getItem("auth.data")),
      loading: false,
      rows: [],
      columns: [
        {
          name: "name",
          label: "Name",
          field: "name",
          align: "left",
          sortable: true,
        },
        {
          name: "email",
          label: "Email",
          field: "email",
          align: "left",
          sortable: true,
        },
        {
          name: "promo_code",
          label: "Promo Code",
          field: "promo_code",
          align: "center",
          sortable: true,
        },
        {
          name: "rule_name",
          label: "Rule",
          field: "rule_name",
          align: "center",
          sortable: true,
        },
        {
          name: "rule_id",
          label: "Action",
          field: "rule_id",
          align: "center",
        },
      ],
    };
  },
  async mounted() {
    setTimeout(async () => {
      await this.load_user_list();
    }, 500);
  },
  methods: {
    async load_user_list() {
      Loading.show();
      api
        .get("/user-list")
        .then((res) => {
          if (res.data) {
            this.rows = res.data.length > 0 ? res.data : [];
          }
        })
        .catch((error) => {})
        .finally(() => {
          Loading.hide();
        });
    },
    onSelection(details) {
      console.log(details);
    },
  },
});
</script>
