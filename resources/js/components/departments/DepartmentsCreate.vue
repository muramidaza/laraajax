<template>
	<div>
		<div class="form-group">
			<router-link to="/admin/departments/index" class="btn btn-success">Назад</router-link>
		</div>
		
		<div class="card">
			<div class="card-header">
				Создание новой записи
			</div>
			<div class="card-body">
				<form v-on:submit="saveForm()">

						<div class="col-xs-12 form-group">
							<label class="control-label">Название объекта</label>
							<input type="text" v-model="department.name" class="form-control">
							<ul v-if="errors.name" class="alert-danger">
								<li v-for="error in errors.name">{{error}}</li>
							</ul>							
						</div>

						<div class="col-xs-12 form-group">
							<label class="control-label">Адрес объекта</label>
							<input type="text" v-model="department.address" class="form-control">
							<ul v-if="errors.name" class="alert-danger">
								<li v-for="error in errors.address">{{error}}</li>
							</ul>							
						</div>
						
						<div class="col-xs-12 form-group">
							<label class="control-label">ФИО менеджера</label>
							<input type="text" v-model="department.manager" class="form-control">
						</div>
						
						<div class="col-xs-12 form-group">
							<label class="control-label">Телефон 1</label>
							<input type="text" v-model="department.phone1" class="form-control">
							<ul v-if="errors.name" class="alert-danger">
								<li v-for="error in errors.phone1">{{error}}</li>
							</ul>							
						</div>

						<div class="col-xs-12 form-group">
							<label class="control-label">Телефон 2</label>
							<input type="text" v-model="department.phone2" class="form-control">
						</div>						

						<div class="col-xs-12 form-group">	
							<select v-model="department.company_id" class="form-control" size="4" >
								<option v-bind:value="company.id" v-for="company in companies" v-bind:key="company.id">{{ company.name }}</option>
							</select>
							<input type="button" class="btn btn-success" v-on:click="resetCompanies()" value="Сбросить">
						</div>

						<div class="col-xs-12 form-group">
							<button class="btn btn-success">Создать запись</button>
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
					manager: '',
					phone1: '',
					phone2: '',
					company_id: null
				},
				errors: {
					name: null,
					manager: null,
					phone1: null
				},				
				companies: [] 
			}
		},
		mounted() {
			var app = this;
			axios.get('/api/v1/departments/create')
				.then(function (resp) {
					app.companies = resp.data.companies;
	   
				})
				.catch(function (resp) {
					alert("Не удалось загрузить отделы");
				});
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
						if(JSON.parse(resp.request.responseText).message == 'The given data was invalid.') app.errors = JSON.parse(resp.request.responseText).errors; else alert("Ошибка на сервере");
					});
			},
			resetCompanies() {
				var app = this;
				app.department.company_id = null;
			}		
		}
	}
</script>