<template>
  <q-page class="flex flex-center">
    <q-btn
      type="a"
      v-for="(mv, mk) in menuFiter"
      :key="mk"
      size="lg"
      :icon="mv.icon"
      :label="mv.label"
      stack
      glossy
      color="blue-grey-10 q-ma-md"
      :to="{ name: mv.name }"
    />
  </q-page>
</template>

<script>
import { defineComponent } from "vue";

export default defineComponent({
  name: "IndexPage",
  data() {
    return {
      auth: JSON.parse(localStorage.getItem("auth.data")),
      menuList: [
        {
          name: "create-account",
          icon: "person_add",
          label: "Create Account",
          rule: [1, 2],
        },
        {
          name: "user-list",
          icon: "group",
          label: "User List",
          rule: [1, 2, 3],
        },
        {
          name: "add-money",
          icon: "call_received",
          label: "Add Money",
          rule: [4],
        },
        {
          name: "transactions",
          icon: "manage_search",
          label: "Transactions",
          rule: [4],
        },
        {
          name: "commission",
          icon: "savings",
          label: "Commission",
          rule: [2, 3],
        },
      ],
    };
  },
  computed: {
    menuFiter() {
      return this.menuList.filter((v) => {
        return v.rule.indexOf(this.auth.rule_id) > -1;
      });
    },
  },
});
</script>
