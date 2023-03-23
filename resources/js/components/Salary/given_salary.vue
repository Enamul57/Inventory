<template>
    <div id="all_employee">
         <div class="container">
                <div class="row ">
                   <div class="col-md-12">
                       <div class="header">
                           <h3>All Employee</h3>
                       </div>
                        <div>
                            <div class='add_employee' style='margin:10px 40px 15px 0px;'>
                                <router-link to='create_employee' class='btn btn-primary'>Add Employee</router-link>
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
                                        <th scope="col">Name</th>
                                        <th scope='col'>Photo</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Phone</th>
                                        <th scope='col'>Salary</th>
                                        <th scope='col'>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(employee) in filterSearch" :key='employee.id'>
                                        <td>{{(employee.id)}}</td>
                                        <td>{{employee.name}}</td>
                                        <td><img :src="employee.photo" alt="" id='imgId'></td>
                                        <td>{{employee.email}}</td>
                                        <td>{{employee.phone}}</td>
                                        <td>{{employee.sallery}}</td>
                                        <td ><button class='btn btn-primary' @click='viewSalary(employee.id)'>View Salary</button> </td>
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
    name:'given_salary',
    created(){
        if(!User.hasLoggedIn()){
            return this.$router.push({name:"/"});
        }
    }
    ,
    data(){
        return {
            employees:[],
            searchTerm: '',
        }
    },
    methods:{
        allEmployee(){
           
            axios.get('/api/empSalary/').then(({data}) =>{ this.employees = data;console.log(this.employees);}).catch(err=> console.log(err.data));
         },
        deleteEmploye(id){
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
                    axios.delete('/api/employee/'+id)
                        .then(
                           (res)=>{
                                this.employees = this.employees.filter(employee=> {return employee.id !=id });
                                console.log(res.data);
                               
                           }  
                        )
                         .catch(()=> this.$router.push({name:'all_employee'}));


                    Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                    );                    
                }
            })
        }  ,
        viewSalary(id){
           axios.get('/api/empSalary/'+id).then((response) =>{
                 console.log(response.data);
                this.$router.push({name:'view_salary',params:{id:id}});
           }).catch(err=> console.log(err.response.data.error));
        }

    },
    created(){
       this.allEmployee();
     
    },
    computed:{
        filterSearch(){
            return this.employees.filter(
                (employee) =>{
                        return employee.email.match(this.searchTerm);
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