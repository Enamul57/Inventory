<template>
    <div id="all_category">
         <div class="container">
                <div class="row ">
                   <div class="col-md-8">
                       <div class="header">
                          
                       </div>
                        <div>
                            
                             <div class="input-group col-md-6">
                                    <input type="search" v-model='searchTerm' class="form-control rounded" placeholder="Search" aria-label="Search"
                                    aria-describedby="search-addon"/>
                                    <router-link  class="btn btn-outline-primary" :to="{name:'give_salary',params:{id:this.$route.params.id}}">Pay Month</router-link>
                                </div>                          
                               </div>
                        <div class="col-md-12 mt-5">
                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                       <th>Name</th>
                                        <th>Date</th>
                                        
                                        <th>Paid</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for='empSalList in empSalLists' :key='empSalList'>
                                        <td>{{empSalList.name}}</td>
                                        <td>{{(empSalList.date)}}/{{(empSalList.month)}}/{{(empSalList.year)}}</td>
                                         <td v-if="empSalList.paid =='Paid' || empSalList =='paid'">{{empSalList.paid}}</td>
                                         <td v-else>Not Paid</td>
                                         <td>
                                             <router-link class='btn btn-primary' :to="{name:'pay_salary',params:{id:empSalList.empid}}" >Pay Now</router-link>
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
    name:'view_salary',
    created(){
        if(!User.hasLoggedIn()){
            return this.$router.push({name:"/"});
        }
    }
    ,
    data(){
        return {
            empSalLists:[],
            searchTerm: '',
            name:'',
        }
    },
    methods:{
        allEmpSal(){
            let id = this.$route.params.id;
            axios.get('/api/empSalary/'+id).then((response) =>{ this.empSalLists = response.data; console.log(response.data)}).catch(err=> console.log(err.data));
            

        },
  

    },
    created(){
       this.allEmpSal();
     
    },
    
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