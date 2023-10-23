<template>
  <div class="hold-transition login-page">
    <div class="login-box">
      <!-- /.login-logo -->
      <div class="card card-outline card-primary">
        <div class="card-header text-center">
          <a href="javascript:void(0);" class="h1"><b>Welcome User</b></a>
        </div>
        <div class="card-body">
          <p class="login-box-msg">Sign in to start your session</p>
          <form class="user" @submit.prevent="login">
            <div class="input-group mb-3">
              <input
                type="text"
                class="form-control"
                id="exampleInputEmail"
                aria-describedby="emailHelp"
                placeholder="Enter Email Address"
                v-model="form.username"
              />
              <small class="text-danger" v-if="errors.username">{{
                errors.username[0]
              }}</small>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input
                type="password"
                class="form-control"
                id="exampleInputPassword"
                placeholder="Password"
                v-model="form.password"
              />
              <small class="text-danger" v-if="errors.password">{{
                errors.password[0]
              }}</small>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary btn-block">Login</button>
            </div>
            <hr />
          </form>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
  </div>
</template>

<style lang="scss" scoped>
@import "../../../../public/backend2/dist/css/adminlte.min.css";
/* {{ asset('backend2/dist/css/adminlte.min.css') }} */
</style>

<script type="text/javascript">
export default {
  created() {
    if (!User.loggedIn()) {
      this.$router.push({ name: "/" });
    }
  },

  data() {
    return {
      form: {
        username: null,
        password: null,
      },
      errors: {},
    };
  },
  methods: {
    async login() {
      await axios
        .post("/api/auth/login", this.form)
        .then((res) => {
          User.responseAfterLogin(res);
          Toast.fire({
            icon: "success",
            title: "Signed in successfully1",
          });
          //this.$router.push({name: 'home'})

          this.$router.push({ name: "all_employee" });
          //location = "/all_employee"
        })
        .catch((error) => (this.errors = error.response.data.errors))
        .catch(
          Toast.fire({
            icon: "warning",
            title: "User Not Found!",
          }),

          console.log(this.errors)
        );
    },
  },
};
</script>

<style></style>
