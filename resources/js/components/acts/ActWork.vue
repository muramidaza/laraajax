<template>
	<div>
		<div class="form-group">
			<div @click="$router.go(-1)" class="btn btn-success">Назад</div>
		</div>
		
		<div class="card">
			<div class="card-header">
				Ввод результатов диагностики и ремонта
			</div>
			
			<div class="card-body">
				<form v-on:submit="saveForm()">
					<div class="col-xs-12">
						<h3>Оборудование</h3>
						<div v-if="equipment">
							Производитель: {{ equipment.manufacturer }} <br>
							Номенклатура: {{ equipment.type }} {{ equipment.model }} {{ equipment.modification }} <br>
							Серийный номер: {{ equipment.sernumber }} <br>
							Дата изготовления: {{ equipment.datemanuf }}
						</div>
					</div>

					<div class="col-xs-12 form-group">
						<h3>Владелец</h3>
						<div class="col-xs-12" v-if="equipment.owner_type == 'App\\Company'">
							<div v-if="equipment.owner">Компания: {{ equipment.owner.name }}</div>
						</div>
						<div class="col-xs-12" v-if="equipment.owner_type == 'App\\Department'">
							<div v-if="equipment.owner">Компания: {{ equipment.owner.company.name }}<br>
							Подразделение: {{ equipment.owner.name }}</div>
						</div>
						<div class="col-xs-12" v-if="equipment.owner_type == 'App\\Person'">
							<div v-if="equipment.owner">Частное лицо: {{ equipment.owner.name }} {{ equipment.owner.surname }} {{ equipment.owner.patronymic }}</div>
						</div>
					</div>

					<div class="col-xs-12" v-if="(act.distance > 0) && (equipment.owner_type != 'App\\Person')">
						<h3>Адрес вызова</h3>
						<div v-if="equipment.owner">
							Город: {{ equipment.owner.city }} <br>
							Адрес: {{ equipment.owner.address }}<br>
						</div>
					</div>					

					<div class="col-xs-12" v-if="equipment.owner_type == 'App\\Person'">
						<h3>Адрес вызова</h3>
						<div v-if="equipment.owner">
							Город: {{ equipment.owner.address }} <br>
							Телефон 1: {{ equipment.owner.phone1 }}<br>
							Телефон 2: {{ equipment.owner.phone2 }}<br>
							E-mail: {{ equipment.owner.email }}<br>
						</div>
					</div>
					
					<hr>

					<div class="col-xs-12 form-group" v-if="equipment.owner_type != 'App\\Person'">
						<h3>Представитель заказчика, кто сделал вызов</h3>
						<ul v-for="person in persons" >
							<li v-if="act.caller_id == person.id">{{ person.name }} {{ person.surname }} {{ person.patronymic }}</li>
						</ul>							
					</div>
					
					<hr>

					<div class="col-xs-12 form-group">
						<h3>Кто принял заявку</h3>
						<ul v-for="user in users" >
							<li v-if="act.user_act_accept == user.id">{{ user.name }} {{ user.surname }} {{ user.patronymic }}</li>
						</ul>
					</div>					
					
					<hr>

					<div class="col-xs-12 form-group">
						<label class="control-label">Расстояние до объекта</label>
						<div>
							<label class="control-label" v-if="act.distance == 0">Сами привезли</label>
							<label class="control-label" v-if="act.distance == 1">В своем же городе</label>
							<label class="control-label" v-if="act.distance == 2">В городе рядом, до 100 км</label>
							<label class="control-label" v-if="act.distance == 3">Очень далеко</label>
						</div>
					</div>

					<hr>
					
					<div class="col-xs-12 form-group">
						<label class="control-label">Описание проблемы</label><br>
						<p v-model="act.problem"></p>
					</div>					
					
					<hr>
					
					<h3>Статус</h3>
					
					<br>

					<div class="col-xs-12 form-group">
						<div>
							<label class="control-label">Заявка закрыта</label>
							<input type="checkbox" v-model="act.act_status">
						</div>
					</div>
					
					<div class="col-xs-12 form-group">
						<div>
							<label class="control-label">Ложный вызов</label>
							<input type="checkbox" v-model="act.mistake">
						</div>
					</div>	
					
					<div class="col-xs-12 form-group">
						<div>
							<label class="control-label">Диагностика проведена</label>
							<input type="checkbox" v-model="act.make_diagnos">
						</div>
					</div>

					<div class="col-xs-12 form-group">
						<div>
							<label class="control-label">Нужны запчасти</label>
							<input type="checkbox" v-model="act.need_spares">
						</div>
					</div>
					
					<div class="col-xs-12 form-group">
						<label class="control-label">Была ли доставка в сервис-центр</label>
						<input type="checkbox" v-model="act.delivery">
					</div>					
					
					<hr>
					
					<div class="col-xs-12 form-group">
						<h3>Кто делал диагностику</h3>
						<select v-model="act.users_act_diagnos" class="form-control" size="4" multiple>
							<option v-bind:value="user.id" v-for="user in users" v-bind:key="user.id">{{ user.name }} {{ user.surname }} {{ user.patronymic }}</option>							
						</select>
						<input type="button" class="btn btn-success" v-on:click="act.users_acts_diagnos = []" value="Сбросить">
					</div>
					
					
					<div class="col-xs-12 form-group">
						<h3>Кто делал ремонт</h3>
						<select v-model="act.users_act_close" class="form-control" size="4" multiple>
							<option v-bind:value="user.id" v-for="user in users" v-bind:key="user.id">{{ user.name }} {{ user.surname }} {{ user.patronymic }}</option>							
						</select>
						<input type="button" class="btn btn-success" v-on:click="act.users_acts_close = []" value="Сбросить">
					</div>					

					<hr>
					
					<div class="col-xs-12 form-group">
						<label class="control-label">Результаты диагностики</label><br>
						<textarea v-model="act.diagnos"></textarea>
					</div>					
					
					<div class="col-xs-12 form-group">
						<label class="control-label">План работ</label><br>
						<textarea v-model="act.plan"></textarea>
					</div>
								
					<div class="col-xs-12 form-group">
						<label class="control-label">Выполненные работы</label><br>
						<textarea v-model="act.work"></textarea>
					</div>

					<div class="col-xs-12 form-group">
						<label class="control-label">Примечания</label><br>
						<textarea v-model="act.note"></textarea>
					</div>					

					<hr>
					
					<div class="col-xs-12 form-group" v-if="act.files.length>0">
						<label class="control-label">Уже загруженные файлы</label>
													
						<div class="container">
							<h5>Фотографии</h5>
							<div class="row">
								<template v-for="(image, index) in act.files">
									<template v-if="image['typeFile'] == 'image/jpeg'">
										<div class="col-md-4 border" >
											<img v-bind:src="image['pathFile']" class="img-thumbnail" >
											<p v-on:click="act.files.splice(index, 1); filesDeleteID.push(image['id'])">X</p>
										</div>
									</template>
								</template>
							</div>
						</div>
						
						<div class="container">
							<h5>Документы</h5>
														
							<div class="row">
								<ul class="list-group" v-for="(file, index) in act.files">
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
						
					<div class="card">
						<div class="card-header">
							<p>Запчасти</p>
						</div>
						<div class="card-body">
							<div v-for="spare, index in act.spares" class="card">
								<div class="card-header">
									<div class="nav-link">{{ spare.type }} {{ spare.name }}</div>
								</div>
								<div class="card-body">
									<template v-if="spare.model">Модель {{ spare.model }} <br></template>
									<template v-if="spare.parameter">Параметр {{ spare.parameter }} <br></template>
									<template v-if="spare.qty">Количество {{ spare.qty }} {{ spare.unit }}<br></template>
									<template v-if="spare.note">Примечание {{ spare.note }} <br></template>							
								</div>
								<div class="card-footer">
									<div v-if="oldspare.ordered && oldspare.instock" v-on:click="act.spares.splice(index, 1); sparesInstallID.push(oldspares['id'])" class="btn btn-success">Установлена</div>
								</div>					
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
				act_id: null,
				act: {
					equipment_id: null,
					caller_id: null,
					caller_fio: '',
					user_act_accept: null,
					users_act_close: [],
					users_act_diagnos: [],
					
					act_status: 0,
					make_diagnos: 0,
					need_spares: 0,
					mistake: 0,
					distance: 0,
					delivery: 0,
					
					problem: '',
					diagnos: '',
					plan: '',
					work: '',
					note: '',
					
					files: []
				},
				equipment: {
					id: null,
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
					person: null,
					files: [], //список файлов на сервере - при удалении их ID добавляются в filesDeleteID
					owner_type: null,
					owner: null
				},
				
				errors: {
					name: null
				},
				
				persons: [], // сюда загружаются люди при выборе вкладки Частное лицо
				users: [],
				
				imagesData: [], //пути на диске клиента к файлам, которые нужно загрузить на сервер
				files: [], //файлы, которые нужно загрузить на сервер
				filesDeleteID: [], //ID файлов которые нужно удалить
				
				action: null,
				
				redirect: false
			}
		},
		mounted() {
			function dataToArrID(data) {
				let arr = [];
				data.forEach(function(elem) {arr.push(elem.id)});
				return arr;
			}

			let app = this;
			console.log('Mounted');
			console.log('Params: ' + app.$route.params.id);
			console.log('Params: ' + app.$route.params.action);
					
			app.act_id = app.$route.params.id;
			app.action = app.$route.params.action;
			console.log(app.action);
			
			app.redirect = true;
			axios.get('/api/v1/acts/' + app.act_id + '/edit')
				.then(function (resp) {
					let preact = resp.data.act;
					preact.users_act_diagnos = dataToArrID(preact.users_act_diagnos);
					preact.users_act_close = dataToArrID(preact.users_act_close);
					app.act = preact;
					console.log(app.act);
					
					if(app.act.equipment_id !== null) {
						axios.get('/api/v1/equipments/' + app.act.equipment_id)
							.then(function (resp) {
								app.equipment = resp.data.equipment;
								app.extendSearchPersons();
								
							})
							.catch(function () {
								alert("Не удалось загрузить данные")
							});
					}					
					
				})
				.catch(function () {
					alert("Не удалось загрузить данные")
				});
			
			app.getUsers();
		},
		methods: {
			saveForm() {
				event.preventDefault();
				var app = this;
				console.log('save');
				
				const formData = new FormData();
				
				//formData.append('equipment_id', app.act.equipment_id);
				
				formData.append('act_status', +app.act.act_status);
				formData.append('make_diagnos', +app.act.make_diagnos);
				formData.append('need_spares', +app.act.need_spares
				);
				formData.append('mistake', +app.act.mistake);
				//formData.append('distance', +app.act.distance);
				formData.append('delivery', +app.act.delivery);
				
				//if(app.act.problem) formData.append('problem', app.act.problem);
				if(app.act.diagnos) formData.append('diagnos', app.act.diagnos);
				if(app.act.plan) formData.append('plan', app.act.plan);
				if(app.act.work) formData.append('work', app.act.work);
				if(app.act.note) formData.append('note', app.act.note);
				
				//if(app.equipment.owner.city) formData.append('city', app.equipment.owner.city);
				//if(app.equipment.owner.address) formData.append('address', app.equipment.owner.address);
				//if(app.equipment.owner.phone1) formData.append('phone1', app.equipment.owner.phone1);
				//if(app.equipment.owner.phone2) formData.append('phone2', app.equipment.owner.phone2);				
				
				//if(app.equipment.owner_type == 'App\\Company') formData.append('company', app.equipment.owner.name);
				//if(app.equipment.owner_type == 'App\\Department') formData.append('department', app.equipment.owner.name);
				//if(app.equipment.owner_type == 'App\\Department') formData.append('company', app.equipment.owner.company.name);
				//if(app.equipment.owner_type == 'App\\Person') formData.append('owner_fio', app.equipment.owner.name);
				
				//if(app.act.caller_id) formData.append('caller_id', app.act.caller_id);
				//if(app.act.caller_fio) formData.append('caller_fio', app.act.caller_fio);
				//if(app.act.user_act_accept) formData.append('user_act_accept', app.act.user_act_accept);
				if(app.act.users_act_diagnos) formData.append('users_act_diagnos', app.act.users_act_diagnos);	
				if(app.act.users_act_close) formData.append('users_act_close', app.act.users_act_close);	
				
				if(app.sparesDeleteID) formData.append('installspares', app.sparesInstallID);

				app.files.forEach(function (file, i) {                    
					formData.append('Attachment[' + i + ']', file); //прямо вот так по одному и втаскиваем в формДата - в контроллере понимает эти записи за один массив
				});
				
				if(app.filesDeleteID) formData.append('delfiles', app.filesDeleteID);
				
				console.log(app.act);
				
				formData.append('_method', 'PATCH');
				
				axios.post('/api/v1/acts/work/' + app.act_id, formData, {
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
			extendSearchPersons() {
				var app = this;
				let owner_type = app.equipment.owner_type.slice(4).toLowerCase();
				axios.get('/api/v1/search/persons/' + owner_type + '/' + app.equipment.owner.id)
					.then(function (resp) {
						app.persons = resp.data.persons;
						console.log(app.persons);
					})
					.catch(function (resp) {
						alert("Не удалось загрузить данные");
					});
			},
			getUsers() {
				var app = this;
				axios.get('/api/v1/users')
					.then(function (resp) {
						app.users = resp.data.users;
						console.log(app.persons);
					})
					.catch(function (resp) {
						alert("Не удалось загрузить данные");
					});			
			}
		}
	}
</script>