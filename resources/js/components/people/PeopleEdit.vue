<template>
	<div>
		<div class="form-group">
			<router-link to="/admin/people/index" class="btn btn-success">Назад</router-link>
		</div>
		
		<div class="card">
			<div class="card-header">
				Редактирование существующей записи
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
						
						<div class="col-xs-12 form-group" v-if="people.files.length>0">
							<label class="control-label">Уже загруженные фотографии</label>
														
							<div class="container">
								<div class="row">
									<div class="col-md-4 border" v-for="(image, index) in people.files">
										<img v-bind:src="image['pathFile']" class="img-thumbnail" v-if="image['pathFile'].length>0">
										<p v-on:click="people.files.splice(index, 1); filesDeleteID.push(image['id'])">X</p>
									</div>
								</div>
							</div>
						</div>

						<hr>
						
						<div class="col-xs-12 form-group">
							<label class="control-label">Фотографии которые нужно загрузить</label>
							<input type="file" class="form-control" multiple v-on:change="onAttachmentChange">
							
							<div class="container">
								<div class="row">
									<div class="col-md-4 border" v-for="(image, index) in imagesData">
										<img v-bind:src="image" class="img-thumbnail" v-if="image.length>0">
										<p href="#" v-on:click="imagesData.splice(index, 1); files.splice(index, 1)">X</p>
									</div>
								</div>
							</div>
						</div>							

						<hr>
						
						<div class="col-xs-12 form-group" v-if="people.companies.length>0">
							<div class="control-label" v-if="people.executive">Является представителем руководства компании</div>
							<div class="control-label" v-else>Является сотрудником компании</div>
							<ul v-for="company in people.companies">
								<li> {{ company.name }} </li>
							</ul>
						</div>
						
						<div class="col-xs-12 form-group" v-if="people.departments.length>0">
							<div class="control-label" v-if="people.executive">Является представителем руководства подразделения</div>
							<div class="control-label" v-else>Является сотрудником подразделения</div>
							<ul v-for="department in people.departments">
								<li> {{ department.name }} </li>
							</ul>
						</div>

						
						<a name="tabs"></a>
						<ul class="nav nav-tabs">
							<li @click="currentTab='company'; tabs.company=true; tabs.department=false; tabs.single=false; searchCompanies(); resetDepartments()" class="nav-item" v-bind:class="{'active': tabs.company}">
								<a href="#tabs" class="nav-link">
									Руководство компании
								</a>
							</li>
							<li @click="currentTab='department'; tabs.company=false; tabs.department=true; tabs.single=false; searchCompanies()" class="nav-item" v-bind:class="{'active': tabs.department}">
								<a href="#tabs" class="nav-link">
									Персонал отдела
								</a>
							</li>
							<li @click="currentTab='single'; tabs.company=false; tabs.department=false; tabs.single=true; resetCompanies(); resetDepartments()" class="nav-item" v-bind:class="{'active': tabs.single}">
								<a href="#tabs" class="nav-link">
									Частное лицо
								</a>
							</li>
						</ul>							
						
						<div class="tab-content">
							<div class="col-xs-12 form-group" v-if="currentTab=='company'">
								<select v-model="IDcompaniesToSave" class="form-control" size="4" multiple>
									<option v-bind:value="company.id" v-for="company in companies" v-bind:key="company.id">{{ company.name }}</option>								
								</select>
								<input type="button" class="btn btn-success" v-on:click="resetCompanies()" value="Reset">
							</div>
							
							<div class="col-xs-12 form-group" v-if="currentTab=='department'">
								<select v-model="companyIDforSearch" class="form-control" size="4" v-on:change="searchDepartments()">
									<option v-bind:value="company.id" v-for="company in companies" v-bind:key="company.id">{{ company.name }}</option>								
								</select>
							
								<hr>
								<select v-model="IDdepartmentsToSave" class="form-control" size="4" multiple>
									<option v-bind:value="department.id" v-for="department in foundDepartments" v-bind:key="department.id">{{ department.name }}</option>
								</select>
								<input type="button" class="btn btn-success" v-on:click="resetDepartments()" value="Reset">
							</div>
						</div>
						
						<hr>
						
						<div class="col-xs-12 form-group">
							<button class="btn btn-success">Сохранить изменения</button>
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
				peopleID: null,
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
					executive: false,
					companies: [],
					departments: [],
					files: [] //список файлов на сервере- при удалении их ID добавляются в filesDeleteID
				},
				
				errors: {
					name: null
				},
				
				companies: [], // сюда загружаются компании при выборе вкладки Компании или Подразделения
				companyIDforSearch: null, //ID выбранной компании из списка
				foundDepartments: [], //сюда загружается список подразделений выбранной компании
				IDcompaniesToSave: [], //ID компаний которые нужно присоединить к данному человеку
				IDdepartmentsToSave: [], //ID подразделений которые нужно присоединить к данному человеку
				
				imagesData: [], //пути на диске клиента к файлам, которые нужно загрузить на сервер
				files: [], //файлы, которые нужно загрузить на сервер
				filesDeleteID: [], //ID файлов которые нужно удалить
				
				currentTab: 'single',
				tabs: {
					company: false,
					department: false,
					single: true
				}
			}
		},
		mounted() {
			let app = this;
			let id = app.$route.params.id;
			app.peopleID = id;
			axios.get('/api/v1/people/' + id + '/edit')
				.then(function (resp) {
					function DataToArrID(data) {
						if(data.length == 0) return [];
						var arr = [];
						data.forEach(function (elem) {arr.push(elem.id)});
						return arr;
					}
					
					app.people = resp.data.onepeople;
					app.people.files = resp.data.relfiles;
					app.people.companies = resp.data.relcompanies;
					app.people.departments = resp.data.reldepartments;
					
					app.IDcompaniesToSave = DataToArrID(app.people.companies);
					app.IDdepartmentsToSave = DataToArrID(app.people.departments);
				})
			 .catch(function () {
				 alert("Не удалось загрузить данные")
			  });
		},
		methods: {
			saveForm() {
				event.preventDefault();
				var app = this;
				console.log('save');
				
				const formData = new FormData();
				formData.append('name', app.people.name);
				if(app.people.surname) formData.append('surname', app.people.surname);
				if(app.people.patronymic) formData.append('patronymic', app.people.patronymic);
				if(app.people.datebirth) formData.append('datebirth', app.people.datebirth); // если не указано не передаем - если передать то будет попытка записать в виде строки null в поле DATE
				if(app.people.sex) formData.append('sex', app.people.sex);
				if(app.people.phone1) formData.append('phone1', app.people.phone1);
				if(app.people.phone2) formData.append('phone2', app.people.phone2);
				if(app.people.email) formData.append('email', app.people.email);
				if(app.people.web) formData.append('web', app.people.web);
				if(app.people.post) formData.append('post', app.people.post);
				if(app.people.address) formData.append('address', app.people.address);
				formData.append('executive', +app.people.executive); //преобразуем в число иначе будет попытка записать в виде строки null в TINYINT
				formData.append('companies', app.IDcompaniesToSave);
				formData.append('departments', app.IDdepartmentsToSave);
				if(app.filesDeleteID) formData.append('delfiles', app.filesDeleteID);
				
				formData.append('_method', 'PATCH');
				
				app.files.forEach(function (file, i) {                    
					formData.append('Attachment[' + i + ']', file); //прямо вот так по одному и втаскиваем в формДата - в контроллере понимает эти записи за один массив
				});
				
				axios.post('/api/v1/people/' + app.peopleID, formData, {
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
				app.IDcompaniesToSave = [];
			},
			resetDepartments() {
				var app = this;
				app.IDdepartmentsToSave = [];
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
				
				app.files = arrfiles;
			},
			searchDepartments() {
				var app = this;
				console.log(app.companyIDforSearch);
				const formData = new FormData();
				var companyID = app.companyIDforSearch;
				axios.get('/api/v1/search/departments/' + companyID)
					.then(function (resp) {
						app.foundDepartments = resp.data.departments;
					})
					.catch(function (resp) {
						alert("Не удалось загрузить данные");
					});		
			},
			searchCompanies() {
				var app = this;
				axios.get('/api/v1/search/companies/')
					.then(function (resp) {
						app.companies = resp.data.companies;
					})
					.catch(function (resp) {
						alert("Не удалось загрузить данные");
					});				
			}
		}
	}
</script>