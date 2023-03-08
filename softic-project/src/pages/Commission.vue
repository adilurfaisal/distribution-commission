<template>
  <div class="row flex flex-center">
    <div class="full-width q-pa-md">
      <q-table
        title="Commission"
        separator="cell"
        :loading="loading"
        :rows="rows"
        :columns="columns"
        row-key="id"
        :rows-per-page-options="[0]"
        style="max-height: 80vh"
      >
        <template v-slot:top-right>
          <q-chip
            square
            color="red"
            text-color="white"
            icon="attach_money"
            :label="totalCommission"
          />
        </template>
      </q-table>
    </div>
  </div>
</template>
<script>
import { date, Notify, Loading } from "quasar";
import { defineComponent } from "vue";
import { api } from "boot/axios";

export default defineComponent({
  name: "UserListPage",
  data() {
    return {
      loading: false,
      rows: [],
      columns: [
        {
          name: "trx_id",
          label: "Trx ID",
          field: "trx_id",
          align: "left",
          sortable: true,
        },
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
          align: "center",
          sortable: true,
        },
        {
          name: "trx_amount",
          label: "Amount ($)",
          field: "trx_amount",
          align: "center",
          sortable: true,
        },
        {
          name: "commissions_amount",
          label: "Com ($)",
          field: "commissions_amount",
          align: "center",
          sortable: true,
        },
        {
          name: "commissions_percent",
          label: "Com. (%)",
          field: "commissions_percent",
          align: "center",
          sortable: true,
          format: (val) => `${val}%`,
        },
        {
          name: "created_at",
          label: "Time",
          field: "created_at",
          align: "center",
          format: (val) =>
            date.formatDate(new Date(val), "DD, MMM YYYY hh:mmA"),
          sortable: true,
        },
      ],
    };
  },
  computed: {
    totalCommission() {
      return this.rows.reduce(function (sum, current) {
        return sum + current.commissions_amount;
      }, 0);
    },
  },
  async mounted() {
    setTimeout(async () => {
      await this.load_commission();
    }, 500);
  },
  methods: {
    async load_commission() {
      Loading.show();
      api
        .get(
          `/commission${
            this.$route.params.id ? "/" + this.$route.params.id : ""
          }`
        )
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
  },
});
</script>
