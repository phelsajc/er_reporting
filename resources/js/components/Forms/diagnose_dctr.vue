<template>
    <div>

        <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>&nbsp;</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Employee</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
<section class="content">
   <div class="container-fluid">
     <div class="row">
       <div class="col-12">
         <div class="card card-primary">
           <div class="card-header">
             <h3 class="card-title">Patient Information</h3>
             <div class="card-tools">
               <button type="button" class="btn btn-tool" data-card-widget="collapse">
                 <i class="fas fa-minus"></i>
               </button>
             </div>
           </div>
           <div class="card-body">
             <div class="row">
               <div class="col-md-4">
                 <div class="form-group row">
                   <label class="control-label text-right col-md-3">Patient:</label>
                   <div class="col-md-9">
                     <p class="form-control-static" id="patient_name"></p>
                   </div>
                 </div>
               </div>
               <div class="col-md-4">
                 <div class="form-group row">
                   <label class="control-label text-right col-md-3">Mobile #:</label>
                   <div class="col-md-9">
                     <p class="form-control-static" id="mobileno"></p>
                   </div>
                 </div>
               </div>
               <div class="col-md-4">
                 <div class="form-group row">
                   <label class="control-label text-right col-md-3">Registry Date:</label>
                   <div class="col-md-9">
                     <p class="form-control-static" id="ack_date"></p>
                   </div>
                 </div>
               </div>
             </div>
             <div class="row">
               <div class="col-md-4">
                 <div class="form-group row">
                   <label class="control-label text-right col-md-3">Patient:</label>
                   <div class="col-md-9">
                     <p class="form-control-static" id="patient_name"></p>
                   </div>
                 </div>
               </div>
               <div class="col-md-4">
                 <div class="form-group row">
                   <label class="control-label text-right col-md-3">Mobile #:</label>
                   <div class="col-md-9">
                     <p class="form-control-static" id="mobileno"></p>
                   </div>
                 </div>
               </div>
               <div class="col-md-4">
                 <div class="form-group row">
                   <label class="control-label text-right col-md-3">Registry Date:</label>
                   <div class="col-md-9">
                     <p class="form-control-static" id="ack_date"></p>
                   </div>
                 </div>
               </div>
             </div>
             <ul class="nav nav-tabs" role="tablist">
               <li class="nav-item" id="presTab">
                 <a class="nav-link active" data-toggle="tab" href="#profile" role="tab">
                   <span class="hidden-sm-up">
                     <i class="ti-user"></i>
                   </span>
                   <span class="hidden-xs-down">Prescription</span>
                 </a>
               </li>
               <li class="nav-item" id="diagTab">
                 <a class="nav-link" data-toggle="tab" href="#messages" role="tab">
                   <span class="hidden-sm-up">
                     <i class="ti-email"></i>
                   </span>
                   <span class="hidden-xs-down">Diagnostic</span>
                 </a>
               </li>
               <li class="nav-item" id="AddTab">
                 <a class="nav-link" data-toggle="tab" href="#adds_tab" role="tab">
                   <span class="hidden-sm-up">
                     <i class="ti-email"></i>
                   </span>
                   <span class="hidden-xs-down">Additional Instruction</span>
                 </a>
               </li>
             </ul>
             <div class="tab-content tabcontent-border">
               <div class="tab-pane active" id="profile" role="tabpanel">
                 <div class="table-responsive">
                   <br />
                   <div class="row">
                     <div class="col-md-12">
                       <div class="form-group">
                         <div class="col-md-10">
                           <div class="input-group">
                             <input id="tags" type="hidden" class="form-control form-control-sm" autofocus />
                             <span class="input-group-btn" id="btn-addon2">
                               <button type="button" id="sm_smbtn" class="btn btn-outline btn-sm btn-warning d-none" onclick="searchmed()">
                                 <i class="fa fa-search"></i> Search </button>
                             </span>
                             <div class="col-md-12 text-center">
                               <button id="pbm" onclick="prescribe_by_meal()" class="btn btn-success btn-outline  csbtn pull-center" type="button">
                                 <i class="fab fa-apple"></i>
                                 <br /> MEAL </button>
                               <button id="pbf" onclick="prescribe_by_freq()" class="btn btn-primary btn-outline csbtn pull-center" type="button">
                                 <i class="fa fa-clock"></i>
                                 <br /> FREQUENCY </button>
                             </div>
                           </div>
                         </div>
                       </div>
                       <div class="form-group row">
                         <label class="col-md-2 col-form-label">Medicine <span class="text-danger">*</span>
                         </label>
                         <div class="col-md-12">
                           <select id="tags_s" class="contacts" style="width: 100%;" placeholder="Choose medicine..."></select>
                         </div>
                         <button type="button" id="mncbr" class="btn btn-primary d-none" onclick="not_carried()">Medicine Not Carried by RMCI</button>
                       </div>
                       <div class="table-responsive d-none">
                         <table class="table table-striped table-hover" id="tbl2">
                           <thead class="">
                             <tr>
                               <th>Brand Name</th>
                               <th>Generic name</th>
                               <th>Status</th>
                               <th>Quantity</th>
                             </tr>
                           </thead>
                         </table>
                       </div>
                     </div>
                     <div class="col-md-12">
                       <div class="form-group">
                         <form id="formPrescription" enctype="multipart/form-data" method="POST">
                           { csrf_field() }
                           <input type="hidden" name="created_by" id="created_by" value="{$userg->id}}" />
                           <input type="hidden" name="created_at" id="created_at" value="date Y-m-d">
                           <input type="text" style="display: none;" name="medecine_id" id="medecine_id" />
                           <input type="text" style="display: none;" name="generic_name" id="generic_name" />
                           <input type="text" style="display: none;" name="medecine_desc" id="medecine_desc" />
                           <input type="number" style="display: none;" name="medecine_qty" id="medecine_qty" />
                           <input type="text" style="display: none;" name="prescription_id" id="prescription_id" />
                           <input type="text" style="display: none;" name="price" id="price" />
                           <input type="text" style="display: none;" name="dc_price" id="dc_price" />
                           <input type="text" style="display: none;" name="sc_price" id="sc_price" />
                           <div class="d-none">
                             <div class="">
                               <h3>SELECTED:</h3>
                             </div>
                             <div class="">
                               <div class="">
                                 <h3 style="color: #3c763d;" id="methodSelected"></h3>
                                 <div class="col-sm">
                                   <input type="hidden" class="form-control form-control-sm" readonly id="selectedmed" style="color: red;" />
                                 </div>
                               </div>
                             </div>
                           </div>
                           <div class="row">
                             <div class="col-md-3">
                               <h5 for="" id="custom_bn_lbl" class=" d-none">Brand Name</h5>
                               <input type="text" class="form-control d-none" name="custom_bn" id="custom_bn" placeholder="E.G NAPREX AMP - PNF">
                             </div>
                             <div class="col-md-3">
                               <h5 for="" id="custom_gn_lbl" class=" d-none">Generic Name</h5>
                               <input type="text" class="form-control d-none" name="custom_gn" id="custom_gn" placeholder="E.G PARACETAMOL">
                             </div>
                             <div class="col-md-3">
                               <h5 for="" id="custom_dose_lbl" class=" d-none">Dose</h5>
                               <input type="text" class="form-control d-none" name="custom_dose" id="custom_dose" placeholder="E.G 500MG">
                             </div>
                           </div>
                           <div class="form-group d-none" id="mealDiv">
                             <div class="row">
                               <div class="col-md-3">
                                 <h5>Breakfast:</h5>
                                 <div class="form-group">
                                   <input type="text" min="0" max="2" name="bf_time" id="bf_time" class="form-control form-control-sm" />
                                 </div>
                               </div>
                               <div class="col-md-3">
                                 <h5>Lunch:</h5>
                                 <div class="form-group">
                                   <input type="text" min="0" max="2" name="ln_time" id="ln_time" class="form-control form-control-sm" />
                                 </div>
                               </div>
                               <div class="col-md-3">
                                 <h5>Supper:</h5>
                                 <div class="form-group">
                                   <input type="text" min="0" max="2" name="sp_time" id="sp_time" class="form-control form-control-sm" />
                                   <label>Due Date </label>
                                   <input type="text" min="0" name="due_m" id="due_m" class="form-control form-control-sm" />
                                 </div>
                               </div>
                               <div class="col-md-3">
                                 <div class="form-group">
                                   <h5>Before Bed Time:</h5>
                                   <input type="text" min="0" max="2" name="bbt_time" id="bbt_time" class="form-control form-control-sm" />
                                   <input type="number" min="0" name="days_m" id="days_m" onkeydown="validateNumber(event);" onchange="computeQty()" class="form-control form-control-sm" />
                                   <label>Qty </label>
                                   <input type="number" min="0" name="qty_m" id="qty_m" onkeydown="validateNumber(event);" class="form-control form-control-sm" />
                                 </div>
                               </div>
                             </div>
                           </div>
                           <div class="form-group d-none" id="freqDiv">
                             <div class="row">
                               <div class="col-md-3">
                                 <label>Frequency <span class="text-danger">*</span>
                                 </label>
                                 <select name="frequency" id="frequency" class="form-control form-control-sm" onchange="selectFrequency()">
                                   <option selected disabled> Choose</option>
                                 </select>
                               </div>
                               <div id="DescDiv" class="col-md-3 d-none">
                                 <label>Description <span class="text-danger">*</span>
                                 </label>
                                 <input type="text" name="desc" id="desc" class="form-control form-control-sm" />
                               </div>
                               <div class="col-md-3">
                                 <label>Day/s <span class="text-danger">*</span>
                                 </label>
                                 <input type="number" name="days" id="days" onchange="calcF()" onkeydown="validateNumber(event);" class="form-control form-control-sm" />
                               </div>
                               <div class="col-md-3">
                                 <label>Quantity <span class="text-danger">*</span>
                                 </label>
                                 <input type="text" name="quantity" id="quantity" placeholder="Please Enter Quantity" onkeydown="validateNumber(event);" class="form-control form-control-sm" />
                               </div>
                               <div class="col-md-3">
                                 <label>Due Date <span class="text-danger">*</span>
                                 </label>
                                 <input type="text" name="due_f" id="due_f" placeholder="Please Enter Due Date" class="form-control form-control-sm" />
                               </div>
                             </div>
                           </div>
                           <div class="form-group d-none" id="InsDiv">
                             <label>Instruction <span class="text-danger">*</span>
                             </label>
                             <textarea name="instruction" id="instruction" cols="30" rows="5" class="form-control"></textarea>
                             <br />
                             <div class="m-t-20 text-right">
                               <button class="btn btn-primary btn-outline btn-sm" id="sm" type="button" onclick="save_medicine()">
                                 <i class="fa fa-save"></i> Save </button>
                             
                             </div>
                           </div>
                         </form>
                       </div>
                     </div>
                   </div>
                   <table class="table table-bordered display compact d-none" id="tblMeds" width="100%">
                     <thead class="">
                       <tr>
                         <th>Generic</th>
                         <th>Brand</th>
                         <th>Dosage</th>
                         <th>Frequency</th>
                         <th>Days</th>
                         <th>Quantity</th>
                         <th>Instruction</th>
                         <th>Action</th>
                       </tr>
                     </thead>
                   </table>
                 </div>
               </div>
               <div class="tab-pane p-20" id="messages" role="tabpanel">
                 <div class="form-group row">
                   <label class="col-md-2 col-form-label">Diagnostic <span class="text-danger">*</span>
                   </label>
                   <div class="col-md-12">
                     <select id="diagnostic_search_s" class="contacts" style="width: 100%;" placeholder="Choose examination..."></select>
                   </div>
                   <ul id="pck_detail"></ul>
                 </div>
                 <div class="form-group">
                   <div class="col-md-10">
                     <div class="input-group">
                       <span class="input-group-btn" id="btn-addon3">
                         <button type="button" class="btn btn-outline btn-sm btn-warning d-none" id="searchdiag" onclick="searchdiagnostic()">
                           <i class="fa fa-search"></i> Search </button>
                       </span>
                     </div>
                   </div>
                   <form id="formDiagnostic" enctype="multipart/form-data" method="POST">
                     <input type="hidden" name="created_by" id="created_by" value="{$userd->id}}" />
                     <!-- <input type="hidden" name="created_at" id="created_at" value="{{date(" Y-m-d ")}"> -->
                     <input type="text" style="display: none;" name="diagnostic" id="diagnostic" />
                     <input type="text" style="display: none;" name="diagnostic_code" id="diagnostic_code" />
                     <input type="text" style="display: none;" name="diagnostic_id" id="diagnostic_id" />
                     <input type="text" style="display: none;" name="price" id="diagnostic_price" />
                     <input type="text" style="display: none;" name="sc_price" id="diagnostic_sc_price" />
                     <!-- <input type="hidden" class="form-control form-control-sm form-control form-control-sm-sm" readonly id="selecteddiagnostic" style="color: red;" style="width: 50% !important;" /> -->
                     <input type="hidden" class="form-control form-control-sm form-control form-control-sm-sm" readonly id="selecteddiagnostic" />
                     <div class="form-group" id="DiagnosticInsDiv">
                       <label>Instruction </label>
                       <textarea name="instructions" id="instruction_d" cols="30" rows="5" class="form-control"></textarea>
                       <br />
                       <div class="m-t-20 text-right">
                         <button class="btn btn-outline btn-primary btn-sm" id="sm" type="button" onclick="save_diagnostic()">
                           <i class="fa fa-save"></i> Save </button>
                       </div>
                     </div>
                   </form>
                 </div>
                 <table class="table  table-bordered display compact" id="tblDiagnosticResult" width="100%">
                   <thead class="">
                     <tr>
                       <th>Diagnostic</th>
                       <th>Instruction</th>
                       <th>Action</th>
                     </tr>
                   </thead>
                 </table>
               </div>
               <div id="adds_tab" class="tab-pane p-20 " role="tabpanel">
                 <form id="homeInsForm" enctype="multipart/form-data" method="POST">
                   { csrf_field() }
                   <div class="col-md-12">
                     <div class="card">
                       <div class="card-body">
                         <h4 class="card-title">Diet/Nutrition</h4>
                         <hr>
                         <div class="form-check form-check-inline">
                           <div class="custom-control custom-radio">
                             <input type="radio" class="custom-control-input" id="diet_ful" value="diet_full" name="diet">
                             <label class="custom-control-label" for="diet_ful">Regular/Full</label>
                           </div>
                         </div>
                         <div class="form-check form-check-inline">
                           <div class="custom-control custom-radio">
                             <input type="radio" class="custom-control-input" id="diet_soft" value="diet_soft" name="diet">
                             <label class="custom-control-label" for="diet_soft">Soft</label>
                           </div>
                         </div>
                         <div class="form-check form-check-inline">
                           <div class="custom-control custom-radio">
                             <input type="radio" class="custom-control-input" id="diet_salt" value="diet_salt" name="diet">
                             <label class="custom-control-label" for="diet_salt">Low Salt</label>
                           </div>
                         </div>
                         <div class="form-check form-check-inline">
                           <div class="custom-control custom-radio">
                             <input type="radio" class="custom-control-input" id="diet_fat" value="diet_fat" name="diet">
                             <label class="custom-control-label" for="diet_fat">Low Fat</label>
                           </div>
                         </div>
                         <div class="form-check form-check-inline">
                           <div class="custom-control custom-radio">
                             <input type="radio" class="custom-control-input" id="diet_other" value="diet_other" name="diet">
                             <label class="custom-control-label" for="diet_other">Other</label>
                           </div>
                         </div>
                         <div class="row">
                           <div class="col-md-12">
                             <label>Specifications</label>
                             <textarea class="form-control" name="diet_specs" id="diet_specs" cols="3" rows="3"></textarea>
                           </div>
                         </div>
                       </div>
                     </div>
                   </div>
                   <div class="col-md-12">
                     <div class="card">
                       <div class="card-body">
                         <h4 class="card-title">Activity/Exercise</h4>
                         <hr>
                         <div class="form-check form-check-inline">
                           <div class="custom-control custom-radio">
                             <input type="radio" class="custom-control-input" id="act_no_res" value="act_no_res" name="act">
                             <label class="custom-control-label" for="act_no_res">No Restriction</label>
                           </div>
                         </div>
                         <div class="form-check form-check-inline">
                           <div class="custom-control custom-radio">
                             <input type="radio" class="custom-control-input" id="act_w_res" value="act_w_res" name="act">
                             <label class="custom-control-label" for="act_w_res">With Restriction</label>
                           </div>
                         </div>
                         <div class="form-check form-check-inline">(&nbsp; <div class="custom-control custom-radio">
                             <input type="radio" class="custom-control-input" id="act_ass" value="act_ass" name="act_opt">
                             <label class="custom-control-label" for="act_ass"> Assisted</label>
                           </div>
                         </div>
                         <div class="form-check form-check-inline">
                           <div class="custom-control custom-radio">
                             <input type="radio" class="custom-control-input" id="act_ind" value="act_ind" name="act_opt">
                             <label class="custom-control-label" for="act_ind">Independent )</label>
                           </div>
                         </div>
                         <div class="row">
                           <div class="col-md-12">
                             <label>Specifications</label>
                             <textarea class="form-control" name="act_specs" id="act_specs" cols="3" rows="3"></textarea>
                           </div>
                         </div>
                       </div>
                     </div>
                   </div>
                   <div class="col-md-12">
                     <div class="card">
                       <div class="card-body">
                         <h4 class="card-title">Additional Discharge Instructions</h4>
                         <hr>
                         <div class="row">
                           <div class="col-md-12">
                             <label>Specifications</label>
                             <textarea class="form-control" name="additional_discharge_ins" id="additional_discharge_ins" cols="3" rows="3"></textarea>
                           </div>
                         </div>
                       </div>
                       <div class="card-body" id="followupdivMain">
                         <h4 class="card-title"></h4>
                         <hr>
                         <div class="row">
                           <div class="col-md-3">
                             <label>Follow-up Place</label>
                             <div class='input-group date' id='followupDiv'>
                               <input type='text' name="followup_place" id="followup_place" class="form-control" />
                             </div>
                           </div>
                         </div>
                         <div class="row">
                           <div class="col-md-3">
                             <label>Follow-up Check-up Date</label>
                             <div class='input-group date' id='followupDiv'>
                               <input type='text' name="followup" id="followup" class="form-control" onkeydown="return false" />
                               <div class="input-group-append input-group-addon">
                                 <span class="input-group-text badge-success" onclick="clearDate()">Clear Date</span>
                               </div>
                             </div>
                           </div>
                         </div>
                         <div class="row">
                           <div class="col-md-12">
                             <label>Nurse's Instruction</label>
                             <textarea class="form-control" name="nurses_instructions" id="nurses_instructions" cols="3" rows="3" maxlength="250"></textarea>
                           </div>
                         </div>
                       </div>
                     </div>
                   </div>
                   <br>
                   <div class="form-group m-b-0 text-right">
                     <button type="button" id="done" class="btn btn-primary waves-effect waves-light" onclick="setDone()">Set As Done</button>
                   </div>
                 </form>
               </div>
             </div>
             <button type="button" id="pedsBtn" class="btn btn-primary waves-effect waves-light d-none" onclick="done3()">Final Save</button>
             <button type="button" id="printHIBtn" class="btn btn-success waves-effect waves-light d-none" onclick="viewHI()">Preview Home Instruction</button>
             <button type="button" id="btnPrintF" class="btn btn-info waves-effect waves-light d-none" onclick="print_prescription()">Print Prescription</button>
           </div>
         </div>
       </div>
     </div>
   </div>
