<template>
    <div id="edit_product">
         <div class="container">
                <div class="row ">
                   <div class="col-md-12">
                       <div class="header">
                           <h3>Edit Employee</h3>
                       </div>
                       <div class='float-right' style='margin:10px 40px 15px 0px;'>
                           <router-link :to="{name:'all_employee'}" class='btn btn-primary'>All Employee</router-link>
                       </div>
                            <div class="col-md-8">
                                     <form @submit.prevent='updateProducts'> 
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
                                                    <input type="text" class="form-control" id="inputEmail4" v-model='form.root' placeholder='Enter Root'>
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
                                                    <td> 
                                                        <img v-if='clickOnChoose' :src="newphoto" alt="">
                                                 <img v-else :src="'/'+form.photo"  style='width:90px;height:90px'></td>
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
    name:'edit_product',
    created(){
        if(!User.hasLoggedIn){
            return this.$router.push({name:'/'});
        }
    },
        data(){
           return {
               form:{
                product_name: '',
                product_code: '',
                category_id:'',
                supplier_id:'',
                root:'',
                buying_price: '',
                selling_price:'',
                image:'',
                buying_date:'',
                product_quantity:'',
                newphoto:'',
            },
            errors:{

            },

            categories:{},
            suppliers:{},
            clickOnChoose:false,
            newphoto:'',
        }
    },
    created(){
        let id = this.$route.params.id;
        axios.get('/api/products/'+id).then((response) =>(this.form = response.data) ).catch(err=>console.log(err.response.data));
        axios.get('/api/category/').then(({data})=> this.categories = data).catch(err=> console.log(err.response.data))
        axios.get('/api/supplier/').then(({data})=> this.suppliers = data).catch(err=> console.log(err.response.data))
    },
    methods:{

        onFileSelected(event){
            this.clickOnChoose = true;
            let file = event.target.files[0];
            let reader = new FileReader();
            reader.onload = (event)=>{
                this.form.newphoto = event.target.result;
                this.newphoto = this.form.newphoto;
                console.log(this.form.newphoto);
            };
            reader.readAsDataURL(file);
            
        },

       updateProducts(){
           let id = this.$route.params.id;
           console.log(id);
           axios.patch('/api/products/'+id,this.form).then(()=>{ Notification.success(); return this.$router.push({name:'all_product'});  }).catch((err)=>console.log(err.response.data));

        
       },
       
    }

}
</script>