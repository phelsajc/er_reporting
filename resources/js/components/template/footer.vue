
<template>
    <footer class="main-footer" v-show="$route.path === '/' || $route.path ==='/register' || $route.path ==='/forget' ? false : true " style="display: none">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.1.0-rc
    </div>
    <strong>Copyright &copy; 2014-2020 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
</template>
<script>
    export default {
      data() {
        return {}
      },
    }
</script>