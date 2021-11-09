<template>
    <div id="edit_category">
         <div class="container">
                <div class="row ">
                   <div class="col-md-12">
                       <div class="header">
                           <h3>Edit Category</h3>
                       </div>
                       <div class='float-right' style='margin:10px 40px 15px 0px;'>
                           <router-link :to="{name:'all_category'}" class='btn btn-primary'>All Category</router-link>
                       </div>
                            <div class="col-md-8">
                                     <form @submit.prevent='updateCategory'> 
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
    name:'edit_category',
    data(){
     return {
        form:{
            category_name:'',
            },
            errors:{}
        }
    },
    created(){
        if(!User.hasLoggedIn){
            return this.$router.push({name:'/'});
        }
    } ,
   
    methods:{
       updateCategory(){
           let id = this.$route.params.id;
           console.log(id);
           axios.patch('/api/category/'+id,this.form).then(()=>{ Notification.success(); return this.$router.push({name:'all_category'});  }).catch((err)=>console.log(err.response.data));

         }
       },
    created(){
        let id = this.$route.params.id;
        axios.get('/api/category/'+id).then((response) =>(this.form = response.data) ).catch(err=>console.log(err.response.data));
    },
    
}
</script>