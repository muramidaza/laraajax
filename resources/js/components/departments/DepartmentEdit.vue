<template>
 <div>
    <div class="form-group">
       <router-link to="/admin/departments/index" class="btn btn-default">Back</router-link>
    </div>
 
     <div class="panel panel-default">
        <div class="panel-heading">Create new department</div>
        <div class="panel-body">
           <form v-on:submit="saveForm()">
             <div class="row">
                <div class="col-xs-12 form-group">
                  <label class="control-label">Department name</label>
                  <input type="text" v-model="department.name" class="form-control">
                </div>
              </div>
             <div class="row">
                 <div class="col-xs-12 form-group">
                    <label class="control-label">Department address</label>
                    <input type="text" v-model="department.address" class="form-control">
                  </div>
              </div>
              <div class="row">
                 <div class="col-xs-12 form-group">
                    <label class="control-label">Department website</label>
                    <input type="text" v-model="department.website" class="form-control">
                 </div>
              </div>
              <div class="row">
                 <div class="col-xs-12 form-group">
                    <label class="control-label">Department email</label>
                    <input type="text" v-model="department.email" class="form-control">
                 </div>
              </div>
              <div class="row">
                 <div class="col-xs-12 form-group">
                    <button class="btn btn-success">Create</button>
                 </div>
              </div>
           </form>
       </div>
     </div>
 </div>
</template>

<script>
 export default {
    mounted() {
       let app = this;
       let id = app.$route.params.id;
       app.departmentId = id;
       axios.get('/api/v1/departments/' + id)
         .then(function (resp) {
             app.department = resp.data;
          })
         .catch(function () {
             alert("Не удалось загрузить компанию")
          });
    },
    data: function () {
        return {
           departmentId: null,
           department: {
               name: '',
               address: '',
               website: '',
               email: '',
          }
       }
    },
    methods: {
       saveForm() {
          event.preventDefault();
          var app = this;
          var newDepartment = app.department;
          axios.patch('/api/v1/departments/' + app.departmentId, newDepartment)
              .then(function (resp) {
                   app.$router.replace('/admin/department/index');
              })
              .catch(function (resp) {
                    console.log(resp);
                    alert("Не удалось создать компанию");
               });
        }
     }
 }
</script>