<template>

</template>

<script type="text/javascript">

export default {
        created(){
         localStorage.removeItem('token')
         localStorage.removeItem('user')
         localStorage.removeItem('user_id')
        localStorage.removeItem('user_type')
        /* localStorage.setItem('token',"null");
        localStorage.setItem('user',"null");
        localStorage.setItem('user_id',"null");
        localStorage.setItem('user_type', "null"); */
        //localStorage.clear();
            Toast.fire({
                icon: 'success',
                title: 'Logout successfully'
            })
        this.$router.push({ name: '/' })
        },
    }

</script>

<style>

</style>