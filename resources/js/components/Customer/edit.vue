<template>
  <div id="edit_customer">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="header">
            <h3>Edit Customer</h3>
          </div>
          <div class="float-right" style="margin: 10px 40px 15px 0px">
            <router-link :to="{ name: 'all_customer' }" class="btn btn-primary"
              >All Customer</router-link
            >
          </div>
          <div class="col-md-8">
            <form @submit.prevent="updateCustomer">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="inputEmail4">Customer Name</label>
                  <input
                    type="text"
                    class="form-control"
                    id="inputEmail4"
                    v-model="form.name"
                  />
                  
                </div>

                <div class="form-group col-md-6">
                  <label for="inputEmail4">Email</label>
                  <input
                    type="email"
                    class="form-control"
                    id="inputEmail4"
                    v-model="form.email"
                  />
                </div>
                <div class="form-group col-md-6">
                  <label for="inputEmail4">Phone</label>
                  <input
                    type="text"
                    class="form-control"
                    id="inputEmail4"
                    v-model="form.phone"
                  />
                </div>

                <div class="form-group col-md-6">
                  <label for="inputAddress">Address</label>
                  <input
                    type="text"
                    class="form-control"
                    id="inputAddress"
                    v-model="form.address"
                  />
                </div>
                <div class="form-group col-md-8">
                  <div class="form-row">
                    <div class="col-md-6">
                      <label for="exampleFormControlFile1">Choose File</label>
                      <input
                        type="file"
                        class="form-control-file"
                        id=""
                        @change="onFileSelected"
                      />
                    </div>
                    <div class="col-md-6">
                      <img v-if='clickOnChoose' :src="newphoto" alt="" style='width:90px;height:90px;'>
                      <img v-else :src="'/'+form.image" alt="" style='width:90px;height:90px;'>
                    </div>
                  </div>
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
  name: "edit_customer",
     created(){
        if(!User.hasLoggedIn){
            return this.$router.push({name:'/'});
        }
    },
  data() {
    return {
      form: {
        name: "",
        email: "",
        phone: "",
        address: "",
        image: "",
        newphoto:'',
      },
      clickOnChoose:false,
      newphoto:'',
    };
  },
  created(){
       this.allCustomer();
  },
  methods: {
    allCustomer() {
      let id = this.$route.params.id;

      console.log(id);
      axios
        .get("/api/customer/" + id)
        .then((response) => {this.form = response.data;console.log(this.form)})
        .catch((err) => {
          console.log(err.response.data);
        });
    },
    updateCustomer(){
        let id = this.$route.params.id;
        
        axios.put('/api/customer/'+id,this.form).then((res)=>{
            Notification.success();
            console.log(res.data);
            this.$router.push({name:'all_customer'});
        }).catch(err=> console.log(err));
    },
    onFileSelected(event){
      this.clickOnChoose = true;
       const file = event.target.files[0];
           if(file.size > 300000){
               Notification.image_validation();
           }else{
               const reader = new FileReader();
               reader.onload = (event)=>{
                   this.newphoto= event.target.result;
                   this.form.newphoto = this.newphoto;
                   console.log(this.form.newphoto);
               }
            reader.readAsDataURL(file);
           
           }
          
    }
  },


};
</script>