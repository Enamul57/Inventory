<template>
    <div id="create_category">
         <div class="container">
                <div class="row ">
                   <div class="col-md-12">
                       <div class="header">
                           <h3>Add Category</h3>
                       </div>
                       <div class='float-right' style='margin:10px 40px 15px 0px;'>
                           <router-link to='all_employee' class='btn btn-primary'>All Category</router-link>
                       </div>
                            <div class="col-md-8">
                                    <form @submit.prevent='addCategory'>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                            <label for="inputEmail4">Category Name</label>
                                            <input type="text" class="form-control" id="inputEmail4" v-model='form.category_name'>
                                            <small class="text text-danger" v-if='errors.category_name'>{{errors.category_name[0]}}</small>

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
    name:'create_category',
    created(){
        if(!User.hasLoggedIn){
            return this.$router.push({name:'/'});
        }
    },
    data(){
        return {
            form:{
                category_name: null,
            },
            errors:{

            }
        }
    },
    methods:{
        addCategory(){
           axios.post('/api/category',this.form).

                then(()=>{
                    Notification.success();
                    this.$router.push({name:'all_category'});
                }).
                    catch(error => {
                         this.errors = error.response.data.errors;
                       
                    }); 
        },
    }
}
</script>
<style scoped>
    #create_category{
        margin-top: 20px;
        margin-left: 20px;
    }
</style>