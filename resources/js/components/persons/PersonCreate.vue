<template>
	<div>
		<div class="form-group">
			<div @click="$router.go(-1)" class="btn btn-success">Назад</div>
		</div>
		
		<div class="card">
			<div class="card-header">
				Создание новой записи
			</div>
			
			<div class="card-body">
				<form v-on:submit="saveForm()">
					
					<div class="col-xs-12 form-group" v-if="person.departments.length == 0 && person.companies.length == 0">
						<div class="control-label"><b>Является частным лицом</b></div>
					</div>				
				
					<div class="col-xs-12 form-group" v-if="person.companies.length>0">
						<div class="control-label"><b>Принадлежит компании</b></div>
						<ul v-for="company in companies" class="list-group">
							<li v-if="person.companies.indexOf(company.id) >= 0" class="list-group-item">{{ company.name }}</li>
						</ul>
					</div>
					
					<div class="col-xs-12 form-group" v-if="person.departments.length>0">
						<div class="control-label"><b>Принадлежит компании</b></div>
						<ul v-for="company in companies" class="list-group">
							<li v-if="companyIDforSearch == company.id" class="list-group-item">{{ company.name }}</li>
						</ul>
						<div class="control-label"><b>Подразделение</b></div>
						<ul v-for="department in foundDepartments" class="list-group">
							<li v-if="person.departments.indexOf(department.id) >= 0" class="list-group-item">{{ department.name }}</li>
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
					
					<div v-if="!redirect">
					
						<a name="tabs"><b>Место работы</b></a>
						<ul class="nav nav-tabs">
							<li @click="currentTab='company'; searchCompanies()" class="nav-item">
								<div class="nav-link" v-bind:class="{active: currentTab=='company'}">
									Компания
								</div>
							</li>
							<li @click="currentTab='department'; searchCompanies()" class="nav-item">
								<div class="nav-link" v-bind:class="{active: currentTab=='department'}">
									Подразделение компании
								</div>
							</li>
							<li @click="currentTab='single'" class="nav-item">
								<div class="nav-link" v-bind:class="{active: currentTab=='single'}">
									Частное лицо
								</div>
							</li>
						</ul>
						
						<div class="tab-content">
							<div class="col-xs-12 form-group" v-if="currentTab=='company'">
								<select v-model="person.companies" class="form-control" size="4" v-on:change="resetDepartments(); changePost = true" multiple>
									<option v-bind:value="company.id" v-for="company in companies" v-bind:key="company.id">{{ company.name }}</option>								
								</select>
								<input type="button" class="btn btn-success" v-on:click="resetCompanies()" value="Сбросить">
							</div>
							
							<div class="col-xs-12 form-group" v-if="currentTab=='department'">
								<select v-model="companyIDforSearch" class="form-control" size="4" v-on:change="searchDepartments()">
									<option v-bind:value="company.id" v-for="company in companies" v-bind:key="company.id">{{ company.name }}</option>								
								</select>
							
								<hr>
								<select v-model="person.departments" class="form-control" size="4" v-on:change="resetCompanies(); changePost = true" multiple>
									<option v-bind:value="department.id" v-for="department in foundDepartments" v-bind:key="department.id">{{ department.name }}</option>
								</select>
								<input type="button" class="btn btn-success" v-on:click="resetDepartments()" value="Сбросить">
							</div>
							
							<div class="col-xs-12 form-group" v-if="currentTab=='single'">
								<input type="button" class="btn btn-success" v-on:click="resetCompanies(); resetDepartments(); changePost = true" value="Установить как частное лицо">
							</div>							
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
					companies: [], //ID компаний которые нужно присоединить к данному человеку
					departments: [], //ID подразделений которые нужно присоединить к данному человеку
				},
				
				errors: {
					name: null
				},
				
				companies: [], // сюда загружаются компании при выборе вкладки Компании или Подразделения
				companyIDforSearch: null, //ID выбранной компании из списка
				foundDepartments: [], //сюда загружается список подразделений выбранной компании
				
				imagesData: [], //пути на диске клиента к файлам, которые нужно загрузить на сервер
				files: [], //файлы, которые нужно загрузить на сервер
				
				currentTab: 'single',
				changePost: false,
				redirect: false,
				showblock: false
			}
		},
		mounted() {
			let app = this;
			app.showblock = false;
			console.log('Mounted');
			console.log('Params company: ' + app.$route.params.companyId);
			console.log('Params department: ' + app.$route.params.departmentId);
			let test = "str";
			console.log('company ID in person');
			console.log(typeof(app.$route.params.companyId));
			
			if(app.$route.params.companyId && !app.$route.params.departmentId) {
				app.redirect = true;
				app.searchCompanies();
				app.person.companies.push(app.$route.params.companyId);
				
				console.log('company ' + app.person.companies);
				console.log(app.person.companies);
				console.log(app.companies);
			};
			if(app.$route.params.departmentId && app.$route.params.companyId) {
				app.redirect = true;
				
				app.searchCompanies();	
				app.companyIDforSearch = app.$route.params.companyId;				
				app.searchDepartments();
				app.person.departments.push(app.$route.params.departmentId);

				console.log('company ' + app.companyIDforSearch);
				console.log('department ' + app.person.departments);
			}
			
			console.log('companies person');
			console.log(app.person.companies);
			console.log('departments person');		
			console.log(app.person.departments);
			setTimeout(function() {app.showblock = true; console.log(app.companies)}, 1000);
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
				formData.append('companies', app.person.companies);
				formData.append('departments', app.person.departments);
				
				app.files.forEach(function (file, i) {                    
					formData.append('Attachment[' + i + ']', file); //прямо вот так по одному и втаскиваем в формДата - в контроллере понимает эти записи за один массив
				});
				
				axios.post('/api/v1/persons', formData, {
						headers: {'Content-Type': 'multipart/form-data'}
					})
					.then(function (resp) {
						app.$router.go(-1);
					})
					.catch(function (resp) {
						console.log(resp);
						if(JSON.parse(resp.request.responseText).message == 'The given data was invalid.') app.errors = JSON.parse(resp.request.responseText).errors; else alert("Ошибка на сервере");
					});				
				
			},
			resetCompanies() {
				var app = this;
				app.person.companies = [];
			},
			resetDepartments() {
				var app = this;
				app.person.departments = [];
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
				console.log('Search Departments');
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
				console.log('Search Companies');
				if(app.companies.length > 0) return; //если компании уже были найдены то выходим, подразделения придется искать для каждой компании отдельно
				axios.get('/api/v1/search/companies')
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