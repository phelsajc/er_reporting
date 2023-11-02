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
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="#">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Employee</li>
                    </ol>
                </div>
                </div>
            </div>
            </section>
            <section class="content">
            <div class="container-fluid">
                <div class="row">
                <div class="col-12">
                    <div class="card card-success">
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
                                <p class="form-control-static">{{ user_info.patientname }}</p>
                            </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                            <label class="control-label text-right col-md-3">Mobile #:</label>
                            <div class="col-md-9">
                                <p class="form-control-static" id="mobileno">{{ user_info.contactno }}</p>
                            </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                            <label class="control-label text-right col-md-3">Registry #:</label>
                            <div class="col-md-9">
                                <p class="form-control-static" id="ack_date">{{ user_info.pk_pspatregisters }}</p>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                    <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Initial Data</h3>
                        <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="user" @submit.prevent="addInitialdata" enctype="multipart/form-data">
                        <h4>O2 Saturation</h4>
                        <div class="form-group">
                            <!-- <label for="exampleInputBorder">Bottom Border only <code>.form-control-border</code></label> -->
                            <input type="text" class="form-control form-control-border" id="exampleInputBorder" placeholder="Enter value here" v-model="form.o2_stat">
                        </div>
                        <h4>Pulse Rate</h4>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-border" id="exampleInputBorder" placeholder="Enter value here" v-model="form.pulse_rate">
                        </div>
                        <h4>RR</h4>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-border" id="exampleInputBorder" placeholder="Enter value here" v-model="form.rr">
                        </div>
                        <h4>Temperature</h4>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-border" id="exampleInputBorder" placeholder="Enter value here" v-model="form.temp">
                        </div>
                        <h4>BP</h4>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-border" id="exampleInputBorder" placeholder="Enter value here" v-model="form.bp">
                        </div>
                        <h4>Weight (Kg)</h4>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-border" id="exampleInputBorder" placeholder="Enter value here" v-model="form.weight">
                        </div>
                        <h4>Height (Cm)</h4>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-border" id="exampleInputBorder" placeholder="Enter value here" v-model="form.height">
                        </div>
                        <h4>Chief Complaints</h4>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-border" id="exampleInputBorder" placeholder="Enter value here" v-model="form.chiefcomplaints">
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary pull-right">Submit</button>
                        </div>
                        </form>
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
import AppStorage from '../../Helpers/AppStorage';


    export default {
        created(){
            if(!User.loggedIn()){
                this.$router.push({name: '/'})
            }
            this.getPatientInformation();
            this.editForm();
        },

        data() {
            return {
                form: {
                    o2_stat: '',
                    pulse_rate: '',
                    rr: '',
                    temp: '',
                    bp: '',
                    weight: '',
                    height: '',
                    chiefcomplaints: '',
                    pspat: this.$route.params.id,
                    patientid: null,
                    user_id: User.user_id()
                },
                user_info:{
                    patientname: '',
                    contactno: '',
                    pk_pspatregisters: '',
                    patientid: '',
                },
                errors:{}
            }
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
            addInitialdata(){
                axios.post('/api/saveInitialData',this.form)
                .then(res => {
                    Notification.success()
                    Toast.fire({
                        icon: 'success',
                        title: 'Saved successfully'
                    })
                    this.$router.push({name: 'all_employee'});
                })
                .catch(error => this.errors = error.response.data.errors)
            },
            getPatientInformation(){
                axios.get('/api/getPxInfo/'+this.$route.params.id)
                .then(({data}) => ( 
                    this.user_info = data,
                    this.form.patientid = this.user_info.patientid
                ))
                .catch()
            },
            editForm(){                
                let id = this.$route.params.id
                axios.get('/api/getFormDetail/'+id)
                    .then(({ data }) => (
                        this.form.o2_stat = !Object.keys(data).length === 0 ? this.form.o2_stat : data.o2_stat,  
                        this.form.temp = !Object.keys(data).length === 0 ? this.form.temp : data.temp,             
                        this.form.rr = !Object.keys(data).length === 0 ? this.form.rr : data.rr,             
                        this.form.bp = !Object.keys(data).length === 0 ? this.form.bp : data.bp,             
                        this.form.weight = !Object.keys(data).length === 0 ? this.form.weight : data.weight,             
                        this.form.height = !Object.keys(data).length === 0 ? this.form.height : data.height,             
                        this.form.chiefcomplaints = !Object.keys(data).length === 0 ? this.form.chiefcomplaints : data.chiefcomplaints,   
                        this.form.pulse_rate = !Object.keys(data).length === 0 ? this.form.pulse_rate : data.pulse_rate           
                                                      
                ))
                .catch(console.log('error'))
            }
            
        }
    }
    
</script>

<style>
 .pull-right{
    float:right !important;
 }
</style>