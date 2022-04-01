<template>
    <div id="edit_expense">
         <div class="container">
                <div class="row ">
                   <div class="col-md-12">
                       <div class="header">
                           <h3>Edit expense</h3>
                       </div>
                       <div class='float-right' style='margin:10px 40px 15px 0px;'>
                           <router-link :to="{name:'all_expense'}" class='btn btn-primary'>All Expense</router-link>
                       </div>
                            <div class="col-md-8">
                                     <form @submit.prevent='updateExpense'> 
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                            <label for="inputEmail4"> Expense Details</label>
                                            <input type="text" class="form-control" id="inputEmail4" v-model='form.details'>
                                            <small class="text text-danger" v-if='errors.details'>{{errors.details[0]}}</small>

                                            </div>
                                            <div class="form-group col-md-6">
                                            <label for="inputEmail4"> Expense Amount</label>
                                            <input type="text" class="form-control" id="inputEmail4" v-model='form.amount'>
                                            <small class="text text-danger" v-if='errors.amount'>{{errors.amount[0]}}</small>

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
    name:'edit_expense',
    data(){
     return {
        form:{
            details:'',
            amount:'',
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
       updateExpense(){
           let id = this.$route.params.id;
           console.log(id);
           axios.patch('/api/expense/'+id,this.form).then(()=>{ Notification.success(); return this.$router.push({name:'all_expense'});  }).catch((err)=>console.log(err.response.data));

         }
       },
    created(){
        let id = this.$route.params.id;
        axios.get('/api/expense/'+id).then((response) =>(this.form = response.data) ).catch(err=>console.log(err.response.data));
    },
    
}
</script>