<template>
	<div>
		<div class="form-group">
			<div @click="$router.go(-1)" class="btn btn-success">Назад</div>
		</div>
		
		<div class="card">
			<div class="card-header">
				Редактирование записи
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
						<select v-model="act.caller_id" class="form-control" size="4">
							<option v-bind:value="person.id" v-for="person in persons" v-bind:key="person.id">{{person.name}} {{person.surname}} {{person.patronymic}}</option>								
						</select>
						<input type="button" class="btn btn-success" v-on:click="act.caller = null" value="Сбросить">
						<div class="col-xs-12 form-group" v-if="!act.caller">
							<label class="control-label">Если нет в списке</label>
							<input type="text" v-model="act.fio" class="form-control">
						</div>							
					</div>
					
					<hr>
					
					<h3>Статус</h3>
					
					<br>
					
					<div class="col-xs-12 form-group">
						<div>
							<label class="control-label" v-if="act.act_status">Заявка закрыта</label>
							<label class="control-label" v-if="!act.act_status">Заявка не закрыта</label>
						</div>
					</div>
					
					<div class="col-xs-12 form-group">
						<div>
							<label class="control-label" v-if="act.make_diagnos">Диагностика проведена</label>
							<label class="control-label" v-if="!act.make_diagnos">Диагностика не проведена</label>
						</div>
					</div>

					<div class="col-xs-12 form-group">
						<div>
							<label class="control-label" v-if="act.need_spares">Нужны запчасти</label>
							<label class="control-label" v-if="!act.need_spares">Запчасти не нужны</label>
						</div>
					</div>

					<div class="col-xs-12 form-group">
						<div>
							<label class="control-label" v-if="act.mistake">Ложный вызов</label>
						</div>
					</div>
					
					<div class="col-xs-12 form-group">
						<label class="control-label" v-if="act.delivery">Была ли доставка в сервис-центр</label>
						<label class="control-label" v-if="!act.delivery">Ремонт выполнен на месте</label>
					</div>
					
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
						<h3>Кто принял заявку</h3>
						<select v-model="act.user_act_accept" class="form-control" size="4">
							<option v-bind:value="user.id" v-for="user in users" v-bind:key="user.id">{{ user.name }} {{ user.surname }} {{ user.patronymic }}</option>					
						</select>
						<input type="button" class="btn btn-success" v-on:click="act.user_act_accept = []" value="Сбросить">
					</div>
					
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
						<label class="control-label">Описание проблемы</label><br>
						<p v-model="act.problem"></p>
					</div>
					
					<div class="col-xs-12 form-group">
						<label class="control-label">Результаты диагностики</label><br>
						<p v-model="act.diagnos"></p>
					</div>					
					
					<div class="col-xs-12 form-group">
						<label class="control-label">План работ</label><br>
						<p v-model="act.plan"></p>
					</div>
					
					<div class="col-xs-12 form-group">
						<label class="control-label">Выполненные работы</label><br>
						<p v-model="act.work"></p>
					</div>					

					<hr>
					
					<div class="col-xs-12 form-group" v-if="act.files.length>0">
						<label class="control-label">Загруженные файлы</label>
													
						<div class="container">
							<h5>Фотографии</h5>
							<div class="row">
								<template v-for="(image, index) in act.files">
									<template v-if="image['typeFile'] == 'image/jpeg'">
										<div class="col-md-4 border" >
											<img v-bind:src="image['pathFile']" class="img-thumbnail">
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