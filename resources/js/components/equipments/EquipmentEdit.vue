<template>
	<div>
		<div class="form-group">
			<router-link to="/admin/equipments/index" class="btn btn-success">Назад</router-link>
		</div>
		
		<div class="card">
			<div class="card-header">
				Редактирование существующей записи
			</div>
			
			<div class="card-body">
				<form v-on:submit="saveForm()">

					<div class="col-xs-12 form-group" v-if="!(equipment.company === null)">
						<div class="control-label"><b>Принадлежит компании</b></div>
						<ul v-for="company in companies" class="list-group">
							<li v-if="equipment.company == company.id" class="list-group-item">{{ company.name }}</li>
						</ul>

					</div>
					<div class="col-xs-12 form-group" v-if="!(equipment.department === null)">
						<div class="control-label"><b>Принадлежит компании</b></div>
						<ul v-for="company in companies" v-if="equipment.department" class="list-group">
							<li v-if="companyIDforSearch == company.id" class="list-group-item">{{ company.name }}</li>
						</ul>						
						<div class="control-label"><b>Подразделение</b></div>
						<ul v-for="department in foundDepartments" class="list-group">
							<li v-if="equipment.department == department.id" class="list-group-item">{{ department.name }}</li>
						</ul>
					</div>
					<div class="col-xs-12 form-group" v-if="!(equipment.person === null)">
						<div class="control-label"><b>Принадлежит частному лицу</b></div>
						<ul v-for="person in persons" class="list-group">
							<li v-if="equipment.person == person.id" class="list-group-item">{{person.name}} {{person.surname}} {{person.patronymic}}</li>
						</ul>
					</div>
					
					<hr>

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
						<input type="checkbox" id="incontract" v-model="equipment.incontract">
					</div>						
					
					<hr>
					
					<div class="col-xs-12 form-group" v-if="equipment.files.length>0">
						<label class="control-label">Уже загруженные файлы</label>
													
						<div class="container">
							<h5>Фотографии</h5>
							<div class="row">
								<template v-for="(image, index) in equipment.files">
									<template v-if="image['typeFile'] == 'image/jpeg'">
										<div class="col-md-4 border" >
											<img v-bind:src="image['pathFile']" class="img-thumbnail" >
											<p v-on:click="equipment.files.splice(index, 1); filesDeleteID.push(image['id'])">X</p>
										</div>
									</template>
								</template>
							</div>
						</div>
						
						<div class="container">
							<h5>Документы</h5>
														
							<div class="row">
								<ul class="list-group" v-for="(file, index) in equipment.files">
									<li class="list-group-item" v-if="file['typeFile'] != 'image/jpeg'"><a v-bind:href="file['pathFile']">{{ file['nameFile'] }}</a></li>
								</ul>
							</div>
						</div>
					</div>
					
					<hr>
					
					<div class="col-xs-12 form-group">
						<label class="control-label">Файлы, которые нужно загрузить</label>
						<input type="file" class="form-control" multiple v-on:change="onAttachmentChange">
						<hr>
						<label class="control-label">Фотографии</label>
						
						<div class="container">
							<div class="row">
								<div class="col-md-4 border" v-for="(image, index) in imagesData">
									<img v-bind:src="image" class="img-thumbnail" v-if="image.length>0">
									<p href="#" v-on:click="imagesData.splice(index, 1); files.splice(index, 1)">X</p>
								</div>
							</div>
						</div>
						
						<hr>
						<label class="control-label">Документы</label>

						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>Имя файла</th>
									<th width="100">&nbsp;</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="file, index in files">
									<td v-if="file.type != 'image/jpeg'">{{ file.name }} </td>
									<td v-if="file.type != 'image/jpeg'"><p v-on:click="files.splice(index, 1)">Убрать</p></td>
								</tr>
							</tbody>
						</table>
					</div>					

					<hr>
					
					<a name="tabs"><b>Владелец</b></a>
					<ul class="nav nav-tabs">
						<li @click="currentTab='company'; searchCompanies()" class="nav-item">
							<a href="#tabs" class="nav-link" v-bind:class="{active: currentTab == 'company'}">
								Компания
							</a>
						</li>
						<li @click="currentTab='department'; searchCompanies()" class="nav-item">
							<a href="#tabs" class="nav-link" v-bind:class="{active: currentTab == 'department'}">
								Подразделение компании
							</a>
						</li>
						<li @click="currentTab='person'; searchPersons()" class="nav-item">
							<a href="#tabs" class="nav-link" v-bind:class="{active: currentTab == 'person'}">
								Частное лицо
							</a>
						</li>
					</ul>
					
					<div class="tab-content">
						<div class="col-xs-12 form-group" v-if="currentTab=='company'">
							<select v-model="equipment.company" class="form-control" size="4" v-on:change="resetDepartment(); resetPersons(); changePost = true">
								<option v-bind:value="company.id" v-for="company in companies" v-bind:key="company.id">{{ company.name }}</option>								
							</select>
							<input type="button" class="btn btn-success" v-on:click="resetCompanies()" value="Сбросить">
						</div>
						
						<div class="col-xs-12 form-group" v-if="currentTab=='department'">
							<select v-model="companyIDforSearch" class="form-control" size="4" v-on:change="searchDepartments()">
								<option v-bind:value="company.id" v-for="company in companies" v-bind:key="company.id">{{ company.name }}</option>								
							</select>
						
							<hr>
							<select v-model="equipment.department" class="form-control" size="4" v-on:change="resetCompany(); resetPersons(); changePost = true">
								<option v-bind:value="department.id" v-for="department in foundDepartments" v-bind:key="department.id">{{ department.name }}</option>
							</select>
							<input type="button" class="btn btn-success" v-on:click="resetDepartments()" value="Сбросить">
						</div>
						
						<div class="col-xs-12 form-group" v-if="currentTab=='person'">
							<select v-model="equipment.person" class="form-control" size="4" v-on:change="resetDepartment(); resetCompany(); changePost = true">
								<option v-bind:value="person.id" v-for="person in persons" v-bind:key="person.id">{{person.name}} {{person.surname}} {{person.patronymic}}</option>								
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
				equipmentID: null,
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
					company: null, //ID компании которые нужно присоединить к данному оборудованию
					department: null, //ID подразделения которые нужно присоединить к данному оборудованию
					person: null, //ID человека которые нужно присоединить к данному оборудованию
					files: [], //список файлов на сервере- при удалении их ID добавляются в filesDeleteID
					owner_type: null,
					owner: null
				},
				
				errors: {
					name: null
				},
				
				companies: [], // сюда загружаются компании при выборе вкладки Компании или Подразделения
				companyIDforSearch: null, //ID выбранной компании из списка
				foundDepartments: [], //сюда загружается список подразделений выбранной компании
				persons: [], // сюда загружаются люди при выборе вкладки Частное лицо

				imagesData: [], //пути на диске клиента к файлам, которые нужно загрузить на сервер
				files: [], //файлы, которые нужно загрузить на сервер
				filesDeleteID: [], //ID файлов которые нужно удалить
				
				currentTab: null,
				changePost: false
			}
		},
		mounted() {
			let app = this;
			let id = app.$route.params.id;
			app.equipmentID = id;
			axios.get('/api/v1/equipments/' + id + '/edit')
				.then(function (resp) {
					app.equipment = resp.data.equipment;

					console.log(app.equipment);
					console.log('Owner ' + app.equipment.owner_type);
					let owner = app.equipment.owner_type;
					console.log(owner);
					
					if(owner == "App\\Company") {
						
						app.searchCompanies();
						app.equipment.company = app.equipment.owner_id;
						app.equipment.department = null;
						app.equipment.person = null;
						
					};
					if(owner == "App\\Department") {
						
						app.searchCompanies();
						app.companyIDforSearch = app.equipment.owner.company.id; //было передано из контроллера - инфо о владелеце целиком
						app.searchDepartments();
						app.equipment.company = null;
						app.equipment.department = app.equipment.owner_id;
						app.equipment.person = null;
						
					};
					if(owner == "App\\Person") {
						
						app.searchPersons();
						app.equipment.person = app.equipment.owner_id;
						app.equipment.company = null;
						app.equipment.department = null;
						
					};
					
					console.log('Company ' + app.equipment.company);
					console.log('Department ' + app.equipment.department);
					console.log('Person ' + app.equipment.person);
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
				
				if(app.equipment.company) formData.append('company', app.equipment.company);
				if(app.equipment.department) formData.append('department', app.equipment.department);
				if(app.equipment.person) formData.append('person', app.equipment.person);
				
				app.files.forEach(function (file, i) {                    
					formData.append('Attachment[' + i + ']', file); //прямо вот так по одному и втаскиваем в формДата - в контроллере понимает эти записи за один массив
				});
				
				if(app.filesDeleteID) formData.append('delfiles', app.filesDeleteID);
				
				formData.append('_method', 'PATCH');
				
				axios.post('/api/v1/equipments/' + app.equipmentID, formData, {
						headers: {'Content-Type': 'multipart/form-data'}
					})
					.then(function (resp) {
						app.$router.push({path: '/admin/equipments/index'});
					})
					.catch(function (resp) {
						console.log(resp);
						if(JSON.parse(resp.request.responseText).message == 'The given data was invalid.') app.errors = JSON.parse(resp.request.responseText).errors; else alert("Ошибка на сервере");
					});				
				
			},
			resetCompany() {
				var app = this;
				app.equipment.company = null;
			},
			resetDepartment() {
				var app = this;
				app.equipment.department = null;
			},
			resetPersons() {
				var app = this;
				app.equipment.person = null;
			},			
			onAttachmentChange (e) {
				var app = this;
				
				var arrfiles = [];
				for(var i = 0; i < e.target.files.length; i++) {
					arrfiles[i] = e.target.files[i];
					if(arrfiles[i].type == 'image/jpeg') {
						var reader = new FileReader();
						reader.onload = (e) => {
							app.imagesData.push(e.target.result);
						}
						reader.readAsDataURL(e.target.files[i]);
					}
				}
				
				app.files = app.files.concat(arrfiles);
				console.log(app.files);
			},
			searchDepartments() {
				var app = this;
				console.log(app.companyIDforSearch);
				const formData = new FormData();
				var companyID = app.companyIDforSearch;
				axios.get('/api/v1/search/departments/' + companyID)
					.then(function (resp) {
						app.foundDepartments = resp.data.departments;
						console.log(app.foundDepartments);
					})
					.catch(function (resp) {
						alert("Не удалось загрузить данные");
					});		
			},
			searchCompanies() {
				var app = this;
				axios.get('/api/v1/search/companies')
					.then(function (resp) {
						app.companies = resp.data.companies;
						console.log(app.companies);
					})
					.catch(function (resp) {
						alert("Не удалось загрузить данные");
					});				
			},
			searchPersons() {
				var app = this;
				axios.get('/api/v1/search/persons')
					.then(function (resp) {
						app.persons = resp.data.persons;
						console.log(app.persons);
					})
					.catch(function (resp) {
						alert("Не удалось загрузить данные");
					});				
			}			
		}
	}
</script>