</section>   
   
    </div>
</template>

<script type="text/javascript">

    export default {
        created(){
            if(!User.loggedIn()){
                this.$router.push({name: '/'})
            }
        },

        data() {
            return {
                form: {
                    name: '',
                    email: '',
                    salary: '',
                    address: '',
                    joined_date: '',
                    nid: '',
                    phone: '',
                    newphone: '',
                    photo: '', 
                },
                errors:{}
            }
        },

        created(){
            let id = this.$route.params.id
            axios.get('/api/employee/'+id)
            .then(({data}) => (this.form = data))
            .catch(console.log('error'))
        },

        methods:{
            onFileSelected(event){
                let file = event.target.files[0];
                if(file.size > 1048770){
                    Notification.image_Validation()
                    console.log(1)
                }else{
                    let reader = new FileReader();
                    reader.onload = event => {
                        this.form.newphoto =  event.target.result
                    };
                    reader.readAsDataURL(file)
                }

            },
            employeeUpdate(){
                let id = this.$route.params.id
                axios.patch ('/api/employee/'+id,this.form)
                .then(res => {
                    this.$router.push({name: 'all_employee'});
                    Notification.success()
                })
                .catch(error => this.errors = error.response.data.errors)
            },
        }
    }
    
</script>

<style>

</style>