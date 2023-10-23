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
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Profile</li>
              </ol>
            </div>
          </div>
        </div>
      </section>

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">My Profile</h3>
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
                  <form
                    class="user"
                    @submit.prevent="addEmployee"
                    enctype="multipart/form-data"
                  >
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-6">
                          <h4>Name</h4>
                          <input
                            type="text"
                            class="form-control"
                            id=""
                            placeholder="Enter Fullname"
                            v-model="form.name"
                          />
                          <small class="text-danger" v-if="errors.name">{{
                            errors.name[0]
                          }}</small>
                        </div>
                        <div class="col-md-6">
                          <h4>PRC</h4>
                          <input
                            type="text"
                            class="form-control"
                            id=""
                            placeholder="Enter PRC"
                            v-model="form.prc"
                          />
                          <small class="text-danger" v-if="errors.prc">{{
                            errors.prc[0]
                          }}</small>
                        </div>
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-4">
                          <h4>PTR</h4>
                          <input
                            type="text"
                            class="form-control"
                            id=""
                            placeholder="Enter PTR"
                            v-model="form.ptr"
                          />
                          <small class="text-danger" v-if="errors.ptr">{{
                            errors.ptr[0]
                          }}</small>
                        </div>
                        <div class="col-md-4">
                          <h4>Valid Until</h4>
                          <datepicker
                                    name="date"
                                    v-model="form.validity"
                                    input-class="dpicker"
                                    :bootstrap-styling="true"
                                  >
                                  </datepicker>
                          <small class="text-danger" v-if="errors.ptr">{{
                            errors.ptr[0]
                          }}</small>
                        </div>
                        <div class="col-md-4">
                          <h4>Specialization</h4>
                          <input
                            type="text"
                            class="form-control"
                            id=""
                            placeholder="Enter Specialization"
                            v-model="form.specialization"
                          />
                          <small class="text-danger" v-if="errors.specialization">{{
                            errors.specialization[0]
                          }}</small>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-6">
                          <h4>Username</h4>
                          <input
                            type="text"
                            class="form-control"
                            id=""
                            placeholder="Enter User"
                            v-model="form.username"
                          />
                          <small class="text-danger" v-if="errors.username">{{
                            errors.username[0]
                          }}</small>
                        </div>
                        <div class="col-md-6">
                          <h4>Password</h4>
                          <input
                            type="password"
                            class="form-control"
                            id=""
                            placeholder="Enter Password"
                            v-model="form.password"
                          />
                          <small class="text-danger" v-if="errors.password">{{
                            errors.password[0]
                          }}</small>
                        </div>
                      </div>
                    </div>



                    <div class="form-group">
                      <div class="form-row">
                        <div class="col-md-12" id="signature">
                          <h4>Signature</h4>
                          <VueSignaturePad height="250px" ref="signaturePad" />
                        </div>
                      </div>
                    </div>

                    <div class="form-group" v-if="this.$route.params.id != 0">
                      <div class="form-row">
                        <div class="col-md-12" id="signature">
                          <h4>&nbsp;</h4>
                          <img :src="form.signatureData" alt="Captured Signature" />
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <button
                        type="button"
                        @click="clearSig()"
                        class="btn btn-warning btn-block"
                      >
                        Clear Signature
                      </button>
                      <button type="submit" class="btn btn-primary btn-block">
                        Submit
                      </button>
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
import AppStorage from "../../Helpers/AppStorage";
import Datepicker from "vuejs-datepicker";

