<template>
  <div id="all_employee">
    <div class="container">
      <div class="row mt-3 ml-3">
        <h3>POS Dashboard</h3>
      </div>
      <div class="container-fluid px-4">
        <div class="row">
          <div class="col-xl-5">
            <div class="card mb-1">
              <div class="card-header">
                <i class="fas fa-chart-area me-1"></i>
                <span style="color: blue"> Expense Insert</span>
                <button class="btn btn-primary float-right">
                  Add Customer
                </button>
              </div>
              <div class="card-body">
                <canvas id="myAreaChart" width="100%" height="40"></canvas>
                <table class="table custom_table">
                  <thead>
                    <tr>
                      <th scope="col">Name</th>
                      <th scope="col">Quantity</th>
                      <th>Unit</th>
                      <th scope="col">Total</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="cart in carts" :key="cart.product_id">
                      <td>{{ cart.product_name }}</td>
                      <td>
                        <input
                          type="text"
                          style="width: 30px; text-align: center"
                          :value="cart.product_quantity"
                        />
                        <div>
                          <button
                            @click.prevent="increment(cart.product_id)"
                            class="btn btn-sm btn-primary count"
                          >
                            +
                          </button>
                          <button
                            @click.prevent="decrement(cart.product_id)"
                            class="btn btn-sm btn-danger count" v-if='cart.product_quantity >1'
                          >
                            -
                          </button>
                            <button
                            @click.prevent="decrement(cart.product_id)"
                            class="btn btn-sm btn-danger count" v-else disabled=''
                          >
                            -
                          </button>
                        </div>
                      </td>
                      <td>{{ cart.product_price }}</td>
                      <td>{{ cart.sub_total }}</td>
                      <td>
                        <a
                          @click="removeItem(cart.id)"
                          class="btn btn-sm btn-primary"
                          style="color: white"
                        >
                          X
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="card-footer">
                <ul class="list-group">
                  <li
                    class="
                      list-group-item
                      d-flex
                      justify-content-between
                      align-items-center
                    "
                  >
                  </li>
                  <li
                    class="
                      list-group-item
                      d-flex
                      justify-content-between
                      align-items-center
                    "
                  >
                    Total Quantity: <strong>{{qty}}</strong>
                  </li>
                  <li
                    class="
                      list-group-item
                      d-flex
                      justify-content-between
                      align-items-center
                    "
                  >
                    Sub Total : <strong>{{subtotal}}</strong>
                  </li>
                  <li
                    class="
                      list-group-item
                      d-flex
                      justify-content-between
                      align-items-center
                    " 
                  >
                    Vat : <strong>{{vat}}%</strong>
                  </li>
                  <li
                    class="
                      list-group-item
                      d-flex
                      justify-content-between
                      align-items-center
                    "
                  >
                    Total Amount : <strong>{{subtotal  + (subtotal * vat)/100}}</strong>
                  </li>
                </ul>
                <br />
                <form action="">
                  <label for="">Customer name</label>
                  <select class="form-control" >
                    <option
                      :value="customer.id"
                      v-for="customer in customers"
                      :key="customer.id"
                    >
                      {{ customer.name }}
                    </option>
                  </select>
                  <label for="">Pay</label>
                  <input type="text" class="form-control" id=""/>
                  <label for="">Due</label>
                  <input type="text" class="form-control" id=""/>
                  <label for="">Payment Method</label>
                  <select class="form-control">
                    <option value="handCash">Hand Cash</option>
                    <option value="payPal">Paypal</option></select
                  ><br />
                  <button type="submit" class="btn btn-success">Submit</button>
                </form>
              </div>
            </div>
          </div>
          <div class="col-xl-7">
            <div class="card mb-2">
              <div class="card-header">
                <i class="fas fa-chart-bar me-1"></i>
                <span style="color: blue"> Product Portfolio</span>
                <input
                  type="search"
                  v-model="searchTerm"
                  class="form-control rounded"
                  style="width: 400px"
                  placeholder="Search"
                  aria-label="Search"
                  aria-describedby="search-addon"
                />
              </div>
              <div class="card-body">
                <canvas id="myBarChart" width="100%" height="0"></canvas>

                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                  <li class="nav-item" role="presentation">
                    <button
                      class="nav-link active"
                      id="pills-home-tab"
                      data-bs-toggle="pill"
                      data-bs-target="#pills-home"
                      type="button"
                      role="tab"
                      aria-controls="pills-home"
                      aria-selected="true"
                    >
                      All Product
                    </button>
                  </li>
                  <li
                    class="nav-item"
                    role="presentation"
                    v-for="category in categories"
                    :key="category.id"
                  >
                    <button
                      class="nav-link"
                      id="pills-profile-tab"
                      data-bs-toggle="pill"
                      data-bs-target="#pills-profile"
                      type="button"
                      role="tab"
                      aria-controls="pills-profile"
                      @click="subproduct(category.id)"
                      aria-selected="false"
                    >
                      {{ category.category_name }}
                    </button>
                  </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                  <div
                    class="tab-pane fade show active"
                    id="pills-home"
                    role="tabpanel"
                    aria-labelledby="pills-home-tab"
                  >
                    <div class="row mt-1">
                      <div
                        class="col-lg-3 col-md-3 col-sm-6 col-6"
                        v-for="product in filterSearch"
                        :key="product.id"
                      >
                        <button
                          class="btn btn-sm"
                          @click.prevent="addToCart(product.id)"
                        >
                          <div class="card mb-4" style="width: 8.5rem">
                            <img
                              class="card-img-top"
                              :src="product.image"
                              id="imgId"
                            />
                            <div class="card-body">
                              <span class="card-title">{{
                                product.product_name
                              }}</span>
                              <td v-if="product.product_quantity >= 1">
                                <span class="badge badge-success"
                                  >Available - {{ product.product_quantity }} in
                                  stock</span
                                >
                              </td>
                              <td v-if="product.product_quantity < 1">
                                <span class="badge badge-danger"
                                  >Stock Out</span
                                >
                              </td>
                            </div>
                          </div>
                        </button>
                      </div>
                    </div>
                  </div>
                  <div
                    class="tab-pane fade"
                    id="pills-profile"
                    role="tabpanel"
                    aria-labelledby="pills-profile-tab"
                  >
                    <div class="row mt-1">
                      <div
                        class="col-lg-3 col-md-3 col-sm-6 col-6"
                        v-for="getproduct in getFilterSearch"
                        :key="getproduct.id"
                      >
                        <button
                          class="btn btn-sm"
                          @click.prevent="addToCart(getproduct.id)"
                        >
                          <div class="card mb-4" style="width: 8.5rem">
                            <img
                              class="card-img-top"
                              :src="getproduct.image"
                              alt="Card image cap"
                              id="imgId"
                            />
                            <div class="card-body">
                              <span class="card-title">{{
                                getproduct.product_name
                              }}</span>
                              <td v-if="getproduct.product_quantity >= 1">
                                <span class="badge badge-success"
                                  >Available -
                                  {{ getproduct.product_quantity }} in
                                  stock</span
                                >
                              </td>
                              <td v-if="getproduct.product_quantity < 1">
                                <span class="badge badge-danger"
                                  >Stock Out</span
                                >
                              </td>
                            </div>
                          </div>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "all_product",
  created() {
    if (!User.hasLoggedIn()) {
      return this.$router.push({ name: "/" });
    }
  },
  created() {
    this.allproduct();
    this.allcategory();
    this.allcustomer();
    this.vats();
    Reload.$on("AfterAdd", () => {
      this.showCartItem();
    });
  },
  data() {
    return {
      products: [],
      searchTerm: "",
      categories: "",
      getproducts: [],
      customers: "",
      carts: [],
      vat: '',
    };
  },
  methods: {
    allproduct() {
      axios
        .get("/api/products")
        .then(({ data }) => {
          this.products = data;
        })
        .catch((err) => console.log(err.data));
    },
    allcategory() {
      axios
        .get("/api/category")
        .then(({ data }) => {
          this.categories = data;
        })
        .catch((err) => console.log(err.data));
    },
    subproduct(id) {
      axios
        .get("/api/pos/"+id)
        .then(({ data }) => {
          this.getproducts = data;
        })
        .catch((err) => console.log(err.data));
    },
    allcustomer() {
      axios
        .get("/api/customer")
        .then(({ data }) => (this.customers = data))
        .catch((err) => console.log(err.data));
    },
    addToCart(id) {
      axios
        .get("/api/cart/" + id)
        .then(({ data }) => {
         
          Reload.$emit("AfterAdd");
        })
        .catch((err) => console.log(err.data));
    },
    showCartItem() {
      axios
        .get("/api/cart/")
        .then(({ data }) => {this.carts = data;})

        .catch((err) => console.log(err.data));
    },
    removeItem(id) {
      axios
        .delete("/api/cart/" + id)
        .then(() => {
          Reload.$emit("AfterAdd");
          Notification.delete();
         
        })
        .catch((err) => console.log(err.data));
    },
    increment(id) {
        console.log(id);
      axios
        .get("/api/cart/increment/" + id)
        .then(({ data }) => {
          Reload.$emit("AfterAdd");
          
        })
        .catch();
    },
    decrement(id) {
      axios
        .get("/api/cart/decrement/" + id)
        .then(() => {
          Reload.$emit("AfterAdd");
          
        })
        .catch();
    },
    vats(){
      axios.get('/api/vat/').then(({data})=>{
          this.vat = data.vat;
        }).catch((err) => console.warn(err.data+" something went wrong!!"))
    },
  

  },

  computed: {
    filterSearch() {
      return this.products.filter((product) => {
        return product.product_name.match(this.searchTerm);
      });
    },
    getFilterSearch() {
      return this.getproducts.filter((getproduct) => {
        return getproduct.product_name.match(this.searchTerm);
      });
    },
    qty(){
      let sum = 0;
      for(let i = 0; i< this.carts.length; i++){
        sum += parseInt(this.carts[i].product_quantity);
      }
      return sum;
    },
    subtotal(){
      let sum = 0;
      for(let i =0;i < this.carts.length;i++){
        sum += parseInt(this.carts[i].sub_total);
      }
      return sum;
    }
    
  },
};
</script>
<style scoped>
#all_product {
  margin-top: 50px;
  margin-left: 20px;
}
#imgId {
  width: 100px;
  height: 130px;
}
.count {
  margin-top: 5px;
}
.custom_table {
  padding: 0;
}
</style>