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

					<div class="col-xs-12 form-group" v-if="equipment.person && !equipment.company && !equipment.department">
						<div class="control-label"><b>Принадлежит частному лицу</b></div>
						<ul v-for="person in persons" class="list-group">
							<li v-if="equipment.person == person.id" class="list-group-item">{{ person.name }} {{ person.surname }} {{ person.patronymic }}</li>
						</ul>
					</div>				
				
					<div class="col-xs-12 form-group" v-if="equipment.company && !equipment.person && !equipment.department">
						<div class="control-label"><b>Принадлежит компании</b></div>
						<ul v-for="company in companies" class="list-group">
							<li v-if="equipment.company == company.id" class="list-group-item">{{ company.name }}</li>
						</ul>
					</div>
					
					<div class="col-xs-12 form-group" v-if="equipment.department && equipment.company && !equipment.person">
						<div class="control-label"><b>Принадлежит компании</b></div>
						<ul v-for="company in companies" class="list-group">
							<li v-if="companyIDforSearch == company.id" class="list-group-item">{{ company.name }}</li>
						</ul>
						<div class="control-label"><b>Подразделение</b></div>
						<ul v-for="department in foundDepartments" class="list-group">
							<li v-if="equipment.department == department.id" class="list-group-item">{{ department.name }}</li>
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
				
					<div v-if="!redirect">
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
					company: null,
					department: null,
					person: null
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
				
				currentTab: null,
				changePost: false,
				
				redirect: false
			}
		},
		mounted() {
			let app = this;
			console.log('Mounted');
			console.log('Params: ' + app.$route.params.companyId);
			console.log('Params: ' + app.$route.params.departmentId);
			
			if(app.$route.params.personId && !app.$route.params.companyId && !app.$route.params.departmentId) {
				app.redirect = true;
				
				app.equipment.person = app.$route.params.personId;
				
				app.searchPersons();
				
				console.log('person ' + app.equipment.person);
			};			

			if(app.$route.params.companyId && !app.$route.params.departmentId && !app.$route.params.personId) {
				app.redirect = true;
				
				app.equipment.company = app.$route.params.companyId;
				
				app.searchCompanies();
				
				console.log('company ' + app.equipment.company);
			};
			
			if(app.$route.params.departmentId && app.$route.params.companyId && !app.$route.params.personId ) {
				app.redirect = true;
				
				app.companyIDforSearch = app.$route.params.companyId;
				
				app.equipment.company = app.$route.params.companyId;
				app.equipment.department = app.$route.params.departmentId
				
				app.searchCompanies();
				app.searchDepartments();
				
				console.log('company ' + app.companyIDforSearch);
				console.log('department ' + app.equipment.department);
			}			
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
				
				axios.post('/api/v1/equipments', formData, {
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
						console.log(app.foundDepartments);
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
						console.log(app.companies);
					})
					.catch(function (resp) {
						alert("Не удалось загрузить данные");
					});				
			},
			searchPersons() {
				var app = this;
				axios.get('/api/v1/search/persons/')
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