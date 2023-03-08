<template>
  <div class="row flex flex-center">
    <div class="full-width q-pa-md">
      <q-table
        title="Transactions"
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
            :label="totalAmount"
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
  name: "TransactionsPage",
  props: ["user"],
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
          name: "trans_type",
          label: "Type",
          field: "trans_type",
          align: "left",
          sortable: true,
        },
        {
          name: "amount",
          label: "Amount",
          field: "amount",
          align: "center",
          sortable: true,
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
    totalAmount() {
      return this.rows.reduce(function (sum, current) {
        return sum + current.amount;
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
          `/transaction${
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
