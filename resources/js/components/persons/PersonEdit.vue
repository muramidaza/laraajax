<template>
	<div>
		<div class="form-group">
			<div @click="$router.go(-1)" class="btn btn-success">Назад</div>
		</div>
		
		<div class="card">
			<div class="card-header">
				Редактирование существующей записи
			</div>
			
			<div class="card-body">
				<form v-on:submit="saveForm()">

					<div class="col-xs-12 form-group" v-if="person.companies.length>0">
						<div class="control-label" v-if="person.executive"><b>Является представителем руководства компании</b></div>
						<div class="control-label" v-else><b>Является сотрудником компании</b></div>
						<ul v-for="company in person.companies" class="list-group">
							<li class="list-group-item"> {{ company.name }} </li>
						</ul>
					</div>
					
					<div class="col-xs-12 form-group" v-if="person.departments.length>0">
						<div class="control-label" v-if="person.executive"><b>Является представителем руководства подразделений</b></div>
						<div class="control-label" v-else><b>Является сотрудником подразделений</b></div>
						<label class="control-label">Компании</label>
						<div class="form-control" v-if="person.departments.length > 0">{{ person.departments[0].company.name }}</div>
						<label class="control-label">Подразделение</label>
						<ul v-for="department in person.departments" class="list-group">
							<li class="list-group-item"> {{ department.name }} </li>
						</ul>
					</div>

					<hr>
					
					<div class="col-xs-12 form-group">
						<label class="control-label">Имя</label>
						<input type="text" v-model="person.name" class="form-control" required>
						<ul v-if="errors.name" class="alert-danger">
							<li v-for="error in errors.name">{{error}}</li>
						</ul>	
					</div>

					<div class="col-xs-12 form-group">
						<label class="control-label">Фамилия</label>
						<input type="text" v-model="person.surname" class="form-control">
					</div>

					<div class="col-xs-12 form-group">
						<label class="control-label">Отчество</label>
						<input type="text" v-model="person.patronymic" class="form-control">
					</div>
					
					<div class="col-xs-12 form-group">
						<label class="control-label">Дата рождения</label>
						<input type="date" v-model="person.datebirth" class="form-control">
					</div>						

					<div class="col-xs-12 form-group">
						<label class="control-label">Пол:  </label>
						<input type="radio" value="man" v-model="person.sex"><label>М</label>
						<input type="radio" value="woman" v-model="person.sex"><label>Ж</label>
					</div>							
					
					<div class="col-xs-12 form-group">
						<label class="control-label">Номер телефона 1</label>
						<input type="text" v-model="person.phone1" class="form-control">
					</div>

					<div class="col-xs-12 form-group">
						<label class="control-label">Номер телефона 2</label>
						<input type="text" v-model="person.phone2" class="form-control">
					</div>

					<div class="col-xs-12 form-group">
						<label class="control-label">Должность</label>
						<input type="text" v-model="person.post" class="form-control">
					</div>

					<div class="col-xs-12 form-group">
						<label class="control-label">Адрес</label>
						<input type="text" v-model="person.address" class="form-control">
					</div>

					<div class="col-xs-12 form-group">
						<label class="control-label">E-mail</label>
						<input type="text" v-model="person.email" class="form-control">
					</div>

					<div class="col-xs-12 form-group">
						<label class="control-label">Соц сеть</label>
						<input type="text" v-model="person.web" class="form-control">
					</div>

					<div class="col-xs-12 form-group">
						<label class="control-label">Является представителем руководства</label>
						<input type="checkbox" id="executive" v-model="person.executive">
					</div>						
					
					<hr>
					
					<div class="col-xs-12 form-group" v-if="person.files.length>0">
						<label class="control-label">Уже загруженные фотографии</label>
													
						<div class="container">
							<div class="row">
								<div class="col-md-4 border" v-for="(image, index) in person.files">
									<img v-bind:src="image['pathFile']" class="img-thumbnail" v-if="image['pathFile'].length>0">
									<p v-on:click="person.files.splice(index, 1); filesDeleteID.push(image['id'])">X</p>
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

					<div v-if="changePost" class="card">
						<div class="card-header">Измененное место работы</div>
						<div class="cadr-body">
							<div class="col-xs-12 form-group">
								<h5>Компания</h5>
								<ul v-for="company in companies" class="list-group">
									<li v-if="IDcompaniesToSave.includes(company.id)" class="list-group-item">{{ company.name }}</li>
								</ul>
								<ul v-for="company in companies" v-if="IDdepartmentsToSave.length > 0" class="list-group">
									<li v-if="companyIDforSearch == company.id" class="list-group-item">{{ company.name }}</li>
								</ul>
							</div>
							<div class="col-xs-12 form-group" v-if="IDdepartmentsToSave.length > 0">
								<h5>Подразделение компании</h5>
								<ul v-for="department in foundDepartments" class="list-group">
									<li v-if="IDdepartmentsToSave.includes(department.id)" class="list-group-item">{{ department.name }}</li>
								</ul>
							</div>
							<div class="col-xs-12 form-group" v-if="IDdepartmentsToSave.length == 0 && IDcompaniesToSave.length == 0">
								<p>Частное лицо</p>
							</div>
						</div>
					</div>						
					
					<a name="tabs"><b>Место работы</b></a>
					<ul class="nav nav-tabs">
						<li @click="currentTab='company'; searchCompanies()" class="nav-item">
							<a href="#tabs" class="nav-link" v-bind:class="{active: currentTab=='company'}">
								Компания
							</a>
						</li>
						<li @click="currentTab='department'; searchCompanies()" class="nav-item">
							<a href="#tabs" class="nav-link" v-bind:class="{active: currentTab=='department'}">
								Подразделение компании
							</a>
						</li>
						<li @click="currentTab='single'; tabs.single=true" class="nav-item">
							<a href="#tabs" class="nav-link" v-bind:class="{active: currentTab=='single'}">
								Частное лицо
							</a>
						</li>
					</ul>
					
					<div class="tab-content">
						<div class="col-xs-12 form-group" v-if="currentTab=='company'">
							<select v-model="IDcompaniesToSave" class="form-control" size="4" v-on:change="resetDepartments(); changePost = true" multiple>
								<option v-bind:value="company.id" v-for="company in companies" v-bind:key="company.id">{{ company.name }}</option>								
							</select>
							<input type="button" class="btn btn-success" v-on:click="resetCompanies()" value="Сбросить">
						</div>
						
						<div class="col-xs-12 form-group" v-if="currentTab=='department'">
							<select v-model="companyIDforSearch" class="form-control" size="4" v-on:change="searchDepartments()">
								<option v-bind:value="company.id" v-for="company in companies" v-bind:key="company.id">{{ company.name }}</option>								
							</select>
						
							<hr>
							<select v-model="IDdepartmentsToSave" class="form-control" size="4" v-on:change="resetCompanies(); changePost = true" multiple>
								<option v-bind:value="department.id" v-for="department in foundDepartments" v-bind:key="department.id">{{ department.name }}</option>
							</select>
							<input type="button" class="btn btn-success" v-on:click="resetDepartments()" value="Сбросить">
						</div>
						
						<div class="col-xs-12 form-group" v-if="currentTab=='single'">
							<input type="button" class="btn btn-success" v-on:click="resetCompanies(); resetDepartments(); changePost = true" value="Установить как частное лицо">
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
				personID: null,
				person: {
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
				},
				changePost: false
			}
		},
		mounted() {
			let app = this;
			let id = app.$route.params.id;
			app.personID = id;
			axios.get('/api/v1/persons/' + id + '/edit')
				.then(function (resp) {
					function DataToArrID(data) {
						if(data.length == 0) return [];
						var arr = [];
						data.forEach(function (elem) {arr.push(elem.id)});
						return arr;
					}
					
					app.person = resp.data.person;
					
					app.IDcompaniesToSave = DataToArrID(app.person.companies);
					app.IDdepartmentsToSave = DataToArrID(app.person.departments);
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
				formData.append('name', app.person.name);
				if(app.person.surname) formData.append('surname', app.person.surname);
				if(app.person.patronymic) formData.append('patronymic', app.person.patronymic);
				if(app.person.datebirth) formData.append('datebirth', app.person.datebirth); // если не указано не передаем - если передать то будет попытка записать в виде строки null в поле DATE
				if(app.person.sex) formData.append('sex', app.person.sex);
				if(app.person.phone1) formData.append('phone1', app.person.phone1);
				if(app.person.phone2) formData.append('phone2', app.person.phone2);
				if(app.person.email) formData.append('email', app.person.email);
				if(app.person.web) formData.append('web', app.person.web);
				if(app.person.post) formData.append('post', app.person.post);
				if(app.person.address) formData.append('address', app.person.address);
				formData.append('executive', +app.person.executive); //преобразуем в число иначе будет попытка записать в виде строки null в TINYINT
				formData.append('companies', app.IDcompaniesToSave);
				formData.append('departments', app.IDdepartmentsToSave);
				if(app.filesDeleteID) formData.append('delfiles', app.filesDeleteID);
				
				formData.append('_method', 'PATCH');
				
				app.files.forEach(function (file, i) {                    
					formData.append('Attachment[' + i + ']', file); //прямо вот так по одному и втаскиваем в формДата - в контроллере понимает эти записи за один массив
				});
				
				axios.post('/api/v1/persons/' + app.personID, formData, {
						headers: {'Content-Type': 'multipart/form-data'}
					})
					.then(function (resp) {
						app.$router.push({path: '/admin/persons/index'});
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

				app.files = app.files.concat(arrfiles);
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