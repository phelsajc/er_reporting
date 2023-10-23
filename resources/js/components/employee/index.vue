<template>
  <div class="wrapper">
    <navComponent></navComponent>
    <sidemenuComponent></sidemenuComponent>
    <div class="content-wrapper">
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Census</h1>
            </div>
          </div>
        </div>
      </section>
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">&nbsp;</h3>
                </div>
                <div class="card-body">
                  <form class="user" enctype="multipart/form-data">
                    <div class="row">
                      <div class="col-sm-2">
                        <div class="form-group">
                          <label>From</label>
                          <datepicker
                            name="date"
                            v-model="filter.fdate"
                            required
                            input-class="dpicker"
                            :bootstrap-styling="true"
                          ></datepicker>
                        </div>
                      </div>
                      <div class="col-sm-2">
                        <div class="form-group">
                          <label>To</label>
                          <datepicker
                            name="date"
                            v-model="filter.tdate"
                            required
                            input-class="dpicker"
                            :bootstrap-styling="true"
                          ></datepicker>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-group">
                          <label>Stations</label>
                          <multiselect
                            v-model="filter.stns"
                            :multiple="true"
                            :options="myOptions"
                          ></multiselect>
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label>&nbsp;</label> <br />
                          <button
                            type="button"
                            @click="showReport()"
                            class="btn btn-info"
                          >
                            Filter
                          </button>
                          <!-- <button
                            type="button"
                            @click="exportCsv()"
                            class="btn btn-primary"
                          >
                            Export
                          </button>
                          <button
                            type="button"
                            @click="exportPDF()"
                            class="btn btn-danger"
                          >
                            PDF
                          </button> -->
                        </div>
                      </div>
                    </div>

                    <!-- <progressBar :getStatus="showProgress"></progressBar> -->
                  </form>

                  <!-- <table class="table">
                    <thead>
                      <tr>
                        <th>Date</th>
                        <th>Station</th>
                        <th>Bed Capacity</th>
                        <th>Occupied Beds</th>
                        <th>Occupancy Rate</th>
                        <th>ALOS</th>
                      </tr>
                    </thead>

                    <tbody>
                      <tr v-for="e in census_results">
                        <td>
                          {{ e.date }}
                        </td>
                        <td>
                          {{ e.station }}
                        </td>
                        <td>
                          {{ e.bedCapacity }}
                        </td>
                        <td>
                          {{ e.occupiedBeds }}
                        </td>
                        <td>
                          {{ e.occupanyRate }}
                        </td>
                        <td>
                          {{ e.alos }}
                        </td>
                      </tr>
                    </tbody>
                  </table> -->

                  <table class="table">
                    <thead>
                      <tr>
                        <th>Stations</th>
                      </tr>
                    </thead>

                    <tbody>
                      <tr v-for="e in census_results">
                        <td>
                          <strong>{{ e.station }}</strong>
                        </td>
                        <table class="table">
                          <thead>
                            <tr>
                              <th>Date</th>
                              <th>Bed Capacity</th>
                              <th>Occupied Beds</th>
                              <th>Occupancy Rate</th>
                              <th>ALOS</th>
                            </tr>
                          </thead>

                          <tbody>
                            <tr v-for="f in e.station_detail">
                              <td>
                                {{ f.date }}
                              </td>
                              <td>
                                {{ f.bedCapacity }}
                              </td>
                              <td>
                                {{ f.occupiedBeds }}
                              </td>
                              <td>
                                {{ f.occupanyRate }}
                              </td>
                              <td>
                                {{ f.alos }}
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </tr>
                    </tbody>
                  </table>

                  <div id="loader" :class="{ 'd-none': isHidden }"></div>
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
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <footerComponent></footerComponent>
  </div>
</template>

