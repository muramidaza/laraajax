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
					<div class="col-xs-12">
						<h3>Оборудование</h3>
						<div v-if="equipment">
							Производитель: {{ equipment.manufacturer }} <br>
							Номенклатура: {{ equipment.type }} {{ equipment.model }} {{ equipment.modification }}<br>
							Серийный номер: {{ equipment.sernumber }}<br>
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
						<div v-if="equipment">
							Город: {{ equipment.onwer.city }} <br>
							Адрес: {{ equipment.onwer.address }}<br>
						</div>
					</div>					

					<div class="col-xs-12" v-if="equipment.owner_type == 'App\\Person'">
						<h3>Адрес вызова</h3>
						<div v-if="equipment">
							Город: {{ equipment.onwer.address }} <br>
							Телефон 1: {{ equipment.onwer.phone1 }}<br>
							Телефон 2: {{ equipment.onwer.phone2 }}<br>
							E-mail: {{ equipment.onwer.email }}<br>
						</div>
					</div>
					
					<hr>

					<div class="col-xs-12 form-group">
						<label class="control-label">Статус</label>
						<div>
							<div class="form-check"><input type="radio" value="0" v-model="act.actstatus"><label>Только что открыта</label></div>
							<div class="form-check"><input type="radio" value="1" v-model="act.actstatus"><label>Проведена диагностика, нужны детали</label></div>
							<div class="form-check"><input type="radio" value="2" v-model="act.actstatus"><label>Проведена диагностика, не успели закончить</label></div>
							<div class="form-check"><input type="radio" value="3" v-model="act.actstatus"><label>Проведена диагностика, проблема не выяснена</label></div>
							<div class="form-check"><input type="radio" value="4" v-model="act.actstatus"><label>Все сделали, заявка закрыта</label></div>
							<div class="form-check"><input type="radio" value="5" v-model="act.actstatus"><label>Ложный вызов, заявка закрыта</label></div>
						</div>
					</div>

					<div class="col-xs-12 form-group">
						<label class="control-label">Расстояние до объекта</label>
						<div>
							<div class="form-check"><input type="radio" value="0" v-model="act.distance"><label>Сами привезли</label></div>
							<div class="form-check"><input type="radio" value="1" v-model="act.distance"><label>В своем же городе</label></div>
							<div class="form-check"><input type="radio" value="2" v-model="act.distance"><label>В городе рядом, до 100 км</label></div>
							<div class="form-check"><input type="radio" value="3" v-model="act.distance"><label>Очень далеко</label></div>
						</div>
					</div>
					
					<div class="col-xs-12 form-group">
						<label class="control-label">Была ли доставка в сервис-центр</label>
						<input type="checkbox" id="executive" v-model="act.delivery">
					</div>					
					
					<hr>
					
					<div class="col-xs-12 form-group">
						<label class="control-label">Описание проблемы</label><br>
						<textarea v-model="act.problem"></textarea>
					</div>
					
					<div class="col-xs-12 form-group">
						<label class="control-label">Результаты диагностики</label><br>
						<textarea v-model="act.problem"></textarea>
					</div>					
					
					<div class="col-xs-12 form-group">
						<label class="control-label">План работ</label><br>
						<textarea v-model="act.plan"></textarea>
					</div>
					
					<div class="col-xs-12 form-group">
						<label class="control-label">Выполненные работы</label><br>
						<textarea v-model="act.work"></textarea>
					</div>					
					
					<hr>
					
					<div class="col-xs-12 form-group" v-if="equipment.owner_type != 'App\\Person'">
						<h3>Представитель заказчика, кто сделал вызов</h3>
						<select v-model="act.caller_id" class="form-control" size="4">
							<option v-bind:value="person.id" v-for="person in persons" v-bind:key="person.id">{{person.name}} {{person.surname}} {{person.patronymic}}</option>								
						</select>
						<input type="button" class="btn btn-success" v-on:click="act.person_id = null" value="Сбросить">
						<div class="col-xs-12 form-group">
							<label class="control-label">Если нет в списке</label>
							<input type="text" v-model="act.fio" class="form-control">
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
				equipment_id: null,
				act: {
					caller_id: null,
					//dispatcher_id: null,
					users_acts_close: [],
					users_acts_diagnos: [],
					
					actstatus: 0,
					distance: 0,
					delivery: 0,
					
					problem: '',
					diagnos: '',
					plan: '',
					work: '',
					
					fio: ''
				},
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
					person: null,
					files: [], //список файлов на сервере - при удалении их ID добавляются в filesDeleteID
					owner_type: null,
					owner: null
				},
				
				errors: {
					name: null
				},
				
				persons: [], // сюда загружаются люди при выборе вкладки Частное лицо
				
				imagesData: [], //пути на диске клиента к файлам, которые нужно загрузить на сервер
				files: [], //файлы, которые нужно загрузить на сервер
				
				action: null,
				
				redirect: false
			}
		},
		mounted() {
			let app = this;
			console.log('Mounted');
			console.log('Params: ' + app.$route.params.id);
			console.log('Params: ' + app.$route.params.action);
			
			app.equipment_id = app.$route.params.id;
			app.act.action = app.$route.params.action;
			
			if(app.act.action) {
				app.redirect = true;
				axios.get('/api/v1/equipments/' + app.equipment_id)
					.then(function (resp) {
						app.equipment = resp.data.equipment;
						app.extendSearchPersons();
					})
					.catch(function () {
						alert("Не удалось загрузить данные")
					});
			}
			
			
		},
		methods: {
			saveForm() {
				event.preventDefault();
				var app = this;
				console.log('save');
				
				const formData = new FormData();
				
				formData.append('actstatus', app.act.actstatus);
				formData.append('distance', app.act.distance);
				formData.append('delivery', +app.act.delivery);
				
				if(app.act.problem) formData.append('problem', app.act.problem);
				if(app.act.diagnos) formData.append('diagnos', app.act.diagnos);
				if(app.act.plan) formData.append('plan', app.act.plan);
				if(app.act.work) formData.append('work', app.act.work);
				
				if(app.equipment.owner.city) formData.append('city', app.equipment.owner.city);
				if(app.equipment.owner.address) formData.append('address', app.equipment.owner.address);
				if(app.equipment.owner.phone1) formData.append('city', app.equipment.owner.phone1);
				if(app.equipment.owner.phone2) formData.append('address', app.equipment.owner.phone2);				
				
				if(app.equipment.owner_type == 'App\\Company') formData.append('company', app.equipment.owner.name);
				if(app.equipment.owner_type == 'App\\Department') formData.append('department', app.equipment.owner.name);
				if(app.equipment.owner_type == 'App\\Department') formData.append('company', app.equipment.owner.company.name);
				if(app.equipment.owner_type == 'App\\Person') formData.append('owner_fio', app.equipment.owner.name);
				
				formData.append('equipment_id', app.equipment_id);
				if(app.act.caller_id) formData.append('caller_id', app.act.caller_id);
				//if(app.act.dispatcher_id) formData.append('dispatcher_id', app.act.dispatcher_id);
				if(app.act.users_acts_diagnos) formData.append('users_acts_diagnos', app.act.users_acts_diagnos);	
				if(app.act.users_acts_close) formData.append('users_acts_close', app.act.users_acts_close);	
				
				app.files.forEach(function (file, i) {                    
					formData.append('Attachment[' + i + ']', file); //прямо вот так по одному и втаскиваем в формДата - в контроллере понимает эти записи за один массив
				});
				
				axios.post('/api/v1/act', formData, {
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
			}			
		}
	}
</script>