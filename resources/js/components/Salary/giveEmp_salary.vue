<template>
       <div class='pay'>
       <div class="container">
                <div class="row ">
                   <div class="col-md-12">
                       <div class="header">
                           <h3>Update Salary
                               
                           </h3>
                       </div>
                       <div class='float-right' style='margin:10px 40px 15px 0px;'>
                           <router-link :to="{name:'given_salary'}" class='btn btn-primary'>Given Salary</router-link>
                       </div>
                            <div class="col-md-8">
                                     <form @submit.prevent='payMonth'> 
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                            <label for="inputEmail4"> Name</label>
                                            <input type="text" class="form-control" id="inputEmail4" v-model='form.name'>

                                            </div>
                                             <div class="form-group col-md-6">
                                            <label for="inputEmail4"> Day</label>
                                            <input type="text" class="form-control" id="inputEmail4" v-model='form.date'>

                                            </div>
                                             <div class="form-group col-md-6">
                                            <label for="inputEmail4"> Month</label>
                                            <input type="text" class="form-control" id="inputEmail4" v-model='form.month'>

                                            </div>
                                             <div class="form-group col-md-6">
                                            <label for="inputEmail4"> Year</label>
                                            <input type="text" class="form-control" id="inputEmail4" v-model='form.year'>

                                            </div>
                                             <div class="form-group col-md-6">
                                            <label for="inputEmail4"> Paid</label>
                                            <input type="text" class="form-control" id="inputEmail4" v-model='form.paid'>

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
    name:'give_salary',
    data(){
        return {
           form:{
                name:'',
                date:'',
                month:'',
                year:'',
                paid:'',
                empid:'',
            },
           
        }
    },
    methods:{
          payMonth(){
              let id=this.$route.params.id;
          let data = {
            name:this.form.name,
            date:this.form.date,
            month:this.form.month,
            year:this.form.year,
            paid:'Paid',
            empid:this.$route.params.id,
            };

            
          axios.post('/api/empSalary',data).then((response)=>{
            console.log(response.data);
            this.$router.push({name:'given_salary'});
        }).catch(err=>{
            console.log(err.response.data.error);
        });
     
    
        
    }
    },
}
</script>