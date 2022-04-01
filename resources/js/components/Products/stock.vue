<template>
    <div id="stock">
         <div class="container">
                <div class="row ">
                   <div class="col-md-12">
                       <div class="header">
                           <h3>All Product</h3>
                       </div>
                        <div>
                            <div class='add_employee' style='margin:10px 40px 15px 0px;'>
                                <router-link :to="{ name:'create_product' }" class='btn btn-primary'>Add Product</router-link>
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
                                        <th scope="col">Product Name</th>
                                        <th scope='col'>Photo</th>
                                        <th scope="col">Code</th>
                                        <th scope='col'>Category</th>
                                        <th scop='col'>Stock</th>
                                        <th scope="col">Buying Price</th>
                                        <th scope='col'>Status</th>
                                        <th scope='col'>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(product) in filterSearch" :key='product.id'>
                                        <td>{{product.product_name}}</td>
                                        <td><img :src="product.image" alt="" id='imgId'></td>
                                        <td>{{product.product_code}}</td>
                                        <td>{{product.product_category}}</td>
                                        <td>{{product.product_quantity}}</td>
                                        <td>{{product.buying_price}}</td>
                                        <td v-if="product.product_quantity>=1" class='text-success'>Available</td>
                                        <td v-else class='text-danger'>Stock Out</td>
                                        <td style='color:white'><router-link class='btn btn-md btn-primary' style='margin-right:5px' :to="{name:'edit_product' , params:{ id: product.id }}">Edit</router-link>
                                        </td>
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
    name:'stock',
    created(){
        if(!User.hasLoggedIn()){
            return this.$router.push({name:"/"});
        }
    }
    ,
    data(){
        return {
            products:[],
            searchTerm: '',
            

        }
    },
    methods:{
        allproduct(){
            axios.get('/api/products').then(({data}) =>{ this.products = data}).catch(err=> console.log(err.data));
         },
        deleteProduct(id){
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
                    axios.delete('/api/products/'+id)
                        .then(
                           ()=>{
                                this.products = this.products.filter(product=> {return product.id !=id });
                                return this.$router.push({name:'all_product'});
                               
                           }  
                        )
                         .catch(()=> this.$router.push({name:'all_product'}));


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
       this.allproduct();
       
    },
    computed:{
        filterSearch(){
            return this.products.filter(
                (product) =>{
                        return product.product_code.match(this.searchTerm);
                }
            );
        }
    }
}
</script>
<style scoped>
    #all_product{
        margin-top: 50px;
        margin-left: 20px;
    }
    #imgId{
        width:40px;
        height:40px;
    }
   
</style>