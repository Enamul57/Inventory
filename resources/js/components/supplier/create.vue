<template>
    <div id="create_supplier">
         <div class="container">
                <div class="row ">
                   <div class="col-md-12">
                       <div class="header">
                           <h3>Add Supplier</h3>
                       </div>
                       <div class='float-right' style='margin:10px 40px 15px 0px;'>
                           <router-link :to="{name:'all_supplier'}" class='btn btn-primary'>All Suppliers</router-link>
                       </div>
                            <div class="col-md-8">
                                    <form @submit.prevent='addSupplier'>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                            <label for="inputEmail4">Supplier Name</label>
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
                                            <div class="form-group col-md-6">
                                            <label for="inputEmail4">ShopName</label>
                                            <input type="text" class="form-control" id="inputEmail4" v-model='form.shopName'>
                                            <small class="text text-danger" v-if='errors.shopName'>{{errors.shopName[0]}}</small>
                                            </div>
                                            <div class="form-group col-md-8">
                                                <div class="form-row">
                                                    <div class="col-md-6">
                                                    <label for="exampleFormControlFile1">Choose File</label>
                                                     <input type="file" class="form-control-file" id="" @change='onFileSelected'>
                                                </div>
                                                <div class="col-md-6">
                                                    <img :src="form.photo" alt="" style='width:40px;height:40px;'>
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
    name:'create_supplier',
    created(){
        if(!User.hasLoggedIn){
            return this.$router.push({name:'/'});
        }
    },
    data(){
        return {
            form:{
                name: null,
                email: null,
                phone:null,
                address: null,
                photo:null,
                shopName:null,
            },
            errors:{

            }
        }
    },
    methods:{
        addSupplier(){
           axios.post('/api/supplier',this.form).

                then(()=>{
                    Notification.success();
                    this.$router.push({name:'all_supplier'});
                }).
                    catch(error => {
                         this.errors = error.response.data.errors;
                       console.log(error.response.data);
                    }); 
        },
        onFileSelected(event){
            let file = event.target.files[0];
           
            if(file.size > 1000000){
                Notification.image_validation();
            }
            else{
                let reader = new FileReader();
                reader.onload = event => {
                    this.form.photo = event.target.result;
                    console.log(event.target.result);
                }
                reader.readAsDataURL(file);
            }
        }
    }
}
</script>
<style scoped>
    #create_supplier{
        margin-top: 20px;
        margin-left: 20px;
    }
</style>