<template>
    <aside id="sidebar" class="main-sidebar sidebar-dark-primary elevation-4">
        <router-link to="/census" class="brand-link">
            <img :src="('../../../../public/backend2/rmci.png')" alt="AdminLTE Logo"
                class="brand-image img-circle elevation-3" style="opacity: 0.8" />
            <span class="brand-text font-weight-light">Census</span> <br>
        </router-link>
        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="info">
                    <user-info></user-info>
                </div>
            </div>
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                    <li class="nav-item">
                        <router-link to="/all_employee" class="collapse-item">
                            <a href="#" class="nav-link" id="revenuemenu" :class="{ 'active': this.$route.name == 'all_employee' }">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Census</p>
                            </a> 
                        </router-link>
                    </li>

                    <!-- <li class="nav-item" v-if="UserType=='Administrator'||UserType=='Staff'">
                        <router-link to="/userslist" class="collapse-item">
                            <a href="#" class="nav-link" id="usermenu" :class="{ 'active': this.$route.name == 'userslist' || this.$route.name == 'usersadd' }">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Users</p>
                            </a> 
                        </router-link>
                    </li> -->

                    <!-- <li class="nav-item">
                        <router-link to="/profile" class="collapse-item">
                            <a href="#" class="nav-link" id="usermenu" :class="{ 'active': this.$route.name == 'profile'}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>My Profile</p>
                            </a> 
                        </router-link>
                    </li> -->

                    <li class="nav-item">
                        <router-link to="/logout" class="nav-link">
                            <p>Logout</p>
                        </router-link>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
</template>
<script>
export default {
    created(){
        
    },
    data() {
        return {
            img: '../../../../backend2/premier.jpg',
            avatar: '../../../../backend2/dist/img/avatar3.png',
            UserType:User.user_type(),
        }
    },
}
</script>
    