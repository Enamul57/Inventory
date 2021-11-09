<template>
    <div id="register">
       <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Create Account</h3></div>
                                    <div class="card-body">
                                        <form @submit.prevent='register'>
                                            
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 ">
                                                        <input class="form-control" id="inputFirstName" name='name' type="text"   v-model='form.name' required/>
                                                        <label >User name</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control"  type="email" name='email' v-model='form.email' required/>
                                                <label >Email address</label>

                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" type="password" name='password' v-model='form.password'  required/>
                                                        <label for="">Password</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control"  type="password" name='password_confirmation' v-model='form.password_confirmation'/>
                                                        <label for="inputPasswordConfirm">Confirm Password</label>
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class="mt-4 mb-0">
                                                <div class="d-grid"><button class='btn btn-primary'>Create Accout</button></div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><router-link to='/'>Have an account? Go to login</router-link></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    </div>
</template>
<script type='javascript/text'>
export default {
    name: 'register',
    created(){
        if(User.hasLoggedIn()){
            return this.$router.push({name:'home'});

        }
    },
    data(){
        return {
            form:{
                name: null,
                email:null,
                password: null,
                password_confirmation: null
            },
            errors:{}
            
        }
    },
    methods:{
        register(){
            axios.post('api/register',this.form)
            .then(response =>{ 
                User.responseAfterRegister(response);
                Toast.fire({
                icon: 'success',
                title: 'Registered successfully'
                })
                this.$router.push({name:'home'});
                
                }).catch(error=> error);
           console.log(this.errors);
      
        }
    },
    
}
</script>