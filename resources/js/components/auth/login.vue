<template>
    <div id="login">
        <div class="container">
                        <div class="row ">
                            <div class="col-md-8">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4 ">Login</h3></div>
                                    <div class="card-body" >
                                        <form @submit.prevent='login'>
                                           
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" type="email" v-model='form.email' />
                                                <label for="inputEmail">Email address</label>
                                                <small class='text text-danger' v-if="errors.email">{{errors.email[0]}}</small>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputPassword" type="password" v-model='form.password' />
                                                <label for="inputPassword">Password</label>
                                                <small class='text text-danger' v-if="errors.password">{{errors.password[0]}}</small>

                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox"  />
                                                <label class="form-check-label" >Remember Password</label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <router-link to='/forget'>Forgot Password?</router-link>
                                                <button class='btn btn-primary' type='submit'> Login </button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><router-link to='/register'>Need an account? Sign up!</router-link></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    </div>
</template>
<script type='javascript/text'>
export default {
    name: 'login',
    data(){
        return {
            form: {
                email: null,
                password:null
            },
            errors:{
                email:null,
                password:null
            }
        }
    },
    created(){
        if(User.hasLoggedIn()){
            return this.$router.push({name:'home'});
        } 
        
    },
    methods: {
        login(){
             axios.post('api/login',this.form)
             .then(response=> {
                 User.responseAfterLogin(response);
                 //add sweet alert
                    Toast.fire({
                        icon: 'success',
                        title: 'Signed in successfully'
                    });
                    this.$router.push({name:'home'});
                     }).catch(error=> this.errors = error.response.data.errors)
             
            
        }
    }
}
</script>