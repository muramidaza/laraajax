<template>
	<div>
		<div class="form-group">
			<router-link to="/admin/people/index" class="btn btn-success">Назад</router-link>
		</div>
		
		<div class="card">
			<div class="card-header">
				Создание новой записи
			</div>
			
			<div class="card-body">
				<form v-on:submit="saveForm()">

						<div class="col-xs-12 form-group">
							<label class="control-label">Имя</label>
							<input type="text" v-model="people.name" class="form-control" required>
							<ul v-if="errors.name" class="alert-danger">
								<li v-for="error in errors.name">{{error}}</li>
							</ul>	
						</div>

						<div class="col-xs-12 form-group">
							<label class="control-label">Фамилия</label>
							<input type="text" v-model="people.surname" class="form-control">
						</div>

						<div class="col-xs-12 form-group">
							<label class="control-label">Отчество</label>
							<input type="text" v-model="people.patronymic" class="form-control">
						</div>
						
						<div class="col-xs-12 form-group">
							<label class="control-label">Дата рождения</label>
							<input type="date" v-model="people.datebirth" class="form-control">
						</div>						

						<div class="col-xs-12 form-group">
							<label class="control-label">Пол:  </label>
							<input type="radio" value="man" v-model="people.sex"><label>М</label>
							<input type="radio" value="woman" v-model="people.sex"><label>Ж</label>
						</div>							
						
						<div class="col-xs-12 form-group">
							<label class="control-label">Номер телефона 1</label>
							<input type="text" v-model="people.phone1" class="form-control">
						</div>

						<div class="col-xs-12 form-group">
							<label class="control-label">Номер телефона 2</label>
							<input type="text" v-model="people.phone2" class="form-control">
						</div>

						<div class="col-xs-12 form-group">
							<label class="control-label">Должность</label>
							<input type="text" v-model="people.post" class="form-control">
						</div>

						<div class="col-xs-12 form-group">
							<label class="control-label">Адрес</label>
							<input type="text" v-model="people.address" class="form-control">
						</div>

						<div class="col-xs-12 form-group">
							<label class="control-label">E-mail</label>
							<input type="text" v-model="people.email" class="form-control">
						</div>

						<div class="col-xs-12 form-group">
							<label class="control-label">Соц сеть</label>
							<input type="text" v-model="people.web" class="form-control">
						</div>

						<div class="col-xs-12 form-group">
							<label class="control-label">Является представителем руководства</label>
							<input type="checkbox" id="executive" v-model="people.executive">
						</div>						
						
						<hr>
						
						<div class="col-xs-12 form-group">
							<label class="control-label">Photos</label>
							<input type="file" class="form-control" multiple v-on:change="onAttachmentChange">
							
							<div class="container">
								<div class="row">
									<div class="col-md-4 border" v-for="(image, index) in imagesData">
										<img v-bind:src="image" class="img-thumbnail" v-if="image.length>0">
										<a href="#" v-on:click="imagesData.splice(index, 1); people.files.splice(index, 1)">X</a>
									</div>
								</div>
							</div>
						</div>							
						
						<a name="tabs"></a>
						<ul class="nav nav-tabs">
							<li @click="currentTab='company'; tabs.company=true; tabs.department=false; tabs.single=false;" class="nav-item" v-bind:class="{'active': tabs.company}">
								<a href="#tabs" class="nav-link">
									Руководство компании
								</a>
							</li>
							<li @click="currentTab='department'; tabs.company=false; tabs.department=true; tabs.single=false;" class="nav-item" v-bind:class="{'active': tabs.department}">
								<a href="#tabs" class="nav-link">
									Персонал отдела
								</a>
							</li>
							<li @click="currentTab='single'; tabs.company=false; tabs.department=false; tabs.single=true;" class="nav-item" v-bind:class="{'active': tabs.single}">
								<a href="#tabs" class="nav-link">
									Частное лицо
								</a>
							</li>
						</ul>							
						
						<div class="tab-content">
							<div class="col-xs-12 form-group" v-if="currentTab=='company'">
								<select v-model="people.companies" class="form-control" size="4" multiple>
									<option v-bind:value="company.id" v-for="company in companies" v-bind:key="company.id">{{ company.name }}</option>								
								</select>
								<input type="button" class="btn btn-success" v-on:click="resetCompanies()" value="Reset">
							</div>
							<div class="col-xs-12 form-group" v-if="currentTab=='department'">
								<select v-model="people.departments" class="form-control" size="4" multiple>
									<option v-bind:value="department.id" v-for="department in departments" v-bind:key="department.id">{{ department.name }}</option>
								</select>
								<input type="button" class="btn btn-success" v-on:click="resetDepartments()" value="Reset">
							</div>
						</div>
						
						<hr>
						
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
				currentTab: 'single',
				people: {
					name: '',
					surname: '',
					patronymic: '',
					datebirth: null,
					sex: null,
					sexNum: null,
					phone1: '',
					phone2: '',
					address: '',
					post: '',
					email: '',
					web: '',
					files: [],
					executive: false,
					companies: [],
					departments: []
				},
				errors: {
					name: null
				},				
				companies: [],
				departments: [],
				imagesData: [],
				tabs: {
					company: false,
					department: false,
					single: true
				}
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
				alert("Не удалось загрузить данные");
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
				if(app.people.datebirth) formData.append('datebirth', app.people.datebirth); // если не указано не передаем - если передать то будет попытка записать в виде строки null в поле DATE
				if(app.people.sex) formData.append('sex', app.people.sex);
				formData.append('phone1', app.people.phone1);
				formData.append('phone2', app.people.phone2);
				formData.append('email', app.people.email);
				formData.append('web', app.people.web);
				formData.append('post', app.people.post);
				formData.append('address', app.people.address);
				formData.append('executive', +app.people.executive); //преобразуем в число иначе будет попытка записать в виде строки null в TINYINT
				formData.append('companies', app.people.companies);
				formData.append('departments', app.people.departments);
				
				app.people.files.forEach(function (file, i) {                    
					formData.append('Attachment[' + i + ']', file);
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
						if(JSON.parse(resp.request.responseText).message == 'The given data was invalid.') app.errors = JSON.parse(resp.request.responseText).errors; else alert("Ошибка на сервере");
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
				
				var arrfiles = [];
				for(var i = 0; i < e.target.files.length; i++) {
					arrfiles[i] = e.target.files[i];
					
					var reader = new FileReader();
					reader.onload = (e) => {
						app.imagesData.push(e.target.result);
					}
					reader.readAsDataURL(e.target.files[i]);					
				}
				
				app.people.files = arrfiles;
			}
		}
	}
</script>