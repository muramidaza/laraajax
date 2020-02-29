<template>
	<div>
		<div class="form-group">
			<router-link to="/admin/equipment/index" class="btn btn-success">Назад</router-link>
		</div>
		
		<div class="card">
			<div class="card-header">
				Создание новой записи
			</div>
			
			<div class="card-body">
				<form v-on:submit="saveForm()">

					<div class="col-xs-12 form-group">
						<label class="control-label">Тип</label>
						<input type="text" v-model="equipment.type" class="form-control" required>
						<ul v-if="errors.type" class="alert-danger">
							<li v-for="error in errors.type">{{error}}</li>
						</ul>	
					</div>

					<div class="col-xs-12 form-group">
						<label class="control-label">Производитель</label>
						<input type="text" v-model="equipment.manufacturer" class="form-control">
					</div>

					<div class="col-xs-12 form-group">
						<label class="control-label">Модель</label>
						<input type="text" v-model="equipment.model" class="form-control">
					</div>
					
					<div class="col-xs-12 form-group">
						<label class="control-label">Модификация</label>
						<input type="text" v-model="equipment.modification" class="form-control">
					</div>

					<div class="col-xs-12 form-group">
						<label class="control-label">Серийный номер</label>
						<input type="text" v-model="equipment.sernumber" class="form-control">
					</div>						
					
					<div class="col-xs-12 form-group">
						<label class="control-label">Дата изготовления</label>
						<input type="date" v-model="equipment.datemanuf" class="form-control">
					</div>			

					<div class="col-xs-12 form-group">
						<label class="control-label">Инвентарный номер</label>
						<input type="text" v-model="equipment.invnumber" class="form-control">
					</div>

					<div class="col-xs-12 form-group">
						<label class="control-label">Напряжение питания</label>
						<input type="text" v-model="equipment.voltage" class="form-control">
					</div>

					<div class="col-xs-12 form-group">
						<label class="control-label">Потребляемый ток</label>
						<input type="text" v-model="equipment.current" class="form-control">
					</div>

					<div class="col-xs-12 form-group">
						<label class="control-label">Мощность</label>
						<input type="text" v-model="equipment.power" class="form-control">
					</div>

					<div class="col-xs-12 form-group">
						<label class="control-label">Вес</label>
						<input type="text" v-model="equipment.weight" class="form-control">
					</div>
					
					<div class="col-xs-12 form-group">
						<label class="control-label">Размеры</label>
						<input type="text" v-model="equipment.sizes" class="form-control">
					</div>

					<div class="col-xs-12 form-group">
						<label class="control-label">Страна производитель</label>
						<input type="text" v-model="equipment.manufсountry" class="form-control">
					</div>

					<div class="col-xs-12 form-group">
						<label class="control-label">Описание</label><br>
						<textarea v-model="equipment.note"></textarea>
					</div>					

					<div class="col-xs-12 form-group">
						<label class="control-label">Состоит на обслуживании</label>
						<input type="checkbox" id="incontract" v-model="people.incontract">
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
						<div class="card-header">Новое местонахождение</div>
						<div class="cadr-body">
							<div class="col-xs-12 form-group">
								<ul v-for="company in companies" class="list-group">
									<li v-if="IDcompaniesToSave.includes(company.id)" class="list-group-item">{{ company.name }}</li>
								</ul>
								<ul v-for="company in companies" v-if="IDdepartmentsToSave.length > 0" class="list-group">
									<li v-if="companyIDforSearch == company.id" class="list-group-item">{{ company.name }}</li>
								</ul>
							</div>
							<div class="col-xs-12 form-group" v-if="IDdepartmentsToSave.length > 0">
								<p class="badge badge-primary">Подразделение компании</p>
								<ul v-for="department in foundDepartments" class="list-group">
									<li v-if="IDdepartmentsToSave.includes(department.id)" class="list-group-item">{{ department.name }}</li>
								</ul>
							</div>
							<div class="col-xs-12 form-group" v-if="IDdepartmentsToSave.length == 0 && IDcompaniesToSave.length == 0">
								<ul v-for="company in companies" class="list-group">
									<li v-if="IDcompaniesToSave.includes(company.id)" class="list-group-item">{{ company.name }}</li>
								</ul>
							</div>
						</div>
					</div>
					
					<a name="tabs"><b>Местонахождение</b></a>
					<ul class="nav nav-tabs">
						<li @click="currentTab='company'; tabs.company=true; tabs.department=false; tabs.single=false; searchCompanies()" class="nav-item">
							<a href="#tabs" class="nav-link" v-bind:class="{active: tabs.company}">
								Компания
							</a>
						</li>
						<li @click="currentTab='department'; tabs.company=false; tabs.department=true; tabs.single=false; searchCompanies()" class="nav-item">
							<a href="#tabs" class="nav-link" v-bind:class="{active: tabs.department}">
								Подразделение компании
							</a>
						</li>
						<li @click="currentTab='people'; tabs.company=false; tabs.department=false; tabs.people=true; searchPeople()" class="nav-item">
							<a href="#tabs" class="nav-link" v-bind:class="{active: tabs.people}">
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
						
						<div class="col-xs-12 form-group" v-if="currentTab=='people'">
							<select v-model="IDpeopleToSave" class="form-control" size="4" v-on:change="resetDepartments(); resetCompanies(); changePost = true" multiple>
								<option v-bind:value="onepeople.id" v-for="onepeople in people" v-bind:key="onepeople.id">{{ people.name + ' ' + people.surname + ' ' + people.patronymic}}</option>								
							</select>
							<input type="button" class="btn btn-success" v-on:click="resetCompanies()" value="Сбросить">
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
				equipment: {
					type: '',
					model: '',
					modification: '',
					manufacturer: '',
					sernumber: '',
					datemanuf: null,
					invnumber: '',
					voltage: '',
					current: '',
					power: '',
					weight: '',
					sizes: '',
					manufсountry: '',
					note: '',
					incontract: false,
					companies: null,
					departments: null,
					people: null
				},
				
				errors: {
					name: null
				},
				
				companies: [], // сюда загружаются компании при выборе вкладки Компании или Подразделения
				companyIDforSearch: null, //ID выбранной компании из списка
				foundDepartments: [], //сюда загружается список подразделений выбранной компании
				people: [], // сюда загружаются люди при выборе вкладки Частное лицо
				IDcompanyToSave: [], //ID компании которые нужно присоединить к данному оборудованию
				IDdepartmentToSave: [], //ID подразделения которые нужно присоединить к данному оборудованию
				IDpeopleToSave: [], //ID человека которые нужно присоединить к данному оборудованию
				
				imagesData: [], //пути на диске клиента к файлам, которые нужно загрузить на сервер
				files: [], //файлы, которые нужно загрузить на сервер
				
				currentTab: 'people',
				tabs: {
					company: false,
					department: false,
					people: true
				},
				changePost: false
			}
		},
		mounted() {
		},
		methods: {
			saveForm() {
				event.preventDefault();
				var app = this;
				console.log('save');
				
				const formData = new FormData();
				formData.append('type', app.equipment.type);
				formData.append('manufacturer', app.equipment.manufacturer);
				formData.append('model', app.equipment.model);
				if(app.equipment.modification) formData.append('modification', app.equipment.modification);
				if(app.equipment.sernumber) formData.append('sernumber', app.equipment.sernumber);
				if(app.equipment.datemanuf) formData.append('datemanuf', app.equipment.datemanuf); // если не указано не передаем - если передать то будет попытка записать в виде строки null в поле DATE
				if(app.equipment.invnumber) formData.append('invnumber', app.equipment.invnumber);
				if(app.equipment.voltage) formData.append('voltage', app.equipment.voltage);
				if(app.equipment.current) formData.append('current', app.equipment.current);
				if(app.equipment.power) formData.append('power', app.equipment.power);
				if(app.equipment.weight) formData.append('weight', app.equipment.weight);
				if(app.equipment.sizes) formData.append('sizes', app.equipment.sizes);
				if(app.equipment.note) formData.append('note', app.equipment.note);
				formData.append('incontract', +app.equipment.incontract); //преобразуем в число иначе будет попытка записать в виде строки null в TINYINT
				formData.append('companies', app.IDcompaniesToSave);
				formData.append('departments', app.IDdepartmentsToSave);
				formData.append('people', app.IDdepartmentsToSave);
				
				app.files.forEach(function (file, i) {                    
					formData.append('Attachment[' + i + ']', file); //прямо вот так по одному и втаскиваем в формДата - в контроллере понимает эти записи за один массив
				});
				
				axios.post('/api/v1/equipment', formData, {
						headers: {'Content-Type': 'multipart/form-data'}
					})
					.then(function (resp) {
						app.$router.push({path: '/admin/equipment/index'});
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
			resetPeople() {
				var app = this;
				app.IDpeopleToSave = [];
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
			},
			searchPeople() {
				var app = this;
				axios.get('/api/v1/search/people/')
					.then(function (resp) {
						app.people = resp.data.people;
					})
					.catch(function (resp) {
						alert("Не удалось загрузить данные");
					});				
			}			
		}
	}
</script>