<template>
	<div>
		<div class="form-group">
			<router-link to="/admin/people/index" class="btn btn-default">Back</router-link>
		</div>
		
		<div class="panel panel-default">
			<div class="panel-heading">Edit people</div>
				<div class="panel-body">
					<form v-on:submit="saveForm()">
						<div class="row">
							<div class="col-xs-12 form-group">
								<label class="control-label">People name</label>
								<input type="text" v-model="people.name" class="form-control">
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 form-group">
								<label class="control-label">People surname</label>
								<input type="text" v-model="people.surname" class="form-control">
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 form-group">
								<label class="control-label">People patronymic</label>
								<input type="text" v-model="people.patronymic" class="form-control">
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 form-group">
								<label class="control-label">People phone 1</label>
								<input type="text" v-model="people.phone1" class="form-control">
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 form-group">
								<label class="control-label">People phone 2</label>
								<input type="text" v-model="people.phone2" class="form-control">
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 form-group">
								<label class="control-label">People job</label>
								<input type="text" v-model="people.job" class="form-control">
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 form-group">
								<label class="control-label">People e-mail</label>
								<input type="text" v-model="people.email" class="form-control">
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
								<select v-model="people.companies" class="form-control" size="4" >
									<option v-bind:value="company.id" v-for="company in companies" v-bind:key="company.id">{{ company.name }}</option>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 form-group">
								<select v-model="people.departments" class="form-control" size="4" >
									<option v-bind:value="department.id" v-for="department in departments" v-bind:key="department.id">{{ department.name }}</option>
								</select>
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
					companies: null,
					departments: null
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
				var newPeople = app.people;
				axios.post('/api/v1/people', newPeople)
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