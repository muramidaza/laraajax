<template>
 <div>
    <div class="form-group">
       <router-link to="/admin/people/index" class="btn btn-default">Back</router-link>
    </div>
 
     <div class="panel panel-default">
        <div class="panel-heading">Create new people</div>
        <div class="panel-body" style="margin-left: 40px">
           <form v-on:submit="saveForm()">
             <div class="row">
                <div class="col-xs-12 form-group">
                  <label class="control-label">People name</label>
                  <input type="text" v-model="people.name" class="form-control">
                </div>
              </div>
             <div class="row">
                 <div class="col-xs-12 form-group">
                    <label class="control-label">People address</label>
                    <input type="text" v-model="people.address" class="form-control">
                  </div>
              </div>

			  <div class="row">
                 <div class="col-xs-12 form-group">	

					<select v-model="people.company_id" class="form-control" size="4">
						<option v-bind:value="company.id" v-for="company in companies" v-bind:key="company.id">{{ company.name }}</option>
					</select>				 
				 
             <div class="row">
                 <div class="col-xs-12 form-group">
                    <label class="control-label">People company_id</label><input type="text" v-model="people.company_id" class="form-control">
                  </div>
              </div>

				 
			     </div>
              </div>			  
			  
              <div class="row">
                 <div class="col-xs-12 form-group">
                    <button class="btn btn-success">Edit</button>
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
       app.peopleId = id;
       axios.get('/api/v1/peoples/' + id)
         .then(function (resp) {
             app.people = resp.data.people;
			 app.companies = resp.data.companies;
			 console.log(app.people);
          })
         .catch(function () {
             alert("Не удалось загрузить людей")
          });
    },
    data: function () {
        return {
           peopleId: null,
           people: {
               name: '',
               address: '',
			   company_id: null,
			   department_id: null
          },
		    companies: [],
			departments: []
       }
    },
    methods: {
       saveForm() {
          event.preventDefault();
          var app = this;
          var newPeople = app.people;
          axios.patch('/api/v1/people/' + app.peopleId, newPeople)
              .then(function (resp) {
                   app.$router.push({path: '/admin/people/index'});
              })
              .catch(function (resp) {
                    console.log(resp);
                    alert("Не удалось создать человека");
               });
        }
     }
 }
</script>