<template>
    <div id="all_category">
         <div class="container">
                <div class="row ">
                   <div class="col-md-8">
                       <div class="header">
                           <h3>All Category</h3>
                       </div>
                        <div>
                            <div class='add_category' style='margin:10px 40px 15px 0px;'>
                                <router-link to='create_category' class='btn btn-primary'>Add Category</router-link>
                            </div>
                             <div class="input-group col-md-6">
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
                                        <th scope="col">Category Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(category) in filterSearch" :key='category.id'>
                                        <td>{{(category.id)}}</td>
                                         <td>{{category.category_name}}</td>
                                         <td>
                                             <router-link href="" class="btn btn-primary" :to="{name:'edit_category', params:{ id: category.id } }" style='color:white'>Edit</router-link>
                                             <a class='btn btn-danger' @click='deleteCategory(category.id)'  style='color:white'>Delete</a>
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
    name:'all_category',
    created(){
        if(!User.hasLoggedIn()){
            return this.$router.push({name:"/"});
        }
    }
    ,
    data(){
        return {
            categories:[],
            searchTerm: '',
        }
    },
    methods:{
        allCategory(){
            axios.get('/api/category').then((response) =>{ this.categories = response.data; console.log(response.data)}).catch(err=> console.log(err.data));
         },
        deleteCategory(id){
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
                    axios.delete('/api/category/'+id)
                        .then(
                           (res)=>{
                                this.categories = this.categories.filter(category=> {return category.id !=id });
                                console.log(res.data);
                               
                           }  
                        ).catch((error) => console.log(error.res.data));


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
       this.allCategory();
     
    },
    computed:{
        filterSearch(){
            return this.categories.filter(
                (category) =>{
                        return category.category_name.match(this.searchTerm);
                }
            );
        }
    }
}
</script>
<style scoped>
    #all_category{
        margin-top: 50px;
        margin-left: 20px;
    }
    #imgId{
        width:40px;
        height:40px;
    }
   
</style>