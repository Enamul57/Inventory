<template>
    <div id="all_employee">
         <div class="container">
                <div class="row ">
                   <div class="col-md-12">
                       <div class="header">
                           <h3>All Customer</h3>
                       </div>
                        <div>
                            <div class='add_employee' style='margin:10px 40px 15px 0px;'>
                                <router-link to='add_customer' class='btn btn-primary'>Add Customer</router-link>
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
                                        <th scope="col">Address</th>
                                        <th scope='col'>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(customer) in filterSearch" :key='customer.id'>
                                        <td>{{(customer.id)}}</td>
                                        <td>{{customer.name}}</td>
                                        <td><img :src="customer.image" alt="" id='imgId'></td>
                                        <td>{{customer.email}}</td>
                                        <td>{{customer.phone}}</td>
                                        <td>{{customer.address}}</td>
                                        <td style='color:white'><router-link class='btn btn-md btn-primary' style='margin-right:5px' :to="{name:'edit_customer' , params:{ id: customer.id }}">Edit</router-link>
                                        <a class='btn btn-md btn-danger' @click="deleteCustomer(customer.id)">Delete</a></td>
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
    name:'all_customer',
    created(){
        if(!User.hasLoggedIn()){
            return this.$router.push({name:'/'});
        }
    }
    ,
    data(){
        return {
            customer:[],
            searchTerm: '',
        }
    },
    methods:{
        allCustomer(){
            axios.get('/api/customer').then(({data}) =>{ this.customer = data}).catch(err=> console.log(err.data));
         },
     
        deleteCustomer(id){
           
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
                    axios.delete('/api/customer/'+id)
                        .then(
                           (res)=>{
                                this.customer = this.customer.filter(cust=> {return cust.id !=id });
                                console.log(res.data);
                               
                           }  
                        )
                         .catch(()=> this.$router.push({name:'all_customer'}));


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
       this.allCustomer();
     
    },
    computed:{
        filterSearch(){
            return this.customer.filter(
                (customer) =>{
                        return customer.email.match(this.searchTerm);
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