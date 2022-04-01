<template>
  <div id="create_category">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="header">
            <h3>Add Expense</h3>
          </div>
          <div class="float-right" style="margin: 10px 40px 15px 0px">
            <router-link :to="{ name: 'all_expense' }" class="btn btn-primary"
              >All Expense</router-link
            >
          </div>
          <div class="col-md-8">
            <form @submit.prevent="addExpense">
              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="inputEmail4">Expense Details</label>
                  <input
                    type="text"
                    class="form-control"
                    id="inputEmail4"
                    v-model="form.details"
                  />
                  <small class="text text-danger" v-if="errors.details">{{
                    errors.details[0]
                  }}</small>
                </div>
                                <div class="form-group col-md-12">
                  <label for="inputEmail4">Expense Amount</label>
                  <input
                    type="text"
                    class="form-control"
                    id="inputEmail4"
                    v-model="form.amount"
                  />
                  <small class="text text-danger" v-if="errors.amount">{{
                    errors.amount[0]
                  }}</small>
                </div>


              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "add_expense",
  created() {
    if (!User.hasLoggedIn) {
      return this.$router.push({ name: "/" });
    }
  },
  data() {
    return {
      form: {
        details:'',
        amout:'',
      },
      errors: {},
    };
  },
  methods: {
    addExpense() {
      axios
        .post("/api/expense", this.form)
        .then(() => {
          Notification.success();
          this.$router.push({ name: "all_expense" });
        })
        .catch((error) => {
          this.errors = error.response.data.errors;
        });
    },
  },
};
</script>
<style scoped>
#create_category {
  margin-top: 20px;
  margin-left: 20px;
}
</style>