<template>
	<div>
		<div class="form-group">
			<router-link to="/admin/people/index" class="btn btn-default">Back</router-link>
		</div>
		
		<div class="panel panel-default">
			<div class="panel-heading">Edit people</div>
				<div class="panel-body">
					<form v-on:submit="saveForm()">

							<div class="col-xs-12 form-group">
								<label class="control-label">People name</label>
								<input type="text" v-model="people.name" class="form-control">
							</div>

							<div class="col-xs-12 form-group">
								<label class="control-label">People surname</label>
								<input type="text" v-model="people.surname" class="form-control">
							</div>

							<div class="col-xs-12 form-group">
								<label class="control-label">People patronymic</label>
								<input type="text" v-model="people.patronymic" class="form-control">
							</div>

							<div class="col-xs-12 form-group">
								<label class="control-label">People phone 1</label>
								<input type="text" v-model="people.phone1" class="form-control">
							</div>

							<div class="col-xs-12 form-group">
								<label class="control-label">People phone 2</label>
								<input type="text" v-model="people.phone2" class="form-control">
							</div>

							<div class="col-xs-12 form-group">
								<label class="control-label">People job</label>
								<input type="text" v-model="people.job" class="form-control">
							</div>

							<div class="col-xs-12 form-group">
								<label class="control-label">People e-mail</label>
								<input type="text" v-model="people.email" class="form-control">
							</div>

							<div class="col-xs-12 form-group">
								<label class="control-label">People address</label>
								<input type="text" v-model="people.address" class="form-control">
							</div>

							<div class="col-xs-12 form-group">
								<select v-model="people.companies" v-on:change="onUserChange" class="form-control" size="4" multiple>
									<option v-bind:value="company.id" v-for="company in companies" v-bind:key="company.id">{{ company.name }}</option>
								</select>
							</div>

							<div class="col-xs-12 form-group">
								<select v-model="people.departments" class="form-control" size="4" multiple>
									<option v-bind:value="department.id" v-for="department in departments" v-bind:key="department.id">{{ department.name }}</option>
								</select>
							</div>
						
							<div class="col-xs-12 form-group">
								<button class="btn btn-success">Edit</button>
							</div>

					</form>
				</div>
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
			axios.get('/api/v1/people/' + id)
				.then(function (resp) {
					app.people = resp.data.onepeople;
					app.companies = resp.data.companies;
					app.departments = resp.data.departments;
					
					
					app.people.companies = resp.data.relcompanies;
					app.people.departments = resp.data.reldepartments;
					console.log(resp.data.relcompanies);
					console.log(app.people.companies);
					console.log(app.people);
				})
			 .catch(function () {
				 alert("Не удалось загрузить людей")
			  });
		},
		data: function () {
			return {
				people: {
					name: '',
					surname: '',
					patronymic: '',
					phone1: '',
					phone2: '',
					email: '',
					address: '',
					job: '',
					companies: null,
					departments: null
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
			},
			
			onUserChange() {
				var app = this;
				console.log(app.people.companies);
				console.log(app.people);				
			}
		}
	}
</script>