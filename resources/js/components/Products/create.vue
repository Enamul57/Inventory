<template>
    <div id="create_product">
         <div class="container">
               
                   <div class="col-md-12">
                       <div class="header">
                           <h3>Add Product</h3>
                       </div>
                       <div class='float-right' style='margin:10px 40px 15px 0px;'>
                           <router-link :to="{name:'all_product'}" class='btn btn-primary'>All Product</router-link>
                       </div>
                        <div class="row"> 
                            <div class="col-md-12 mt-5">
                                    <form @submit.prevent='addProduct'>
                                        <div class="form-row ">
                                                <div class="form-group col-md-6">
                                                    <label for="inputEmail4">Product Name</label>
                                                    <input type="text" class="form-control" id="inputEmail4" v-model='form.product_name' placeholder='Enter Your Product Name'>
                                                    <small class="text text-danger" v-if='errors.product_name'>{{errors.product_name[0]}}</small>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="inputEmail4">Product Code</label>
                                                    <input type="text" class="form-control" id="inputEmail4" v-model='form.product_code' placeholder='Enter Product Code'>
                                                    <small class="text text-danger" v-if='errors.product_code'>{{errors.product_code[0]}}</small>
                                                </div>
                                            
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="exampleFormControlSelect1">Product Category</label>
                                                    <select class="form-control" id="exampleFormControlSelect1" v-model='form.category_id'>
                                                        <option  :value ='category.id' v-for='category in categories' :key='category.id'>{{category.category_name}}</option>
                                                     </select>   
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleFormControlSelect1">Product Supplier</label>
                                                    <select class="form-control" id="exampleFormControlSelect1" v-model='form.supplier_id'>
                                                        <option :value ='supplier.id' v-for="supplier in suppliers" :key='supplier.id'>{{supplier.name}}</option>
                                                    </select>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="inputEmail4">Product Root</label>
                                                    <input type="text" class="form-control" id="inputEmail4" v-model='form.root' placeholder='Enter Your Product Name'>
                                                    <small class="text text-danger" v-if='errors.root'>{{errors.root[0]}}</small>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="inputEmail4">Buying Price</label>
                                                    <input type="text" class="form-control" id="inputEmail4" v-model='form.buying_price' placeholder='Enter Product Code'>
                                                    <small class="text text-danger" v-if='errors.buying_price'>{{errors.buying_price[0]}}</small>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="inputEmail4">Selling Price</label>
                                                    <input type="text" class="form-control" id="inputEmail4" v-model='form.selling_price' placeholder='Enter The Sell Price'>
                                                    <small class="text text-danger" v-if='errors.selling_price'>{{errors.selling_price[0]}}</small>
                                                </div>

                                        </div>
                                        <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="inputEmail4">Buying Date</label>
                                                    <input type="date" class="form-control" id="inputEmail4" v-model='form.buying_date' >
                                                    <small class="text text-danger" v-if='errors.buying_date'>{{errors.buying_date[0]}}</small>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="inputEmail4">Product Quantity</label>
                                                    <input type="text" class="form-control" id="inputEmail4" v-model='form.product_quantity' placeholder='Enter Product Quantity'>
                                                    <small class="text text-danger" v-if='errors.product_quantity'>{{errors.product_quantity[0]}}</small>
                                                </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-8">
                                                    <label for="exampleFormControlFile1">Choose File</label>
                                                    <input type="file" class="form-control-file" id="exampleFormControlFile1" @change='onFileSelected'>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <td> <img :src="form.image" alt="" style='width:40px;height:40px'></td>
                                                </div>
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
    name:'create_product',
    created(){
        if(!User.hasLoggedIn){
            return this.$router.push({name:'/'});
        }
    },
    data(){
        return {
            form:{
                product_name: null,
                product_code: null,
                category_id:null,
                supplier_id:null,
                root:null,
                buying_price: null,
                selling_price:null,
                image:null,
                buying_date:null,
                product_quantity:null,
            },
            errors:{

            },
            suppliers:[],
            categories:[],
        }
    },
    methods:{
        addProduct(){
           axios.post('/api/products',this.form).

                then(()=>{
                    Notification.success();
                    this.$router.push({name:'all_product'});
                }).
                    catch(error => {
                        //  this.errors = error.response.data.errors;
                       console.log(error.response.data);
                    }); 
        },

        onFileSelected(event){
            let file = event.target.files[0];
                let reader = new FileReader();
                reader.onload = event => {
                    this.form.image = event.target.result;
                    console.log(event.target.result);
                }
                console.log(event);
                console.log(file);
                console.log(event.target.files[0]);
                reader.readAsDataURL(file);
           
        },
         
    },
     created(){
              axios.get('/api/category').
                then((response)=> this.categories = response.data).
                    catch(error=> console.log(error.response.data))

              axios.get('/api/supplier').
                then((response)=> this.suppliers = response.data).
                    catch(error=> console.log(error.response.data));
            
        }
}
</script>
<style scoped>
    #create_product{
        margin-top: 20px;
        margin-left: 20px;
    }
</style>