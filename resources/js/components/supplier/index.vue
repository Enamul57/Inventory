<template>
    <div id="all_supplier">
         <div class="container">
                <div class="row ">
                   <div class="col-md-12">
                       <div class="header">
                           <h3>All Suppliers</h3>
                       </div>
                        <div>
                            <div class='add_employee' style='margin:10px 40px 15px 0px;'>
                                <router-link :to="{name:'create_supplier'}" class='btn btn-primary'>Add Suppliers</router-link>
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
                                        <th scope='col'>Shop Name</th>
                                        <th scope='col'>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(supplier) in filterSearch" :key='supplier.id'>
                                        <td>{{(supplier.id)}}</td>
                                        <td>{{supplier.name}}</td>
                                        <td><img :src="supplier.photo" alt="" id='imgId'></td>
                                        <td>{{supplier.email}}</td>
                                        <td>{{supplier.phone}}</td>
                                        <td>{{supplier.address}}</td>
                                        <td>{{supplier.shopName}}</td>
                                        <td style='color:white'><router-link class='btn btn-md btn-primary' style='margin-right:5px' :to="{name:'edit_supplier' , params:{ id: supplier.id }}">Edit</router-link>
                                        <a class='btn btn-md btn-danger' @click="deleteSupplier(supplier.id)">Delete</a></td>
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
    name:'all_supplier',
    created(){
        if(!User.hasLoggedIn()){
            return this.$router.push({name:"/"});
        }
    }
    ,
    data(){
        return {
            suppliers:[],
            searchTerm: '',
        }
    },
    methods:{
        allSupplier(){
            axios.get('/api/supplier').then(({data}) =>{ this.suppliers = data}).catch(err=> console.log(err.data));
         },
        deleteSupplier(id){
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
                    axios.delete('/api/supplier/'+id)
                        .then(
                           (res)=>{
                                this.suppliers = this.suppliers.filter(supplier=> {return supplier.id !=id });
                                console.log(res.data);
                               
                           }  
                        )
                         .catch(()=> this.$router.push({name:'all_supplier'}));


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
       this.allSupplier();
     
    },
    computed:{
        filterSearch(){
            return this.suppliers.filter(
                (supplier) =>{
                        return supplier.email.match(this.searchTerm);
                }
            );
        }
    },
  
}
</script>
<style scoped>
    #all_supplier{
        margin-top: 50px;
        margin-left: 20px;
    }
    #imgId{
        width:40px;
        height:40px;
    }
   
</style>