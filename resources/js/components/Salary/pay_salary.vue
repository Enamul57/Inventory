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
                                     <form @submit.prevent='updatePayment'> 
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
    name:'pay_salary',
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
        fetchEmp(){
            let id = this.$route.params.id;
           axios.get('/api/empSalary/'+id).then((response) =>{ this.form = response.data; console.log(response.data)}).catch(err=> console.log(err.data));

        },
        updatePayment(){
            let id = this.$route.params.id;
            let data = {
            name:this.form.name,
            date:this.form.date,
            month:this.form.month,
            year:this.form.year,
            paid:'Paid',
            empid:this.form.empid,
        };
       
        axios.patch('/api/empSalary/'+id,data).then((response)=>{
            this.$router.push({name:'given_salary'});
            alert(id);
            console.log(response.data);
        }).catch((err)=>{
            console.log(err.data.error);
        });
        
    }
    },
    created(){
        this.fetchEmp();
    }
}
</script>