<template>
  <div class="wrapper">
    <navComponent></navComponent>
    <sidemenuComponent></sidemenuComponent>
    <div class="content-wrapper">
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Users List</h1>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->
      </section>

      <!-- Main content -->

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">&nbsp;</h3>
                  <router-link to="/usersadd/0" class="btn btn-primary">Add</router-link>
                </div>

                <div class="card-body">
                  <div class="spin_center" :class="{ 'd-none': isHidden }">
                    <div class="overlay">
                      <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                      <div class="text-bold pt-2">Loading...</div>
                    </div>
                  </div>

                  <ul class="list-group">
                    <input
                      type="text"
                      v-model="form.searchTerm2"
                      @change="filterEmployee()"
                      class="form-control to-right"
                      style="width: 100%"
                      placeholder="Search user here"
                    />
                    <!-- <router-link
                      v-for="e in filtersearch"
                      :key="e.id"
                      :to="{
                        name:'usersadd',
                        params: { id: e.id },
                      }"
                    > -->
                    <router-link v-for="e in filtersearch" :key="e.id" :to="{ name: 'usersadd', params: { id: e.id } }">
                    <li class="list-group-item">
                      <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">
                          <strong>{{ e.name }}  </strong>
                        </h5>
                      </div>

                      <span class="badge badge-secondary"> {{ e.type }}</span>
                      <!--  <span class="badge badge-info">                           {{e.sex}}</span>
                      <span class="badge badge-success">                          {{e.attending_phy}}</span> -->
                    </li>
                    </router-link>
                  </ul>
                  <br />
                  <nav aria-label="Page navigation example" class="to-right">
                    <ul class="pagination">
                      <li class="page-item" v-for="(e, index) in this.countRecords">
                        <a class="page-link" @click="getPageNo(index + 1)" href="#">{{
                          index + 1
                        }}</a>
                      </li>
                    </ul>
                  </nav>

                  <nav aria-label="Page navigation example" class="">
                    {{ showing }}
                  </nav>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->

              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </section>
    </div>
    <footerComponent></footerComponent>
  </div>
</template>

<script type="text/javascript">
export default {
  created() {
    if (!User.loggedIn()) {
      this.$router.push({ name: "/" });
    }

    //Notification.success()
    this.allEmployee();
    this.me();
  },
  data() {
    return {
      hasError: false,
      isHidden: true,
      form: {
        searchTerm2: null,
        start: 0,
      },
      employees: [],
      searchTerm: "",
      countRecords: 0,
      getdctr: "-",
      utype: User.user_type(),
      token: localStorage.getItem("token"),
      showing: "",
    };
  },
  computed: {
    filtersearch() {
      return this.employees.filter((e) => {
        return e.name.match(this.searchTerm);
      });
    },
  },
  methods: {
    allEmployee() {
      this.isHidden = false;
      //axios.get('/api/employee')
      axios
        .get("/api/listusers")
        .then(
          ({ data }) => (
            (this.employees = data[0].data),
            (this.countRecords = data[0].count),
            (this.showing = data[0].showing),
            (this.isHidden = true)
          )
        )
        .catch();
    },
    me() {
      axios
        .post("/api/auth/me", "", {
          headers: {
            //"Content-Type": "application/x-www-form-urlencoded",
            Authorization: "Bearer ".concat(this.token),
            Accept: "application/jsons",
          },
        })
        .then((res) => {
          console.log(res);
        })
        .catch((error) => (this.errors = error.response.data.errors));
    },
    pdf() {
      /* axios.get('/pdf')
                .then(({data}) => (
                    console.log(data)
                ))
                .catch() */
      window.open("/api/pdf", "_blank");
    },
    formatDate(date) {
      const options = { year: "numeric", month: "long", day: "numeric" };
      return new Date(date).toLocaleDateString("en", options);
    },
    deleteRecord(id) {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        if (result.isConfirmed) {
          axios
            .delete("/api/employee/" + id)
            .then(() => {
              this.employees = this.employees.filter((e) => {
                return e.id != id;
              });
            })
            .catch(() => {
              //this.$router.push({name: 'all_employee'})
              this.$router.push("/all_employee").catch(() => {});
            });

          Swal.fire("Deleted!", "Your file has been deleted.", "success");
        }
      });
    },
    filterEmployee() {
      this.employees = [];
      this.countRecords = null;
      this.form.start = 0;
      this.isHidden = false;
      //axios.post('/api/filterEmployee',this.form)
      axios
        .post("/api/listusers", this.form)

        .then((res) => {
          this.employees = res.data[0].data;
          this.countRecords = res.data[0].count;
          console.log(res.data.data);
          this.isHidden = true;
        })
        .catch((error) => (this.errors = error.response.data.errors));
    },
    getPageNo(id) {
      this.form.start = (id - 1) * 10;
      this.isHidden = false;
      //alert(a)
      /* this.employees = []
              this.countRecords = null */
      //axios.post('/api/filterEmployee',this.form)

      axios
        .post("/api/listusers", this.form)
        .then((res) => {
          this.employees = res.data[0].data;
          this.countRecords = res.data[0].count;
          (this.showing = res.data[0].showing), console.log(res.data[0]);
          this.isHidden = true;
        })
        .catch((error) => (this.errors = error.response.data.errors));
    },

  },
};
</script>

<style>
.em_photo {
  height: 40px;
  width: 40px;
}

.to-right {
  float: right;
}

.spin_center {
  position: absolute;
  top: 50%;
  left: 50%;
  width: 300px;
  text-align: center;
  transform: translateX(-50%);
  /*display: none;*/
}

.btn-app {
  height: unset !important;
  padding: 0 1.5em 0 1.5em;
}
</style>
