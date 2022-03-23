<template>
     <div class="container">
                <div class="row ">
                   <div class="col-md-12">
                       <div class="header">
                           <h3>Add Customer</h3>
                       </div>
                       <div class='float-right' style='margin:10px 40px 15px 0px;'>
                           <router-link to='all_customer' class='btn btn-primary'>All Customer</router-link>
                       </div>
                            <div class="col-md-8">
                                    <form @submit.prevent='addCustomer'>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                            <label for="inputEmail4">Customer Name</label>
                                            <input type="text" class="form-control" id="inputEmail4" v-model='form.name'>
                                            <small class="text text-danger" v-if='errors.name'>{{errors.name[0]}}</small>

                                            </div>

                                            <div class="form-group col-md-6">
                                            <label for="inputEmail4">Email</label>
                                            <input type="email" class="form-control" id="inputEmail4" v-model='form.email'>
                                            <small class="text text-danger" v-if='errors.email'>{{errors.email[0]}}</small>

                                            </div>
                                            <div class="form-group col-md-6">
                                            <label for="inputEmail4">Phone</label>
                                            <input type="text" class="form-control" id="inputEmail4" v-model='form.phone'>
                                            <small class="text text-danger" v-if='errors.phone'>{{errors.phone[0]}}</small>
                                            </div>

                                            <div class="form-group col-md-6">
                                            <label for="inputAddress">Address</label>
                                            <input type="text" class="form-control" id="inputAddress" v-model='form.address' >
                                            <small class="text text-danger" v-if='errors.address'>{{errors.address[0]}}</small>
                                             </div>
                                                                               
                                            <div class="form-group col-md-8">
                                                <div class="form-row">
                                                    <div class="col-md-6">
                                                    <label for="exampleFormControlFile1">Choose File</label>
                                                     <input type="file" class="form-control-file" id="" @change='onFileSelected'>
                                                </div>
                                                <div class="col-md-6">
                                                    <img v-if='click==false' :src="form.newphoto" alt="" style='width:70px;height:90px;'>
                                                    <img v-if='click==true' :src="form.photo" alt="" style='width:70px;height:90px;'>
                                                    
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
</template>
<script>
export default {
    name:'add_customer',
    created(){
        if(!User.hasLoggedIn()){
            return this.$router.push({name:'/'});
        }
    },
    data(){
        return {
            form:{
                name:'',
                email:'',
                phone:'',
                address:'',
                photo:'',
                newphoto:'',
            },
            errors:{

            },
            click:false,

        }
    },
    methods:{
       onFileSelected(event){
           this.click = true;
           const file = event.target.files[0];
           if(file.size > 300000){
               Notification.image_validation();
           }else{
               const reader = new FileReader();
               reader.onload = (event)=>{
                   this.form.photo= event.target.result;
                   console.log(event);
               }
            reader.readAsDataURL(file);
           }
           console.log(this.form.photo);
       },
       addCustomer(){
           axios.post('api/customer',this.form).then(()=>{
               Notification.success();
               this.form = '';
            this.$router.push({name:'all_customer'});
           }).catch(err =>{
               this.errors = err.response.data.errors;
           });
       }
    }
}
</script>