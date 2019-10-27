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
 data: function () {
    return {
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
      axios.post('/api/v1/departments', newDepartment)
          .then(function (resp) {
              app.$router.push({path: '/admin/departments/index'});
           })
           .catch(function (resp) {
               console.log(resp);
               alert("Не удалось создать компанию");
            });
        }
     }
 }
</script>