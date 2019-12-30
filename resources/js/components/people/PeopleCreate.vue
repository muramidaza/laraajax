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
								<label class="control-label">Photos</label>
								<input type="file" class="form-control" multiple v-on:change="onAttachmentChange">
							</div>							

							<div class="col-xs-12 form-group">
								<select v-model="people.companies" class="form-control" size="4" multiple>
									<option v-bind:value="company.id" v-for="company in companies" v-bind:key="company.id">{{ company.name }}</option>								
								</select>
								<input type="button" class="btn btn-success" v-on:click="resetCompanies()" value="Reset">
							</div>

							<div class="col-xs-12 form-group">
								<select v-model="people.departments" class="form-control" size="4" multiple>
									<option v-bind:value="department.id" v-for="department in departments" v-bind:key="department.id">{{ department.name }}</option>
								</select>
								<input type="button" class="btn btn-success" v-on:click="resetDepartments()" value="Reset">
							</div>
						
							<div class="col-xs-12 form-group">
								<button class="btn btn-success">Create</button>
							</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</template>
 
<script>
	export default {
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
					files: [],
					companies: [],
					departments: []
				},
				companies: [],
				departments: []
			}
		},
		mounted() {
			var app = this;
			axios.get('/api/v1/people/create')
				.then(function (resp) {
					app.companies = resp.data.companies;
					app.departments = resp.data.departments;
				})
			.catch(function (resp) {
				console.log(resp);
				alert("Не удалось загрузить людей");
			});
		},
		methods: {
			saveForm() {
				event.preventDefault();
				var app = this;
				console.log('save');
				
				const formData = new FormData();
				formData.append('name', app.people.name);
				formData.append('surname', app.people.surname);
				formData.append('patronymic', app.people.patronymic);
				formData.append('phone1', app.people.phone1);
				formData.append('phone2', app.people.phone2);
				formData.append('email', app.people.email);
				formData.append('job', app.people.job);
				formData.append('companies', app.people.companies);
				formData.append('departments', app.people.departments);
				//formData.append('attachment', app.people.attachment);
				
				app.people.files.forEach(function (file, i) {                    
					formData.append('Attachment[' + i + ']', file); // is the var i against the var j, because the i is incremental the j is ever 0
				});
				
				var newPeople = app.people;
				axios.post('/api/v1/people', formData, {
						headers: {'Content-Type': 'multipart/form-data'}
					})
					.then(function (resp) {
						app.$router.push({path: '/admin/people/index'});
					})
					.catch(function (resp) {
						console.log(resp);
						alert("Не удалось создать человека");
					});
			},
			resetCompanies() {
				var app = this;
				app.people.companies = [];
			},
			resetDepartments() {
				var app = this;
				app.people.departments = [];
			},
			onAttachmentChange (e) {
				var app = this;
				//app.people.attachment = e.target.files;
				
				var arrfiles = [];
				for(var i = 0; i < e.target.files.length; i++) {
					arrfiles[i] = e.target.files[i];
				}
				
				
				app.people.files = arrfiles;
				
				console.log(e.target.files);
				console.log('add files');
				console.log(app.people.files);
			}
		}
	}
</script>