<template>
    <div id="all_expense">
         <div class="container">
                <div class="row ">
                   <div class="col-md-12">
                       <div class="header">
                           <h3>All Expense</h3>
                       </div>
                        <div>
                            <div class='add_expense' style='margin:10px 40px 15px 0px;'>
                                <router-link :to="{name:'add_expense'}" class='btn btn-primary'>Add Expense</router-link>
                            </div>
                             <div class="input-group col-md-4">
                                    <input type="search" v-model='searchTerm' class="form-control rounded" placeholder="Search" aria-label="Search"
                                    aria-describedby="search-addon"/>
                                    <button type="button" class="btn btn-outline-primary">search</button>
                                </div>                          
                               </div>
                        <div class="col-md-12 mt-5">
                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Expense Details</th>
                                        <th scope='col'>Expense Amount</th>
                                        <th scope="col">Expense Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(expense) in filterSearch" :key='expense.id'>
                                        <td>{{(expense.id)}}</td>
                                        <td>{{expense.details}}</td>
                                        <td>{{expense.amount}} tk</td>
                                        <td>{{expense.expense_date}}</td>
                                        <td style='color:white'><router-link class='btn btn-md btn-primary' style='margin-right:5px' :to="{name:'edit_expense' , params:{ id: expense.id }}">Edit</router-link>
                                        <a class='btn btn-md btn-danger' @click="deleteExpense(expense.id)">Delete</a></td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
        </div>
    </div>    
</template>
<script>
export default {
    name:'all_expense',
    created(){
        if(!User.hasLoggedIn()){
            return this.$router.push({name:'/'});
        }
    }
    ,
    data(){
        return {
            expense:[],
            searchTerm: '',
        }
    },
    methods:{
        allExpense(){
            axios.get('/api/expense').then(({data}) =>{ this.expense = data}).catch(err=> console.log(err.data));
         },
     
        deleteExpense(id){
           
             Swal.fire({
                title: 'Are you sure?',
                text: "You won't to delete!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete!'
                }).then((result) => {
                    
                if (result.isConfirmed) {
                    console.log(id);
                    axios.delete('/api/expense/'+id)
                        .then(
                           (res)=>{
                                this.expense = this.expense.filter(exp=> {return exp.id !=id });
                                console.log(res.data);
                               
                           }  
                        )
                         .catch(()=> this.$router.push({name:'all_expense'}));


                    Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                    );                    
                }
            })
        }  

    },
    created(){
       this.allExpense();
     
    },
    computed:{
        filterSearch(){
            return this.expense.filter(
                (expense) =>{
                        return expense.details.match(this.searchTerm);
                }
            );
        }
    }
}
</script>
<style scoped>
    #all_employee{
        margin-top: 50px;
        margin-left: 20px;
    }
    #imgId{
        width:40px;
        height:40px;
    }
   
</style>