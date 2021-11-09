let login = require('./components/auth/login.vue').default;
let register = require ('./components/auth/register.vue').default;
let forget = require ('./components/auth/forget.vue').default;
let logout = require('./components/auth/logout.vue').default;

let home = require('./components/home.vue').default;

let AllEmployee = require('./components/employee/all.employee.vue').default;
let CreateEmployee = require('./components/employee/create.employee.vue').default;
let EditEmployee = require('./components/employee/edit.employe.vue').default;

let CreateSupplier  = require('./components/supplier/create.vue').default;
let AllSupplier  = require('./components/supplier/index.vue').default;
let EditSupplier = require('./components/supplier/edit.vue').default;

let allcategory = require('./components/category/index.vue').default;
let createcategory = require('./components/category/create.vue').default;
let editcategory = require('./components/category/edit.vue').default;

let AllProduct = require('./components/Products/index.vue').default;
let CreateProduct = require('./components/Products/create.vue').default;
let EditProduct = require('./components/Products/edit.vue').default;
let PointOfSale = require('./components/POS/pos.vue').default;


export const routes = [
    {path:'/',component:login,name:'login'},
    {path:'/register',component:register,name:'register'},
    {path:'/forget',component:forget,name:'forget'},
    {path:'/logout',component:logout,name:'logout'},
    {path:'/home',component:home,name:'home'},

    {path:'/all_employee',component:AllEmployee,name:'all_employee'},
    {path:'/create_employee',component:CreateEmployee,name:'create_employee'},
    {path:'/edit/employee/:id',component:EditEmployee,name:'edit_employee'},
    
    {path:'/create_supplier',component:CreateSupplier,name:'create_supplier'},
    {path:'/all_supplier',component:AllSupplier,name:'all_supplier'},
    {path:'/edit_supplier/:id',component:EditSupplier,name:'edit_supplier'},
    
    {path:'/all_category',component:allcategory,name:'all_category'},
    {path:'/create_category',component:createcategory,name:'create_category'},
    {path:'/edit_category/:id',component:editcategory,name:'edit_category'},
    
    {path:'/all_product',component:AllProduct,name:'all_product'},
    {path:'/create_product',component:CreateProduct,name:'create_product'},
    {path:'/edit_product/:id',component:EditProduct,name:'edit_product'},
    {path:'/pos',component:PointOfSale,name:'pos'},
    
];