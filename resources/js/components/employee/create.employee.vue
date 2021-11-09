<template>
    <div id="create_employee">
         <div class="container">
                <div class="row ">
                   <div class="col-md-12">
                       <div class="header">
                           <h3>Add Employee</h3>
                       </div>
                       <div class='float-right' style='margin:10px 40px 15px 0px;'>
                           <router-link to='all_employee' class='btn btn-primary'>All Employee</router-link>
                       </div>
                            <div class="col-md-8">
                                    <form @submit.prevent='addEmployee'>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                            <label for="inputEmail4">Employee Name</label>
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
                                            <label for="inputEmail4">NID</label>
                                            <input type="text" class="form-control" id="inputEmail4" v-model='form.nid'>
                                            <small class="text text-danger" v-if='errors.nid'>{{errors.nid[0]}}</small>
                                            </div>
                                            <div class="form-group col-md-6">
                                            <label for="inputEmail4">Joining Date</label>
                                            <input type="date" class="form-control" id="inputEmail4" v-model='form.joining_date'>
                                            <small class="text text-danger" v-if='errors.joining_date'>{{errors.joining_date[0]}}</small>
                                            </div>
                                            <div class="form-group col-md-6">
                                            <label for="inputEmail4">Sallery</label>
                                            <input type="text" class="form-control" id="inputEmail4" v-model='form.sallery'>
                                            <small class="text text-danger" v-if='errors.sallery'>{{errors.sallery[0]}}</small>
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
    name:'create_employee',
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
                nid:null,
                joining_date:null,
                sallery:null,
            },
            errors:{

            }
        }
    },
    methods:{
        addEmployee(){
           axios.post('/api/employee',this.form).

                then(()=>{
                    Notification.success();
                    this.$router.push({name:'all_employee'});
                }).
                    catch(error => {
                         this.errors = error.response.data.errors;
                       
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
    #create_employee{
        margin-top: 20px;
        margin-left: 20px;
    }
</style>