<script type="text/javascript">
import Datepicker from "vuejs-datepicker";
import Select2 from "v-select2-component";
import Multiselect from "vue-multiselect";
import "vue-multiselect/dist/vue-multiselect.min.css";
export default {
  components: { Datepicker, Select2, Multiselect },
  created() {
    if (!User.loggedIn()) {
      this.$router.push({ name: "/" });
    }

    //Notification.success()
    // this.allEmployee();
    this.getStns();
  },
  data() {
    return {
      myOptions: ["All"],
      hasError: false,
      isHidden: true,
      filter: {
        stns: null,
        tdate: null,
        fdate: null,
      },
      employees: [],
      searchTerm: "",
      countRecords: 0,
      showing: "",
      census_results: [],
    };
  },
  computed: {
    filtersearch() {
      return this.employees.filter((e) => {
        return e.patientname.match(this.searchTerm);
      });
    },
  },
  methods: {
    getStns() {
      axios
        .get("/api/getSDtations")
        .then((response) => {
          response.data.data.forEach((element) => {
            this.myOptions.push(element.station);
          });
        })
        .catch((error) => console.log(error));
    },
    showReport() {
      /* this.filter.fdate = moment.utc(this.filter.fdate).utcOffset("+08:00").format();
      this.filter.tdate = moment.utc(this.filter.tdate).utcOffset("+08:00").format();
      this.progressStatus = false; */
      axios
        .post("/api/getCensus", this.filter)
        .then((response) => {
          this.census_results = response.data.data;
          console.log(response.data);
          console.log(this.census_results);
          /* this.getTotalSession = response.data.sessions;
          this.results = response.data.data;
          this.export = response.data.export;
          this.getMonthTitle = response.data.month;
          this.month = moment(this.filter.date).format("MMMM YYYY"); */
          //this.month = moment.utc(this.filter.date).utcOffset('+08:00').format(); // '+08:00' represents the UTC offset for Asia/Manila
          Toast.fire({
            icon: "success",
            title: "Saved successfully",
          });
          //this.progressStatus = true;
        })
        .catch((error) => {
          if (error.response.data.message == "Token has expired") {
            this.$router.push({ name: "/" });
            Toast.fire({
              icon: "error",
              title: "Token has expired",
            });
          }
        });
    },
    generate() {
      console.log(this.myValue);
    },
    myChangeEvent(val) {
      console.log(val);
    },
    mySelectEvent({ id, text }) {
      console.log({ id, text });
    },
    allEmployee() {
      this.isHidden = false;
      axios
        .get("/api/patientEmployee")
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
    async check_doctors_detail(id) {
      return await axios.get("/api/check_doctors_detail/" + id).then((response) => {
        setTimeout(function () {
          return response.data;
        }, 3000);
      });
      /*  .then((response) => {  
                return  Promise.resolve(response.data); }) */
    },
    /* async  check_doctors_detail(id) {   
             return await axios.get( '/api/check_doctors_detail/'+id)
            }, */
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
        .post("/api/patientEmployee", this.form)

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
        .post("/api/patientEmployee", this.form)
        .then((res) => {
          this.employees = res.data[0].data;
          this.countRecords = res.data[0].count;
          (this.showing = res.data[0].showing), console.log(res.data[0]);
          this.isHidden = true;
        })
        .catch((error) => (this.errors = error.response.data.errors));
    },

    download(ppspat, ddoctor) {
      window.open("/api/print_prescription/" + ppspat + "/" + ddoctor);
    },
  },
  /* mounted () {
          axios.get('/api/check_doctors_detail/'+id)
              .then(response => (this.getdctr = response))
        }, */
  /* created(){
            this.allEmployee();
        } */
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

.spin_center2 {
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

<style>
/* Center the loader */
#loader {
  position: absolute;
  left: 50%;
  top: 50%;
  z-index: 1;
  width: 120px;
  height: 120px;
  margin: -76px 0 0 -76px;
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
  0% {
    -webkit-transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
  }
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

/* Add animation to "page content" */
.animate-bottom {
  position: relative;
  -webkit-animation-name: animatebottom;
  -webkit-animation-duration: 1s;
  animation-name: animatebottom;
  animation-duration: 1s;
}

@-webkit-keyframes animatebottom {
  from {
    bottom: -100px;
    opacity: 0;
  }
  to {
    bottom: 0px;
    opacity: 1;
  }
}

@keyframes animatebottom {
  from {
    bottom: -100px;
    opacity: 0;
  }
  to {
    bottom: 0;
    opacity: 1;
  }
}

#myDiv {
  display: none;
  text-align: center;
}

.hasDetails {
  box-shadow: 14px 0px 0px 0px #00ce6e inset;
}
</style>
