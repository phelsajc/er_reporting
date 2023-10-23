<template>
    <transition name="modal">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-container">
    
              <div class="modal-header">
                <slot name="header">
                   <!--  {{doctor}} -->
                </slot>
                <button type="button" class="btn btn-success pull-left" @click="download()"> <i class="fa fa-download"></i> </button>
              </div>
    
              <div class="modal-body">
                <slot name="body">
	<!-- <button @click="$refs.myPdfComponent.print()">print</button>               -->      
  <!-- WORKING BELOW -->
  <!-- <pdf ref="myPdfComponent" :src="src"></pdf> -->
  <vue-pdf-app style="height: 100vh;" :pdf="src" @open="openHandler"></vue-pdf-app>
                </slot>
<!--   <vue-pdf-app style="height: 100vh;" :pdf="src" @open="openHandler"></vue-pdf-app> -->
 <!--  <button @click="$refs.pdfRef.print()">print</button>  
    <vue-pdf-embed
      ref="pdfRef" source="/api/print_prescription/207891/John Carlo C. Lucasan" /> -->
              </div>
              <div class="modal-footer">
                <slot name="footer">
                 <!--  default footer -->
                  <button class="btn btn-danger" @click="$emit('close')">
                    Close
                  </button>
                </slot>
              </div>
            </div>
          </div>
        </div>
      </transition>
    </template>
    <script>
        
import pdf from 'vue-pdf'
/* import VuePdfApp from "vue-pdf-app";
import "vue-pdf-app/dist/icons/main.css"; */
/* import VuePdfEmbed from 'vue-pdf-embed/dist/vue2-pdf-embed' */

      export default {

components: {
 /*  pdf, */
    VuePdfApp,
  //VuePdfEmbed
    },
  data() {
    return {
      info: [],
      src: "/api/print_prescription/"+this.pspat+"/"+this.doctor
    };
  },
  methods: {
    async openHandler(pdfApp) {
      this.info = [];
      const info = await pdfApp.pdfDocument
        .getMetadata()
        .catch(console.error.bind(console));

      if (!info) return;
      const props = Object.keys(info.info);
      props.forEach((prop) => {
        const obj = {
          name: prop,
          value: info.info[prop]
        };
        this.info.push(obj);
      });
    },
    download(){
        window.open("/api/print_prescription/"+this.pspat+"/"+this.doctor)
    }
  },
        props: ['name','doctor','pspat']
      }
    </script>
    <style scoped>
        .container-iframe {
        position: relative;
        overflow: hidden;
        width: 100%;
        padding-top: 56.25%; /* 16:9 Aspect Ratio (divide 9 by 16 = 0.5625) */
        }

        /* Then style the iframe to fit in the container div with full height and width */
        .responsive-iframe {
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        width: 100%;
        height: 100%;
        }

        * {
            box-sizing: border-box;
        }
        .modal-mask {
            position: fixed;
            z-index: 9998;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, .5);
            transition: opacity .3s ease;
            overflow-x: auto;
        }
        .modal-container {
            width: 75%;
            height: 100%;
            margin: 149px auto;
            padding: 20px 30px;
            background-color: #fff;
            border-radius: 2px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
            transition: all .3s ease;
        }
        .modal-body {
            margin: 20px 0;
        }
        /*
         * The following styles are auto-applied to elements with
         * transition="modal" when their visibility is toggled
         * by Vue.js.
         *
         * You can easily play with the modal transition by editing
         * these styles.
         */
        .modal-enter {
          opacity: 0;
        }
        .modal-leave-active {
          opacity: 0;
        }
        .modal-enter .modal-container,
        .modal-leave-active .modal-container {
          -webkit-transform: scale(1.1);
          transform: scale(1.1);
        }
        </style>