<template>
    <div id="logout">
        <div class="conatiner">
            <div class="row">

            </div>
        </div>
    </div>
</template>
<script>
export default {
    name:'logout',
    created(){
       localStorage.removeItem('token');
       localStorage.removeItem('user');
        Toast.fire({
                        icon: 'success',
                        title: 'Logout successfully'
                    });
                    this.$router.push({name:'login'});
    }
}
</script>