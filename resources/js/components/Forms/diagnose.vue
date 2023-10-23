<template>
  <div class="wrapper">
    <navComponent></navComponent>
    <sidemenuComponent></sidemenuComponent>
    <div class="content-wrapper">
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>&nbsp;</h1>
            </div>
            <!-- <div class="col-sm-6"><ol class="breadcrumb float-sm-right"><li class="breadcrumb-item"><a href="#">Home</a></li><li class="breadcrumb-item active">Employee</li></ol></div> -->
          </div>
        </div>
      </section>
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card card-success">
                <div class="card-header">
                  <h3 class="card-title">{{ user_info.patientname }}</h3>
                  <div class="card-tools">
                    <button
                      type="button"
                      class="btn btn-tool"
                      data-card-widget="collapse"
                    >
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>O2</th>
                          <th>Pulse</th>
                          <th>RR</th>
                          <th>Temp</th>
                          <th>BP</th>
                          <th>Weight</th>
                          <th>Height</th>
                          <th>Cheif Complaints</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>{{ form.o2_stat }}</td>
                          <td>{{ form.pulse_rate }}</td>
                          <td>{{ form.rr }}</td>
                          <td>{{ form.temp }}</td>
                          <td>{{ form.bp }}</td>
                          <td>{{ form.weight }}</td>
                          <td>{{ form.height }}</td>
                          <td>{{ form.chiefcomplaints }}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

              <div class="card card-primary">
                <div class="card-header p-0 pt-1">
                  <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                    <li class="nav-item">
                      <a
                        class="nav-link active"
                        id="custom-tabs-one-home-tab"
                        data-toggle="pill"
                        href="#custom-tabs-one-home"
                        role="tab"
                        aria-controls="custom-tabs-one-home"
                        aria-selected="true"
                      >
                        Details
                      </a>
                    </li>
                    <li class="nav-item">
                      <a
                        class="nav-link"
                        :class="{ disabled: isDoneDetails }"
                        id="custom-tabs-one-profile-tab"
                        data-toggle="pill"
                        href="#custom-tabs-one-profile"
                        role="tab"
                        aria-controls="custom-tabs-one-profile"
                        aria-selected="false"
                      >
                        Prescription
                      </a>
                    </li>
                    <li class="nav-item">
                      <a
                        class="nav-link"
                        :class="{ disabled: isDoneDetails }"
                        id="custom-tabs-one-messages-tab"
                        data-toggle="pill"
                        href="#custom-tabs-one-messages"
                        role="tab"
                        aria-controls="custom-tabs-one-messages"
                        aria-selected="false"
                      >
                        Diagnostic
                      </a>
                    </li>
                    <li class="nav-item">
                      <a
                        class="nav-link"
                        :class="{ disabled: isDoneDetails }"
                        id="custom-tabs-one-settings-tab"
                        data-toggle="pill"
                        href="#custom-tabs-one-settings"
                        role="tab"
                        aria-controls="custom-tabs-one-settings"
                        aria-selected="false"
                      >
                        Additional Instructions
                      </a>
                    </li>
                    <!-- <li class="nav-item"><a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#custom-tabs-one-settings" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false">
                                    Additional Instruction 
                                </a></li> -->
                  </ul>
                </div>
                <div class="card-body">
                  <div class="tab-content" id="custom-tabs-one-tabContent">
                    <div
                      class="tab-pane fade show active"
                      id="custom-tabs-one-home"
                      role="tabpanel"
                      aria-labelledby="custom-tabs-one-home-tab"
                    >
                      <form
                        class="user"
                        @submit.prevent="addInitialdata"
                        enctype="multipart/form-data"
                      >
                        <h4>History</h4>
                        <div class="form-group">
                          <textarea
                            class="form-control"
                            rows="3"
                            placeholder="Enter ..."
                            v-model="form.historyPe"
                          ></textarea>
                        </div>
                        <h4>PE</h4>
                        <div class="form-group">
                          <textarea
                            class="form-control"
                            rows="3"
                            placeholder="Enter ..."
                            v-model="form.pe"
                          ></textarea>
                        </div>
                        <h4>Diagnosis</h4>
                        <div class="form-group">
                          <textarea
                            class="form-control"
                            rows="3"
                            placeholder="Enter ..."
                            v-model="form.diagnosis"
                          ></textarea>
                        </div>
                        <h4>Remarks</h4>
                        <div class="form-group">
                          <textarea
                            class="form-control"
                            rows="3"
                            placeholder="Enter ..."
                            v-model="form.remarks"
                          ></textarea>
                        </div>
                        <div class="card-footer">
                          <!-- <div class="col-md-6">
                 
                    <button
                            type="button"
                            @click="saveHPE()"
                            class="btn btn-primary pull-right"
                          >
                            Submit
                          </button>
                          
                        <button
                          type="button"
                          class="btn btn-success pull-right"
                          data-card-widget="collapse"
                          @click="viewChart()"
                        >
                          View Chart
                        </button> </div> -->

                          <div class="btn-group ">
                            <button
                            type="button"
                            @click="saveHPE()"
                            class="btn btn-primary "
                          >
                            Submit
                          </button>
                          </div>

                          

                          <div class="btn-group ">
                            <button
                          type="button"
                          class="btn btn-success"
                          data-card-widget="collapse"
                          @click="viewChart()"
                        >
                          View Chart
                        </button>
                          </div>


                        </div>
                      </form>
                    </div>
                    <div
                      class="tab-pane fade"
                      id="custom-tabs-one-profile"
                      role="tabpanel"
                      aria-labelledby="custom-tabs-one-profile-tab"
                    >
                      <div class="form-group">
                        <div class="col-md-12">
                          <div class="input-group">
                            <div class="col-md-12 text-center">
                              <button
                                :disabled="editedMeds"
                                id="pbm"
                                @click="type_of_prescription(1)"
                                class="btn btn-success btn-outline csbtn pull-center"
                                type="button"
                              >
                                <i class="fab fa-apple"></i>
                                <br />
                                MEAL
                              </button>
                              <button
                                :disabled="editedMeds"
                                id="pbf"
                                @click="type_of_prescription(2)"
                                class="btn btn-primary btn-outline csbtn pull-center"
                                type="button"
                              >
                                <i class="fa fa-clock"></i>
                                <br />
                                FREQUENCY
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="panel-body">
                        <div v-if="chosenMethod != null">
                          <div class="col-md-12">
                            <div class="input-group">
                              <div class="col-md-12 text-center">
                                <button
                                  :disabled="editedMeds"
                                  id="pbf"
                                  @click="not_carried()"
                                  class="btn btn-danger btn-outline csbtn pull-center"
                                  type="button"
                                >
                                  <i class="fa fa-clock"></i>
                                  MEDICINE NOT CARRIED
                                </button>
                              </div>
                            </div>
                          </div>
                          <br />
                          <div class="row" v-if="prescription.notCarried">
                            <div class="col-md-2">
                              <input
                                type="text"
                                class="form-control"
                                v-model="prescription.not_gn"
                                placeholder="GENERIC NAME"
                              />
                            </div>
                            <div class="col-md-2">
                              <input
                                type="text"
                                class="form-control"
                                v-model="prescription.not_bn"
                                placeholder="BRAND NAME"
                              />
                            </div>
                            <div class="col-md-2">
                              <input
                                type="text"
                                class="form-control"
                                v-model="prescription.not_dsg"
                                placeholder="DOSAGE"
                              />
                            </div>
                          </div>
                          <!-- <div class="form-group">
                                                        <div class="custom-control">
                                                            <label for="" class="">Medicine</label></div>
                                                    </div> -->

                          <div class="row" v-if="!prescription.notCarried">
                            <div class="col-md-12">
                              <autocomplete
                                :meds="this.prescription.generic_name"
                                ref="medicineVal"
                                @handle-form-data="clickedShowDetailModal"
                              ></autocomplete>
                            </div>
                          </div>
                          <br />
                          <div class="row" v-if="chosenMethod == 1">
                            <div class="col-md-3">
                              <div class="form-group row">
                                <label class=""
                                  >Breakfast:</label
                                >
                                <div class="col-md-6">
                                  <!-- <input type="text" v-model="prescription.breakFast" class="form-control"> -->
                                  <VueTimepicker
                                    format="hh:mm A"
                                    :key="bftimepickerKey"
                                    v-model="prescription.breakFast"
                                  ></VueTimepicker>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group row">
                                <label class=""
                                  >Lunch:</label
                                >
                                <div class="col-md-6">
                                  <!-- <input type="text" v-model="prescription.lunch" class="form-control"> -->
                                  <VueTimepicker
                                    format="hh:mm A"
                                    :key="ltimepickerKey"
                                    v-model="prescription.lunch"
                                  ></VueTimepicker>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group row">
                                <label class=""
                                  >Supper:</label
                                >
                                <div class="col-md-6">
                                  <!-- <input type="text" v-model="prescription.supper" class="form-control"> -->
                                  <VueTimepicker
                                    format="hh:mm A"
                                    :key="stimepickerKey"
                                    v-model="prescription.supper"
                                  ></VueTimepicker>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group row">
                                <label class=""
                                  >Bed Time:</label
                                >
                                <div class="col-md-6">
                                  <!-- <input type="text" v-model="prescription.bbt"  class="form-control"> -->
                                  <VueTimepicker
                                    format="hh:mm A"
                                    :key="bbtimepickerKey"
                                    v-model="prescription.bbt_time"
                                  ></VueTimepicker>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row" v-if="chosenMethod == 1">
                            <div class="col-md-3">
                              <div class="form-group row">
                                <label class=""
                                  >Due :</label
                                >
                                <div class="col-md-6">
                                  <!-- <input type="text" v-model="prescription.dueDate"
                                                                        class="form-control"> -->
                                  <datepicker
                                    name="date"
                                    v-model="prescription.dueDate"
                                    input-class="dpicker"
                                    :bootstrap-styling="true"
                                  >
                                  </datepicker>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group row">
                                <label class=""
                                  >Days:</label
                                >
                                <div class="col-md-6">
                                  <input
                                    type="number"
                                    v-model="prescription.days"
                                    class="form-control"
                                  />
                                </div>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group row">
                                <label class=""
                                  >Qty:</label
                                >
                                <div class="col-md-6">
                                  <input
                                    type="number"
                                    v-model="prescription.qty"
                                    class="form-control"
                                  />
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row" v-if="chosenMethod == 2">
                            <div class="col-md-3">
                              <div class="form-group row">
                                <label>Frequency:</label>
                                <div class="col-md-6">
                                  <select
                                    type="text"
                                    v-model="prescription.frequency"
                                    class="custom-select form-control-border"
                                    @change="selectFrequency($event)"
                                  >
                                    <option v-for="e in frequencies" v-bind:value="e.id">
                                      {{ e.desc }}
                                    </option>
                                  </select>
                                  <h6>{{ frequecyDesc }}</h6>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group row">
                                <label>Day/s:</label>
                                <div class="col-md-6">
                                  <input
                                    type="number"
                                    v-model="prescription.daysF"
                                    class="form-control form-control-border border-width-2"
                                    @change="calculateFrequencyQty()"
                                  />
                                </div>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group row">
                                <label>Qty:</label>
                                <div class="col-md-6">
                                  <input
                                    type="text"
                                    v-model="prescription.qtyF"
                                    class="form-control form-control-border border-width-2"
                                  />
                                </div>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group row">
                                <label class=""
                                  >Due Date:</label
                                >
                                <div class="col-md-6">
                                  <!-- <input type="text" v-model="prescription.dueDateF"
                                                                        class="form-control"> -->
                                  <datepicker
                                    name="date"
                                    v-model="prescription.dueDateF"
                                    input-class="dpicker"
                                    :bootstrap-styling="true"
                                  >
                                  </datepicker>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group row">
                                <label class="control-label text-left col-md-4"
                                  >Instruction :</label
                                >
                                <div class="col-md-12">
                                  <textarea
                                    class="form-control"
                                    v-model="prescription.instruction"
                                  ></textarea>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group row">
                                <div class="col-md-12">
                                  <button
                                    type="button"
                                    @click="AddMedicine()"
                                    class="btn btn-primary btn-block"
                                  >
                                    Add
                                  </button>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class=""></div>
                        </div>
                        <!-- <table id="myTable" class="table table-bordered table-hover"><thead class="thead-light"><tr><th>Generic</th><th>Brand</th><th>Dosage</th><th>Qty</th><th>Action</th></tr></thead><tbody><tr v-for="e in medicineList"  :key="e.id"><td>{{e.med_gen_name}}</td><td>{{e.med_desc}}</td><td v-if="e.dosage>0">{{e.dosage}}</td><td v-else="e.dosage>0"></td><td>{{e.quantity}}</td><td ><button type="button" class="btn btn-warning" @click="editMeds(e.method,e.id)"><i class="fas fa-edit"></i></button><button type="button" class="btn btn-danger" @click="removeMeds(e.id)"><i class="fas fa-trash"></i></button></td></tr></tbody></table> -->
                        <ul class="list-group">
                          <li
                            class="list-group-item"
                            v-for="e in medicineList"
                            :key="e.id"
                          >
                            <div class="d-flex w-100 justify-content-between">
                              <h5 class="mb-1">
                                <strong>{{ e.med_gen_name }} </strong>
                              </h5>
                            </div>
                            <span class="badge badge-secondary"> {{ e.med_desc }}</span>
                            <!-- <button type="button" class="btn btn-xs btn-warning"
                                                            @click="editMeds(e.method, e.id)">
                                                             <i class="fas fa-edit"></i> Edit
                                                        </button> -->
                            <button
                              type="button"
                              class="btn btn-xs btn-danger"
                              @click="removeMeds(e.id)"
                            >
                              <!-- <i class="fas fa-trash"></i> -->
                              Remove
                            </button>
                            <br />
                            <!-- <span class="badge badge-info" v-if="e.dosage>0">            Dosage:               {{e.dosage}}</span> -->
                            <!-- <span class="badge badge-info"> {{e.dosage}}</span> -->
                            <span class="badge badge-success">
                              QTY: {{ e.quantity }}</span
                            >
                          </li>
                        </ul>
                      </div>
                    </div>
                    <div
                      class="tab-pane fade"
                      id="custom-tabs-one-messages"
                      role="tabpanel"
                      aria-labelledby="custom-tabs-one-messages-tab"
                    >
                      <div class="panel-body">
                        <diagnostic
                          @get-diagnostics-data="clickedShowDetailModal2"
                          ref="getd"
                        >
                        </diagnostic>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group row">
                              <label class="control-label text-left col-md-4"
                                >Instruction :</label
                              >
                              <div class="col-md-12">
                                <textarea
                                  class="form-control"
                                  v-model="instructionD"
                                ></textarea>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!--   <table id="myTable" class="table table-bordered table-hover"><thead class="thead-light"><tr><th>Diagnostic</th><th>Instruction</th><th>Action</th></tr></thead><tbody><tr v-for="e in labList"  :key="e.id"><td>{{e.diagnostic}}</td><td>{{e.instruction}}</td><td ><button type="button" class="btn btn-danger" @click="removeLabs(e.id)"><i class="fas fa-trash"></i></button></td></tr></tbody></table>     -->
                      <ul class="list-group">
                        <li class="list-group-item" v-for="e in labList" :key="e.id">
                          <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">
                              <strong>{{ e.diagnostic }} </strong>
                            </h5>
                          </div>
                          <span class="badge badge-secondary"> {{ e.instruction }}</span>
                          <button
                            type="button"
                            class="btn btn-xs btn-danger"
                            @click="removeLabs(e.id)"
                          >
                            <!-- <i class="fas fa-trash"></i> -->
                            Remove
                          </button>
                        </li>
                      </ul>
                      <button
                        type="button"
                        class="btn btn-primary"
                        @click="saveDiagnostics()"
                      >
                        Add
                      </button>
                    </div>
                    <div
                      class="tab-pane fade"
                      id="custom-tabs-one-settings"
                      role="tabpanel"
                      aria-labelledby="custom-tabs-one-settings-tab"
                    >
                      <form id="homeInsForm" enctype="multipart/form-data" method="POST">
                        <!-- <div class="col-md-12">
                          <div class="card">
                            <div class="card-body">
                              <h4 class="card-title">Diet/Nutrition</h4>
                              <hr />
                              <div class="form-check form-check-inline">
                                <div class="custom-control custom-radio">
                                  <input
                                    type="radio"
                                    class="custom-control-input"
                                    id="diet_ful"
                                    value="diet_full"
                                    name="diet"
                                  />
                                  <label class="custom-control-label" for="diet_ful"
                                    >Regular/Full</label
                                  >
                                </div>
                              </div>
                              <div class="form-check form-check-inline">
                                <div class="custom-control custom-radio">
                                  <input
                                    type="radio"
                                    class="custom-control-input"
                                    id="diet_soft"
                                    value="diet_soft"
                                    name="diet"
                                  />
                                  <label class="custom-control-label" for="diet_soft"
                                    >Soft</label
                                  >
                                </div>
                              </div>
                              <div class="form-check form-check-inline">
                                <div class="custom-control custom-radio">
                                  <input
                                    type="radio"
                                    class="custom-control-input"
                                    id="diet_salt"
                                    value="diet_salt"
                                    name="diet"
                                  />
                                  <label class="custom-control-label" for="diet_salt"
                                    >Low Salt</label
                                  >
                                </div>
                              </div>
                              <div class="form-check form-check-inline">
                                <div class="custom-control custom-radio">
                                  <input
                                    type="radio"
                                    class="custom-control-input"
                                    id="diet_fat"
                                    value="diet_fat"
                                    name="diet"
                                  />
                                  <label class="custom-control-label" for="diet_fat"
                                    >Low Fat</label
                                  >
                                </div>
                              </div>
                              <div class="form-check form-check-inline">
                                <div class="custom-control custom-radio">
                                  <input
                                    type="radio"
                                    class="custom-control-input"
                                    id="diet_other"
                                    value="diet_other"
                                    name="diet"
                                  />
                                  <label class="custom-control-label" for="diet_other"
                                    >Other</label
                                  >
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-12">
                                  <label>Specifications</label>
                                  <textarea
                                    class="form-control"
                                    name="diet_specs"
                                    id="diet_specs"
                                    cols="3"
                                    rows="3"
                                  ></textarea>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="card">
                            <div class="card-body">
                              <h4 class="card-title">Activity/Exercise</h4>
                              <hr />
                              <div class="form-check form-check-inline">
                                <div class="custom-control custom-radio">
                                  <input
                                    type="radio"
                                    class="custom-control-input"
                                    id="act_no_res"
                                    value="act_no_res"
                                    name="act"
                                  />
                                  <label class="custom-control-label" for="act_no_res"
                                    >No Restriction</label
                                  >
                                </div>
                              </div>
                              <div class="form-check form-check-inline">
                                <div class="custom-control custom-radio">
                                  <input
                                    type="radio"
                                    class="custom-control-input"
                                    id="act_w_res"
                                    value="act_w_res"
                                    name="act"
                                  />
                                  <label class="custom-control-label" for="act_w_res"
                                    >With Restriction</label
                                  >
                                </div>
                              </div>
                              <div class="form-check form-check-inline">
                                (&nbsp;
                                <div class="custom-control custom-radio">
                                  <input
                                    type="radio"
                                    class="custom-control-input"
                                    id="act_ass"
                                    value="act_ass"
                                    name="act_opt"
                                  />
                                  <label class="custom-control-label" for="act_ass">
                                    Assisted</label
                                  >
                                </div>
                              </div>
                              <div class="form-check form-check-inline">
                                <div class="custom-control custom-radio">
                                  <input
                                    type="radio"
                                    class="custom-control-input"
                                    id="act_ind"
                                    value="act_ind"
                                    name="act_opt"
                                  />
                                  <label class="custom-control-label" for="act_ind"
                                    >Independent )</label
                                  >
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-12">
                                  <label>Specifications</label>
                                  <textarea
                                    class="form-control"
                                    name="act_specs"
                                    id="act_specs"
                                    cols="3"
                                    rows="3"
                                  ></textarea>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div> -->
                        <div class="col-md-12">
                          <div class="card">
                            <!-- <div class="card-body">
                              <h4 class="card-title">
                                Additional Discharge Instructions
                              </h4>
                              <hr />
                              <div class="row">
                                <div class="col-md-12">
                                  <label>Specifications</label>
                                  <textarea
                                    class="form-control"
                                    name="additional_discharge_ins"
                                    id="additional_discharge_ins"
                                    cols="3"
                                    rows="3"
                                  ></textarea>
                                </div>
                              </div>
                            </div> -->
                            <div class="card-body" id="followupdivMain">
                              <h4 class="card-title"></h4>
                              <hr />
                              <div class="row">
                                <div class="col-md-3">
                                  <label>Follow-up Place</label>
                                  <div class="input-group date" id="followupDiv">
                                    <input
                                      type="text"
                                      name="followup_place"
                                      id="followup_place"
                                      class="form-control"
                                      v-model="form.followup_place"
                                    />
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-3">
                                  <label>Follow-up Check-up Date</label>
                                  <div class="input-group date" id="followupDiv">
                                    <!-- <input
                                      type="text"
                                      name="followup"
                                      id="followup"
                                      class="form-control"
                                      onkeydown="return false"
                                    /> -->
                                    <datepicker
                                      name="followup"
                                      v-model="form.followup"
                                      input-class="dpicker"
                                      :bootstrap-styling="true"
                                    >
                                    </datepicker>
                                    <!-- <div class="input-group-append input-group-addon">
                                      <span
                                        class="input-group-text badge-success"
                                        onclick="clearDate()"
                                        >Clear Date</span
                                      >
                                    </div> -->
                                  </div>
                                </div>
                              </div>
                              <!-- <div class="row">
                                <div class="col-md-12">
                                  <label>Nurse's Instruction</label>
                                  <textarea
                                    class="form-control"
                                    name="nurses_instructions"
                                    id="nurses_instructions"
                                    cols="3"
                                    rows="3"
                                    maxlength="250"
                                  ></textarea>
                                </div>
                              </div> -->
                            </div>
                          </div>
                        </div>
                        <!-- <br />
                        <div class="form-group m-b-0 text-right">
                          <button
                            type="button"
                            id="done"
                            class="btn btn-primary waves-effect waves-light"
                            onclick="setDone()"
                          >
                            Set As Done
                          </button>
                        </div> -->
                      </form>
                    </div>
                  </div>
                </div>
                <!-- <button id="show-modal" @click="showModal = true" class="btn btn-info pull-right"
                                    v-if="hasPrinting">Print Prescription</button> -->
                <button
                  v-if="hasPrinting"
                  type="button"
                  class="btn btn-lg btn-info"
                  @click="download()"
                >
                  Print Prescription
                </button>
                <button
                  id="show-modal"
                  @click="updatePeds()"
                  class="btn btn-success pull-right"
                  v-if="hasPrinting"
                >
                  Done
                </button>
                <br />
              </div>
            </div>
          </div>
        </div>
        <!-- use the modal component, pass in the prop -->
        <pxmodal
          v-if="showModal"
          @close="showModal = false"
          :name="user_info.patientname"
          :doctor="getAttendingDoctor"
          :pspat="this.$route.params.id"
        >
          <!--
                you can use custom content here to overwrite
                default content
                -->
          <!--  <h3 slot="header">custom header</h3> -->
        </pxmodal>
      </section>
    </div>
    <footerComponent></footerComponent>
  </div>
