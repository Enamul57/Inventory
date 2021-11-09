<template>
    <div id="edit_supplier">
         <div class="container">
                <div class="row ">
                   <div class="col-md-12">
                       <div class="header">
                           <h3>Edit Supplier</h3>
                       </div>
                       <div class='float-right' style='margin:10px 40px 15px 0px;'>
                           <router-link :to="{name:'all_employee'}" class='btn btn-primary'>All Supplier</router-link>
                       </div>
                            <div class="col-md-8">
                                     <form @submit.prevent='updateSupplier'> 
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
                                            <label for="inputEmail4">Shop Name</label>
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
                                                    <img :src="form.photo"  style='width:50px;height:50px'>
                                                    
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
    name:'edit_employee',
    created(){
        if(!User.hasLoggedIn){
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
                shopName:'',
                photo:'',
                newphoto:'',
            },
            errors:{

            }
        }
    },
    created(){
        let id = this.$route.params.id;
        axios.get('/api/supplier/'+id).then((response) =>(this.form = response.data) ).catch(err=>console.log(err.response.data));
    },
    methods:{

        onFileSelected(event){
            let file = event.target.files[0];
            let reader = new FileReader();
            reader.onload = (event)=>{
                this.form.newphoto = event.target.result;
                console.log(this.form.newphoto);
            };
            reader.readAsDataURL(file);
            
        },

       updateSupplier(){
           let id = this.$route.params.id;
           console.log(id);
           axios.patch('/api/supplier/'+id,this.form).then(()=>{   this.$router.push({name:'all_supplier'});
            Notification.success(); }).catch((err)=>console.log(err.response.data));

        
       },
       
    }

}
</script>