export default {
  components: {
    Datepicker,
  },
  created() {
    if (!User.loggedIn()) {
      this.$router.push({ name: "/" });
    }
    /* this.getPatientInformation(); */
    if (this.$route.params.id != 0) {
      this.editForm();
    }
  },

  data() {
    return {
      //signatureData:"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAACWCAYAAABkW7XSAAAauElEQVR4Xu2dC9B+XzXHvyEld6HQICVCaCS3xq3+o8iQ0pBE5dLFtZjUmFEYlyKKSMglt2HkTiW3qSS3XHJXLslfUe4lMszn7azfrN\/6nfOey3PO8zz7eb575p33ed9nn33W+e59vnvttdZe+wZyMQJGwAg0gsANGpHTYhoBI2AEZMLyIDACRqAZBExYzXSVBTUCRsCE5TFgBIxAMwiYsJrpKgtqBIyACctjwAgYgWYQMGE101UW1AgYAROWx4ARMALNIGDCaqarLKgRMAImLI8BI2AEmkHAhNVMV1lQI2AETFgeA0bACDSDgAmrma6yoEbACJiwPAaMgBFoBgETVjNdZUGNgBEwYXkMGAEj0AwCJqxmusqCGgEjYMLyGDACRqAZBExYzXSVBTUCRsCE5TFgBIxAMwiYsJrpKgtqBIyACctjwAgYgWYQMGE101UW1AgYAROWx4ARMALNIGDCaqarLKgRMAImLI8BI2AEmkHAhNVMV1lQI2AETFjrjYEHS\/pfSb8l6YXrNeuWjIARCARMWOuMBQjq\/VNTHyXpV9dp2q0YASNgwlpvDDxe0hf3NPfekv54vdu4JSNgBKxh7TYG3lXSX6Um\/lLSrbu\/\/1HSR5q0dgPYVxuBjMBahMVy6F0k8QLz81bd74r2v0ji56+7L1g2\/auk32u0W7J2xbOwFPyVjqh4JJNWox1rsY8TgaWE9RHdS4kGwQ8lE8+Q\/QYiC1sPxAbJRYHEIC5+Q2q08fvd5+NET\/q\/JNhjJD26+zuT1r9J+gNJnyPpT471QSyXEWgBgTmEBUl9pqRP7DSoX5P0kx2xBMkseebQyiAyPsfvIDPICyILMoPE+Mz\/D1kgaogpSrVZ\/aikTy4C\/pykb7BB\/pDd5nu3jMAYYUEgnyHpiyT9TSKofXnAIC+IIZMaWtpbdoQVJBYEFhpZLDm37BvICFKixHKw3g+N6yt6hEC+70sa2ZZyum0jcDIIDBEWRMGLhjbFUocXcl8kNQZu2MeQMZaYQWhZKwutDzLjOfkN0aEZop1RFxIOTW2uxpY1rD+S9D4Dgr+TpPt1S0LkrAV8nyjpVWMP7u+NwLkj0EdYkNT3SHqCpG8+gqXXnD6CwILQsr0s\/h\/2M\/6GsF4g6ebd50xcfJ+dA9VZwN8fI+lunXBfJ+mREwQd0rheIulp1rgmIOgqZ41AJSzI6ick3aNb\/p06OJngQvvJGhzPH15PtLOxEva2WCbyuy5X+d+ndz\/XlQZ\/p9PGHL81hrS\/P0sEMmHxYmJEJggSY7rL1QhUcsO2Fx7Sl0u62UTAgsBYYr+npI+W9PbpWpayj5L0wxPbczUjcDYIZMJi+QdpoWW5jCNAwGhoZT8m6d7dJdlJEMtSlqJTNLR8VwiNiQOCw9ZG2YczYfzJXcMIHAiBICxePPbDEfjYahDnviHMMVhDXsIqU3YUQGahoREyMqXEkjNsapBmOA7it0ltCpKu0yQCQViELRBjlTfwNvlAexL6HST9fboXBvhnrXBv+uGbSjv\/JOllkt5vQfux\/MyxbIR+mNQWgOlLDo9AEFYEgLIsdBlH4O0kvSJVu6ukZ45fNqkGHlomj1wiij57OdHO3lkSkfThGIhr6i6CeuPYVQCh4WT528a8wfV5PknS0yeh60pNIxCExQyM7epYYq2OHdQanvC1naF8Lbn7ouTRvB7WcwOIK2tMVXuqsWqQXuz9pLnXSHpt2g7F9YwD4tVaKGx3wnlB+VhJv9CC0JZxGQIQVmQcuKWXCpNBfIikJ6Xaa2NXt\/3ErQh7+ClJz5F0X0l3HthkThDq9Z33EW0QEuKHz2\/afX4jSXfq9oBij4PYanmdpH+Q9B8doX1wVyG3Fxu8+Y22RrlNqvennSb4XkmOyUCnimG3Y7ySFeNtJd1R0n1SHWR98ozGI\/Yux929tV6\/R\/SVkt6ww6XG6OVbjAUcs8c2SkwmY9fMeITzqpoJa2ybznkhc\/nTVg1obcLi7kNBpu4H6dWSbrIxEC+WdKuN7xHN18Dk\/H8+Z6JjMvjzGXLlfb5BlLzrcU+ayp\/7mg4vd90iF3\/na2Iyo036CRvsc7sKBEjz888z5L+qKoIjDB5CE9Z0FKudaQvCCmleKukWI6KxNeh5kt6407gYNAwWNCp+0JQYKPxG02HAhxaUmyZgFc2Lemhfb9NpM7eTdNMeGfBS4hCgcB12PJwR79j9j88MTmQg1ox2X1S0lvpyTukFUlH\/u6TvlHSH7gJeDLSu7+12aWSNEVtd\/puXqU+jjP\/zIoJhxN5xi1y\/L31SfD+UWinayhlKpjzrvutkTfa\/JN14ZQHQxLGZ0n\/fJomQoMklExaqsFXVadDl9DFcsXVKZLb+PKKIhp3psXu02fDCYeeMlEL1xcNxww9L1n2MI4gXoo7CUvBB3R+tTb6ZGDM59v0fzTICjcPZEvXi99yYv2mjfptaTHiMGSYazkO4tNCxPCSz4O0dgzUG15XvyW31Hak2szz2pS3LB0i6v6QbdlHwh3aQoJlHuqFMXpAVxEU2ii1lrNleI3niPiaQLft5rbYzmdFmBDnXDfhVi4zJhs38aNUoMvsiQMbLd0n6wSEQYibCyMjLAMu5jCPApuefT9Vam9HHn3BeDbSuIK88uFlWMaYgr7Vjv3J6H9pmWf5Dkj6123Uwa6kx73HPtnYsd\/synOQlcU428G6dOYLYRSZdQnEwEVxW8PRidrmmD+NFiwR5Nf7nbHtm5MGrF+\/cCSvDxbKRcfQJBUOICxvXM1ZaMval94mU1WsF8nr8r48AGhuruQ+XdC9JJL4cKmx3u4q04kUjYJTNvMxS+7A\/rA\/DfltkhmDtzfLsfySR8wpjosvVCBC5D4HlrUexZAx711LMsoYV+cgI98BZ8BuSPmRpw75ubwigddFfd+nyxdUbY5gnlOZK9pIgrJitvCyc1ldVw9ra6D5NquOthd0E8nqApDdPYrKUg7jIvTZ3yZhj4ZgsMESH95ao93seLxyWrAcBbKL0X90e+PWSvizq56UMAwb7g7Ws8fFUPVQ+g3Acs6jBcpGfuuEbg2vYu6a0VuPUGMvxP7xOzjoyBcXjq5M155CO\/HE\/wB+ZsBhEkWmU2dBlGIHqodoyDutU+yG8jIy7bKiHuNC4xnKy1YGdCYttRZEJ41TxO+Xn+u3OQB\/PyK6Ni9i+aixGy8JFzUzFhluXfgRMWOuNjIjvYszl8AiIi2SSQ+mOMKxjwI\/CkvCh3VkEJqz1+ucQLdUVDDJcmF0qYTErMbMx46GeM2BshL+2y2zD2mYYo23hAMoaF38zedZx+DUlj35MsByeYsLapn\/22SrH4T083ZCo+If2ueNjaUhdtjt8daei71PYY78X8SSorVH2ETh67JisKR\/aFmaJIC40\/5q6u2q5aFdoWSasNXvisG3lHSUEZt9hKH4I0npK57ZHZNRyZrAxu8JhH2+\/d88ZRx2HtT72EBJafjbOV60\/9wHeJPa+QVgkKXQyyvX7ZN8tYmz\/\/u6mlxIWdehw1PE8YCAu\/kfk8rkXE9Z+RgDePsZc2LfQtr5cEqdoMwMHMbGEID6OeEIvCffTN1vfpZpe7j1FM2DAoKLnFL0MGv63r42uWwMzt\/1DBY7euntZiRR+3+5FZql0DgXSyh7FyMAQe+OIxfr1LsLehHU6I4JcbORwo0wirHh0Bkv15GAIjdiZczq84hBGd9z4ZG1gb1Yuz++ynW650fhYhj+4Y3y97YBAkcOKFYC3mR1Lr+0mR7Zj3X+KhlVvh8aFQbQG\/kXUMoPl1Mkru13J+cTWnC1LThjI\/f5b0s9I+vzupkQCY8M5h0IYRGwlG3reyIF\/Dnic+jPmAOHHLCGsAGgo8I\/v0byY8SGulvKDT+387KG6MAZOvXBBvZwskLzuT0zbWEhxQ6obCv2BsflcSl8IRDz7uZxcfg59naMWesMaloCA1hU\/Q7lzInVqPXoq7gd5RjrXY4\/9yoQVqU2W4DZ2TY7mxmv7ueWC\/P1TJT1wrMET+x6SZsPzm5Xn+nhJP3tiz3quj5Nzzz1wFw1rCEAGUWSmXHLi8VC7QWI1kX\/ORx3fBTludWLyPtLLcI9v7dJvcOjCuw8AQ2aCD+q++1BJ2LTOqbA8f7Ykdv7n4o38pzEK8iri9lsQVoUpEtXzAsaRU9SJZGD7ymYYh4mGFocnKT7PzRSQA0e30rDy2p38638xMP7QqsjSSOHUmPrinsawHX+KHGYStfGg+qzNceyOucZV4UP7IKwlYLBP7LouedcLJjRQDwjIaV8hqjgiPurxN0vTm3V5wCOujFifIDJuyyELYReqy9QAcuox9RMe40oVcjmxpOEQiCkGZMiMkAfKueaC6iMs8ICwziX0Y84Ya6FuNr0QtH6PYyQs7DKkuuUUFnLNc6rvWi57CIvAQsgnB78GkYUWGNpf7PgHOK6BwNCoIoA2Op3lGsu2tUp4Bcm2+IXdGYOXtf1ISeyti7IFia71bFu0gwkizkTsa\/9isG9xY7e5KQKZsMjWcP0ahBVrzKGTiec+0Z+VI6j+rtuF\/9NzG+qpTzgGclIIvnxw52XrM2jny3OOakAkCyLpWzN+seSsvzlIc06YB3l\/Pq27+TUpYi\/BoJ7k8wWSvmUFzFpoIvqVcA+OOusr50biLfTbmIzhVLqSPWYNwsqqONHGbELd5QAAzq2reZ4vdmqPPd2E7yETbGaQCMSTD3Scg0U1uuOVIiI3TiqJJWj8DjsdL00+aJLPOAaC0LLdag5ZxaNX7Ja0MQHGo6vC6dLv0S3na3xgFha8maiO3Qt9dAAfQCDesad198U7fnHoy5yXdEhmXjJmc5LLR+EFZGAsKSy76lFEtMOAnHPibb131q4iI+Uruv1nkWJ3qrw1X8+YcTccD\/V39qL+Z5cfHm2O89k46iiIDLvalMKJMSS\/i1NJItf5lGtbrZOXDXkD9NDzsEEap8mVPOGtPviJyh3nXrKJnXLVpLsGYdEoNyENzYetQFpDxlNexKWZUCEBiDBsVeHy3mUDc7521+UGycmYTYiYh6w4GZdTjJE37+GMGLaspQWpoanFHs\/obLqDrVM876mWPBFhp4LcfzltimaSw3Oac8mDxRRnxqlidozPxcSDfZlA0cjUcc24XYuwAgBeDm4aBRsK2tfUgvseG1YUDNnh\/eL\/HA2EVjS31Pzfccp1aFhLQhPydhlm68uOK7pMXl64r+qCHyG+oeO7wwEQy8zQ1mp4CMtdbDn57DfaxVvGUghiy7Frc7E8tvoY1ONIsUhVXZfskNNn9WyhOpcl87H1WZaHvoIz+M17GWO119G2NmEhCFtHYo8bf88x\/vKSZUL6xpJ18D7dqcdzOqBqV\/mAgtdIunGXR+lN5jQqqS+n+MwmLkgELyCFZIljB0yOtR8kRj2M97HH8dWSsG\/xvNSJVC1BXKGxcR2fIb34H\/a30N7G7r\/v7+PUcu6LzDm8pZ7O\/bzuQE9yLOVi0tpvr8X4i50x\/E3oEBMPCs+lMZFbEBaPnz1W2FEQborb\/77J0EY7zIoRFMnfvHS3m4lvXjJwabY37bIkhEwflmSZs8TgxcINH1oThIAqvFb4BmJBqBDiRfL+zv6HHbCWyCcVQb35pQ9tjkHE56yZQWQMtCA2SDAcCNFG3ZUws+tGq\/fZJfNF2Bqfm+yr9NFb9MRlsVPgN0fv5gpjCITtObT+sNHGGMvjPfYZx57jsbYvvt+KsGg7llt8xmvITDZW8kZH6vKCYXzOm4vnHqkVB2vEvfMJN2HgX7Ik7EvRy3JurNB5kFV0LpoBz71FNtfwtNyiE+pHuqPcx2Sc8n14RKkLkcVg5DMDlr+DgIOMwZnJK7ylYMGkAfFlz10mxr5j0UM+Bn3Y+IYcH9UcwCxOfiUIPZct34UpeB5znSAgZIx+D\/tqONvoC2yn2J2q06x6xhd7abfspLpkmrI0zHYhwIFcyFaQj2xCs\/mSib1bCbCmzo0wgKXetJdKCjKYQso8B2SVtZitMwvUF3Ys5mwitDtVi+fPOxJoMF6MPOCjbrwoMdjfQBLhJFGeLInwBurXfadgnG2rjDPyiuWJEE8xpxDv4oneCZSNL66Y5i1xWcuOPuA37x+\/ISNIh88ROB2TSsQdbiz+65vfkrBovwYzjt2v1sd7xnHV+cCHOdoQM3mOy6mzcNxvqZdvzvNV4gCffW3Qrffeh92GCYvoezZws6tg8aw68CawG4IwDsrLJX1Kd4+8DSu0PV60u3YaezSHZov98kapfWx8EFYm0mgjqjH+YudDkGMlyTwhhReXa7J9JtqphMCkFqTANTxPaN+hiWeNNvbDZtLJWGdZK5RxbdZi8\/\/mBDyfBGGh\/uMpDC2EfYFEiQ8VUtyyj46SiQn7wgemi6YsC6uniMvrgae7EhbR93mW59QWZupasicrvhuL3Vp7AFRnyJakRdYIjNxR5mjFU567Lsenhrz0TRoQVz3IlYnS5QgRGNN41hB5TqhDjZqHACiPL4ZSot7H7EVVu+rL872L0R25SFn8iARSxZMXiyVgPcFljoF+jT6INvKSmy1PbDLfIoDyheWZXyXppis+SPau9k1El92qbyJ7bdG0DtU\/K0J0mk3tg7BArs7ufSl960DKAY91ZhwbUH2Dsm\/5FY6BpVlD66bje0p6ejdU+uxVfDUm+9YjDTseB1hQIHW0n7WT3dWlMve6OLl3hYfLoQw0t+RILzR+PNCElOTlWxYPDfQXN1jKrgDB+TaxL8ICYexQbImIUrfvYOe4X\/o+v9gPkPTdA9\/19V7VrmqMTp\/GseQw1Ho6bchcQynifvuyWY1pGA8pXrK1yCTum9M6x\/\/wIH3lCq9a1a52cVrUpWUV79CTywpwnVYT+yQskKtewExaGDtzVs27SPqlDm62VnD4QpTLBlKfdjVUHzsSy00K2znuPLN7qxeSpeodi0cqmtzlxZop1mj1u3eHWERFNoGjBaPJrlH6CGupJzbLA8Gw3AytiLivvn2nc58BGxh9SYxWLVva+ubKefb1901YAF7tG+GhwyDPy07BM4jbmejvKJns8ObcZKD3cmwOVSIzw5CXKuxYZOv87JnLo7pUpY2bF7l4qXA+HJvHBecGhJ3jkaaEZkx5afqM26\/sgn6vn9LAQJ2qXa2psRJkyjKxJvub45Xe4dF86RQEDkFYQ6SVY636sidUe1HWwOJZ+xK5jXnjWKqEZjH3ha0aVsUcQz8yre3Sn9K3U+tkz2xcc5EsbWoDPfVyCun89Y9LutfCdusWq7W0qywOtq3PK44Uvl97ybwQAl92KMIC+T7DbPTIUIaBfE0lFwZ0PrqcthjUsaVkqLerHWPO4GQpMbS5uyX7R1+KoF3kpy9YAsa2oLF+nfImXrbFasr1c+qgdRJgy3Ps49zJObKddd1DEhbAV5tWdMbQJuc6aPNxTn3azph2FferNhdCJp40weU\/lLvrmOxVUwc4Gm41xkM6OBaYQOYW0uTU8xqxlZGnfm5ZwzM4957UZ7z5EIslyG10zaEJi9QxzyzHr49lF82xU1nLIto54rZCu5pjkIWgeGGjEPJAjBKG9ByrRI55wgJY2tSUMq\/rHAdzT+HZqHsXNdtnf1qSSbbP8I5AS8ZcjeVb03a1CCRfdBgElgyeLSQlAJNMkBjgx2J1KrGgBWDIJ9NDLnO1HOwXaHwRaZ\/bCplI\/zKW9+pYMN2ln\/KZiLkdsCb8hIlijJSH7Fhz8QHz3027JUhFXZPx7fKsvrYhBOYOnmN4tL6whSrXLkc7DWkGU5+9RUyHng37H4d2ZIdI1EUTI\/XPyy4BJvKNRRVCSB4+FciuXt1Eb+1qJoCnVL3Vl4uXaChd8lxPX19\/3q2LS4psp0N9\/mJJt0pf4g3Mue1PZaxAWOSMQhOuhch+9ouGFhrkRhbQ2keP7fHAjWFU95fiFBnT7sba9PeNItAqYQE3g\/9LC+5Lsy4MdR\/LTE5Wjpcw8jixJHlUl8c+xzGR3uS2jY6FqWIzWaB5Va0LEiHD6Q0vaQhDfMTaTblftaetdZTclHu7zhEi0DJh5aUJn0k3sq9cRrEXLR\/2gAwfF8cRHWFfry0SZNLneKj34TQgEuZFmboFCtsVp1gTQBzlnPBdu79Oor1TIKxDdETNHoEMpIDOW4sOIdch7kkeKs6NwyNLlD85ptC2niXp+d1n4uOivKQso4dkxmOLgyXK2trzIbDyPXdEwIS1DMC+o8jmBJwuu2u7V9WwBLyNhIsMnbfY57HdJZC1XeQs+VUImLCWDYjHlTTNfpnGcSShH4n9cvnDLlNozclVbVdoavXa8Tu6xskhYMJa3qUEkGJwJy7pGcubOasr+\/YtAsB1kp7dIVHDGPj31B0LZwXmOT6sCesce\/1wz4xnkdQ2fbFYGOPZalUdGWukpTncE\/vOqyJgwloVTjc2EQHi255TUvFgjM8ewWiq5uGfeAtXO0UETFin2KvtPNNlGTt4Cjsy2unLvUhqwtoLzL7JAAK36Ta\/921StyPDw+YaBExYHhSHRqAvLZDTEh+6V470\/iasI+2YMxMLDevbJZFiGq\/rWMaOM4PHjxsImLA8FoyAEWgGARNWM11lQY2AETBheQwYASPQDAImrGa6yoIaASNgwvIYMAJGoBkETFjNdJUFNQJGwITlMWAEjEAzCJiwmukqC2oEjIAJy2PACBiBZhAwYTXTVRbUCBgBE5bHgBEwAs0gYMJqpqssqBEwAiYsjwEjYASaQcCE1UxXWVAjYARMWB4DRsAINIOACauZrrKgRsAImLA8BoyAEWgGARNWM11lQY2AETBheQwYASPQDAImrGa6yoIaASNgwvIYMAJGoBkETFjNdJUFNQJGwITlMWAEjEAzCJiwmukqC2oEjIAJy2PACBiBZhAwYTXTVRbUCBgBE5bHgBEwAs0gYMJqpqssqBEwAiYsjwEjYASaQcCE1UxXWVAjYARMWB4DRsAINIOACauZrrKgRsAImLA8BoyAEWgGARNWM11lQY2AETBheQwYASPQDAImrGa6yoIaASNgwvIYMAJGoBkETFjNdJUFNQJGwITlMWAEjEAzCJiwmukqC2oEjIAJy2PACBiBZhAwYTXTVRbUCBgBE5bHgBEwAs0gYMJqpqssqBEwAiYsjwEjYASaQeD\/AYyOC2gCY9LmAAAAAElFTkSuQmCC",
      form: {
        signatureData: null,
        name: "",
        username: "",
        password: "",
        type: "",
        validity:"",
        id: 0,
        prc: "",
        ptr: "",
        specialization: "",
      },
      user_info: {
        patientname: "",
        contactno: "",
        pk_pspatregisters: "",
      },
      errors: {},
    };
  },

  methods: {
    addEmployee() {
      const signaturePad = this.$refs.signaturePad.signaturePad;
      if (!this.$refs.signaturePad.isEmpty()) {
        this.form.signatureData = signaturePad.toDataURL();
      }
      axios
        .post("/api/addusers", this.form)
        .then((res) => {
          //this.$router.push({ name: "userslist" });
          Toast.fire({
            icon: "success",
            title: "Updated successfully",
          })
        })
        .catch((error) => (this.errors = error.response.data.errors));
    },
    onFileSelected(event) {
      let file = event.target.files[0];
      if (file.size > 1048770) {
        Notification.image_Validation();
        console.log(1);
      } else {
        let reader = new FileReader();
        reader.onload = (event) => {
          this.form.newphoto = event.target.result;
        };
        reader.readAsDataURL(file);
      }
    },
    getPatientInformation() {
      axios
        .get("/api/getPxInfo/" + this.$route.params.id)
        .then(({ data }) => (this.user_info = data))
        .catch();
    },
    editForm() {
      let id = this.$route.params.id;
      axios
        .get("/api/getUser/" + User.user_id())
        .then(
          ({ data }) => (
            (this.form.name =
              !Object.keys(data).length === 0 ? this.form.name : data.name),
            (this.form.type =
              !Object.keys(data).length === 0 ? this.form.type : data.type),
            (this.form.prc =
              !Object.keys(data).length === 0 ? this.form.prc : data.prcno),
            (this.form.ptr = !Object.keys(data).length === 0 ? this.form.bp : data.ptr),
            (this.form.specialization =
              !Object.keys(data).length === 0
                ? this.form.specialization
                : data.specialization),
            (this.form.signatureData =
              !Object.keys(data).length === 0 ? this.form.signatureData : data.signature),
            (this.form.id = !Object.keys(data).length === 0 ? this.form.id : data.id),
            (this.form.username =
              !Object.keys(data).length === 0 ? this.form.username : data.username),
            (this.form.validity =
              !Object.keys(data).length === 0 ? this.form.validity : data.validity)
          )
        )
        .catch(console.log("error"));
    },
    clearSig() {
      this.$refs.signaturePad.undoSignature();
    },
  },
};
</script>

<style>
.pull-right {
  float: right !important;
}

#signature {
  border: double 3px transparent;
  border-radius: 5px;
  background-image: linear-gradient(white, white),
    radial-gradient(circle at top left, #4bc5e8, #9f6274);
  background-origin: border-box;
  background-clip: content-box, border-box;
}
</style>