</template>

<script type="text/javascript">
import VueTimepicker from "vue2-timepicker";
import Datepicker from "vuejs-datepicker";
import moment from 'moment';
// CSS
import "vue2-timepicker/dist/VueTimepicker.css";

export default {
  components: {
    VueTimepicker,
    Datepicker,
  },
  created() {
    if (!User.loggedIn()) {
      this.$router.push({ name: "/" });
    }
    this.getPatientInformation();
    this.editForm();
    //this.getDiagnosisInfo()
    this.getFrequency();
    this.getMedicine();
    this.getLabs();
  },

  data() {
    return {
      bftimepickerKey: 0,
      ltimepickerKey: 0,
      stimepickerKey: 0,
      bbtimepickerKey: 0,
      activeModal: 0,
      frequecyDesc: "",
      showModal: false,
      form: {
        o2_stat: "",
        pulse_rate: "",
        rr: "",
        temp: "",
        bp: "",
        weight: "",
        height: "",
        chiefcomplaints: "",
        pspat: this.$route.params.id,
        user_id: User.user_id(),
        historyPe: "",
        pe: "",
        diagnosis: "",
        remarks: "",
        followup:"",
        followup_place:"",
      },
      editedMeds: false,
      prescription: {
        breakFast: "",
        lunch: "",
        supper: "",
        bbt_time: "",
        dueDate: "",
        days: "",
        qty: "",
        dueDateF: null,
        daysF: null,
        qtyF: null,
        instruction: "",
        medcine_desc: "",
        medecine_id: 0,
        dosage: 0,
        generic_name: "",
        frequency: "",
        reg_p: 0,
        dsc_p: 0,
        src_p: 0,
        pspat: "",
        pk_iwitems: 0,
        iscustome: false,
        dctr: User.user_id(),
        not_bn: "",
        not_gn: "",
        not_dsg: "",
        notCarried: false,
      },
      diagnostics: [],
      user_info: {
        patientname: "",
        contactno: "",
        pk_pspatregisters: "",
        patientid: "",
      },
      errors: {},
      getSelectedMedicine: {},
      getSelectedDiagnostic: {},
      chosenMethod: null,
      isDoneDetails: true,
      diagnosisId: null,
      frequencies: [],
      medicineList: [],
      labList: [],
      isUpdate: false,
      prescription_id: null,
      selectdD: [],
      instructionD: null,
      //getAttendingDoctor: User.name(),
      getAttendingDoctor: User.user_id(),
      hasPrinting: false,
      selectedFrequencyDays: 0,
    };
  },
  props: ["results"],
  computed:{
    computeFrequencyDate(){        
        const newDueDateF = moment();
        const newDueDateFMoment = newDueDateF.add(this.prescription.daysF, 'days');
        //this.prescription.dueDateF = newDueDateFMoment.format('YYYY-MM-DD');
        return newDueDateFMoment.format('YYYY-MM-DD');
    }
  },
  methods: {
    addInitialdata() {
      axios
        .post("/api/saveInitialData")
        .then((res) => {
          Notification.success();
          Toast.fire({
            icon: "success",
            title: "Saved successfully",
          });
          this.$router.push({ name: "all_employee" });
        })
        .catch((error) => (this.errors = error.response.data.errors));
    },
    getPatientInformation() {
      axios
        .get("/api/getPxInfo/" + this.$route.params.id)
        .then(({ data }) => (this.user_info = data))
        .catch();
    },
    not_carried() {
      if (!this.prescription.notCarried) {
        this.prescription.notCarried = true;
      } else {
        this.prescription.notCarried = false;
      }
    },
    download() {
      window.open(
        "/api/print_prescription/" + this.$route.params.id + "/" + User.user_id()
      );
    },
    updatePeds() {
      axios
        .post("/api/upDateHPE", this.form)
        .then((res) => {
          (this.isDoneDetails = false),
            Toast.fire({
              icon: "success",
              title: "Saved successfully",
            });
        })
        .catch((error) => (this.errors = error.response.data.errors));
        
      axios
        .get("/api/update-peds/" + User.user_id() + "/" + this.$route.params.id)
        .then(({ data }) =>
          //alert(this.$route.params.id),
          Toast.fire({
            icon: "success",
            title: "Transfered successfully",
          })
        );
    },
    editForm() {
      let id = this.$route.params.id;
      axios
        .get("/api/getFormDetail/" + id)
        .then(
          ({ data }) => (
            //alert(this.form.history),
            (this.form.diagnosis = data.diagosis),
            (this.form.historyPe = data.history),
            (this.form.pe = data.pe),
            (this.form.pulse_rate = data.pulse_rate),
            (this.isDoneDetails = data.history ? false : true),
            (this.form.o2_stat =
              !Object.keys(data).length === 0 ? this.form.o2_stat : data.o2_stat),
            (this.form.temp =
              !Object.keys(data).length === 0 ? this.form.temp : data.temp),
            (this.form.rr = !Object.keys(data).length === 0 ? this.form.rr : data.rr),
            (this.form.bp = !Object.keys(data).length === 0 ? this.form.bp : data.bp),
            (this.form.weight =
              !Object.keys(data).length === 0 ? this.form.weight : data.weight),
            (this.form.height =
              !Object.keys(data).length === 0 ? this.form.height : data.height),
            (this.form.chiefcomplaints =
              !Object.keys(data).length === 0
                ? this.form.chiefcomplaints
                : data.chiefcomplaints),
            (this.diagnosisId = data.id)
          )
        )
        .catch(console.log("error"));
    },
    clickedShowDetailModal: function (value) {
      this.getSelectedMedicine = value;
      this.prescription.reg_p = this.getSelectedMedicine.reg_price;
      this.prescription.dsc_p = this.getSelectedMedicine.dc_price;
      this.prescription.src_p = this.getSelectedMedicine.sc_price;
      this.prescription.pk_iwitems = this.getSelectedMedicine.pk_iwitems;
      this.prescription.medecine_id = this.getSelectedMedicine.pk_iwitems;
      this.prescription.item_description = this.getSelectedMedicine.itemdesc;
      this.prescription.item_generic_name = this.getSelectedMedicine.genericname;
    },
    clickedShowDetailModal2: function (value) {
      this.getSelectedDiagnostic = value;
      //  console.log(this.getSelectedDiagnostic);
      this.selectdD.push({ d: value.itemdesc, id: value.pk_iwitems });
      console.log(value);
      this.$emit("update", this.getSelectedDiagnostic);
    },
    clickedShowDetailModal3: function (value) {
      console.log(value);
    },
    type_of_prescription(type) {
      this.chosenMethod = type;
      this.isUpdate = false;
    },
    saveHPE() {
      axios
        .post("/api/upDateHPE", this.form)
        .then((res) => {
          (this.isDoneDetails = false),
            Toast.fire({
              icon: "success",
              title: "Saved successfully",
            });
        })
        .catch((error) => (this.errors = error.response.data.errors));
    },
    AddMedicine(event) {
      if (this.chosenMethod == 1) {
        this.prescription.frequency = null;
        this.prescription.daysF = null;
        this.prescription.qtyF = null;
        this.prescription.dueDateF = null;
      } else if (this.chosenMethod == 2) {
        this.prescription.breakFast = null;
        this.prescription.lunch = null;
        this.prescription.supper = null;
        this.prescription.bbt_time = null;
        this.prescription.dueDate = null;
        this.prescription.days = null;
        this.prescription.qty = null;        
      }

      if (!this.prescription.notCarried) {
        if (this.getSelectedMedicine.genericname) {
          this.prescription.generic_name = this.getSelectedMedicine.genericname;
        } else {
          this.prescription.generic_name = this.$refs.medicineVal.form.val;
        }
      } else {
        this.prescription.generic_name = this.prescription.not_gn;
      }

      let query = "";
      if (this.isUpdate) {
        query = axios.post(
          "/api/updateMedicine/" + this.chosenMethod + "/" + this.prescription_id,
          this.prescription
        );
      } else {
        query = axios.post(
          "/api/addMedicine/" +
            this.chosenMethod +
            "/" +
            this.$route.params.id +
            "/" +
            this.diagnosisId,
          this.prescription
        );
      }
      let condition = this.prescription.notCarried
        ? this.prescription.not_gn != "" &&
          this.prescription.not_bn != "" &&
          this.prescription.not_dsg != ""
        : this.$refs.medicineVal.form.val;
      if (condition) {
        query
          .then((res) => {
            this.medicineList = [];
            Toast.fire({
              icon: "success",
              title: "Medicine added successfully",
            });
            this.getMedicine();
            this.isUpdate = false;
            this.editedMeds = false;
            this.hasPrinting = true;
            if (!this.prescription.notCarried) {
              this.$refs.medicineVal.form.val = "";
            }
            //this.prescription = Object.assign({}, this.prescription);

            this.prescription.breakFast = null;
            // Update the key to force re-rendering of the Timepicker component
            this.bftimepickerKey += 1;
            this.prescription.lunch = null;
            this.ltimepickerKey += 1;
            this.prescription.supper = null;
            this.stimepickerKey += 1;
            this.prescription.bbt_time = null;
            this.bbtimepickerKey += 1;
            this.prescription.dueDate = null;
            this.prescription.days = null;
            this.prescription.qty = null;

            this.prescription.instruction = "";
            this.prescription.medcine_desc = "";
            this.prescription.medecine_id = 0;
            this.prescription.dosage = 0;
            this.prescription.generic_name = "";
            this.prescription.frequency = "";
            this.prescription.reg_p = 0;

            this.prescription.generic_name = "";
            this.prescription.frequency = "";

            this.prescription.item_generic_name = null;
            this.prescription.item_description = null;

            this.prescription.dsc_p = 0;
            this.prescription.src_p = 0;
            //this.prescription.pspat = ''
            this.prescription.pk_iwitems = 0;
            this.prescription.iscustome = false;
            this.prescription.not_bn = "";
            this.prescription.not_gn = "";
            this.prescription.not_dsg = "";
            this.prescription.notCarried = false;

            this.prescription.daysF = null;
            this.prescription.qtyF = null;
            this.prescription.dueDateF = null;
          })
          .catch((error) => console.log(error));
      } else {
        Toast.fire({
          icon: "error",
          title: "Please check fields",
        });
      }
    },
    getFrequency() {
      axios
        .get("/api/getrequency")
        .then(({ data }) => (this.frequencies = data))
        .catch();
    },
    getMedicine() {
      axios
        .get("/api/getPrescribeMedicine/" + this.$route.params.id)
        .then(
          ({ data }) => (
            (this.medicineList = data),
            console.log(data ? false : true),
            (this.hasPrinting = data.length > 0 ? true : false)
          )
        )
        .catch();
    },
    editMeds(method, id) {
      this.isUpdate = true;
      this.chosenMethod = method;
      this.editedMeds = true;
      axios
        .get("/api/getPrecriptionDetail/" + id)
        .then(
          ({ data }) => (
            (this.prescription.breakFast = method == 1 ? data.bf_time : null),
            (this.prescription.lunch = method == 1 ? data.ln_time : null),
            (this.prescription.supper = method == 1 ? data.sp_time : null),
            (this.prescription.bbt_time = method == 1 ? data.bbt_time : null),
            (this.prescription.dueDate = method == 1 ? data.due : null),
            (this.prescription.days = method == 1 ? data.days : null),
            (this.prescription.qty = method == 1 ? data.quantity : null),
            (this.prescription.frequency = method == 2 ? data.frequency : null),
            (this.prescription.daysF = method == 2 ? data.days : null),
            (this.prescription.qtyF = method == 2 ? data.quantity : null),
            (this.prescription.dueDateF = method == 2 ? data.due : null),
            (this.prescription_id = data.prescription_id),
            (this.prescription.instruction = data.instruction),
            (this.prescription.pk_iwitems = data.medecine_id),
            (this.prescription.medecine_id = data.medecine_id),
            (this.prescription.item_description = data.medecine_desc),
            (this.prescription.item_generic_name = data.generic_name),
            this.$emit("update", data.generic_name)
          )
        )
        .catch();
    },
    saveDiagnostics() {
      /* console.log(this.$refs.getd.results3)
            this.$refs.getd.results3.forEach((element) => {
                alert(element.pk_iwitems);
            }); */
      /* {
                instructions:'Taken with meal',
                medcine_desc: '',
                medecine_id: 0,
                diagnosis_id: this.diagnosisId,
                generic_name: '',
                reg_p: 0,
                src_p: 0,
                pspat: '',
                pk_iwitems: this.$route.params.id,
                iscustome: false,
                dctr: User.user_id(),
            } */

      /* if(this.getSelectedMedicine.genericname){
                this.prescription.generic_name = this.getSelectedMedicine.genericname
            } else{
                this.prescription.generic_name = this.$refs.medicineVal.form.val
            } */

      axios
        .post("/api/addDiagnostics", {
          q: this.$refs.getd.results3,
          r: this.instructionD,
          dctr: User.user_id(),
          diagnosisId: this.diagnosisId,
          pspat: this.$route.params.id,
        })
        .then((res) => {
          (this.isDoneDetails = false),
            Toast.fire({
              icon: "success",
              title: "Saved successfully",
            });
          this.getLabs();
          this.hasPrinting = true;
          this.$refs.getd.results3 = [];
        })
        .catch((error) => (this.errors = error.response.data.errors));
    },
    getLabs() {
      axios
        .get("/api/getPrescribeLabs/" + this.$route.params.id)
        .then(({ data }) => (this.labList = data))
        .catch();
    },
    removeLabs(id) {
      axios
        .get("/api/destroyLab/" + id)
        .then(({ data }) => this.getLabs())
        .catch();
    },
    removeMeds(id) {
      axios
        .get("/api/destroyMeds/" + id)
        .then(({ data }) => this.getMedicine())
        .catch();
    },
    selectFrequency(event) {
      axios
        .get("/api/show_frequency/" + event.target.value)
        .then(
          ({ data }) => (
            (this.selectedFrequencyDays = data.quantity),
            (this.prescription.daysF = ""),
            (this.prescription.qtyF = ""),
            (this.frequecyDesc = data.frequency)
          )
        )
        .catch();
    },
    calculateFrequencyQty() {
      this.prescription.qtyF = this.selectedFrequencyDays * this.prescription.daysF;      
      this.prescription.dueDateF = this.computeFrequencyDate;
    },
    viewChart() {
      window.open("/api/printChart/" + this.user_info.patientid);
    },
  },
};
</script>

<style>
.pull-right {
  float: right !important;
}
</style>
