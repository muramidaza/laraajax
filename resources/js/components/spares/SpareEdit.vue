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

					<div v-if="spare.equipment">
						<div class="col-xs-12">
							<h3>Оборудование</h3>
							<div>
								Производитель: {{ spare.equipment.manufacturer }} <br>
								Номенклатура: {{ spare.equipment.type }} {{ spare.equipment.model }} {{ spare.equipment.modification }} <br>
								Серийный номер: {{ spare.equipment.sernumber }} <br>
								Дата изготовления: {{ spare.equipment.datemanuf }}
							</div>
						</div>
				
						<h3>Владелец</h3>
						<div class="col-xs-12" v-if="spare.equipment.owner_type == 'App\\Company'">
							<div v-if="spare.equipment.owner">Компания: {{ spare.equipment.owner.name }}</div>
						</div>
						<div class="col-xs-12" v-if="spare.equipment.owner_type == 'App\\Department'">
							<div v-if="spare.equipment.owner">Компания: {{ spare.equipment.owner.company.name }}<br>
							Подразделение: {{ spare.equipment.owner.name }}</div>
						</div>
						<div class="col-xs-12" v-if="spare.equipment.owner_type == 'App\\Person'">
							<div v-if="spare.equipment.owner">Частное лицо: {{ spare.equipment.owner.name }} {{ spare.equipment.owner.surname }} {{ spare.equipment.owner.patronymic }}</div>
						</div>
					</div>
					
					<hr>
						
					<div class="col-xs-12 form-group">
						<label class="control-label">Тип</label>
						<input type="text" v-model="spare.type" class="form-control" required>
						<ul v-if="errors.type" class="alert-danger">
							<li v-for="error in errors.type">{{error}}</li>
						</ul>	
					</div>

					<div class="col-xs-12 form-group">
						<label class="control-label">Название</label>
						<input type="text" v-model="spare.name" class="form-control">
					</div>

					<div class="col-xs-12 form-group">
						<label class="control-label">Модель</label>
						<input type="text" v-model="spare.model" class="form-control">
					</div>
					
					<div class="col-xs-12 form-group">
						<label class="control-label">Параметр</label>
						<input type="text" v-model="spare.parameter" class="form-control">
					</div>

					<div class="col-xs-12 form-group">
						<label class="control-label">Количество</label>
						<input type="number" min="1" v-model="spare.qty" class="form-control">
					</div>

					<div class="col-xs-12 form-group">
						<label class="control-label">Единица измерения</label>
						<select v-model="spare.unit">
							<option>шт</option>
							<option>кг</option>
							<option>г</option>
							<option>л</option>
							<option>мл</option>
							<option>м</option>
							<option>см</option>
							<option>мм</option>
						</select>
					</div>					

					<div class="col-xs-12 form-group">
						<label class="control-label">Примечание</label>
						<input type="text" v-model="spare.note" class="form-control">
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
				spareID: null,
				spare: {
					type: '',
					name: '',
					model: '',
					parameter: '',
					qty: 1,
					unit: 'шт',
					note: '',
					equipment: null
				},
				errors: {
					name: null
				},
				action: 'edit'
			}
		},
		mounted() {
			let app = this;
			let id = app.$route.params.id;
			app.spareID = id;
			app.action = app.$route.params.action;
			axios.get('/api/v1/spares/' + id + '/edit')
				.then(function (resp) {
					app.spare = resp.data.spare;
				})
			 .catch(function () {
				 alert("Не удалось загрузить данные")
			  });
		},
		methods: {
			saveForm() {
				event.preventDefault();
				var app = this;
				
				const formData = new FormData();
				formData.append('type', app.spare.type);
				formData.append('name', app.spare.name);
				if(app.spare.model) formData.append('model', app.spare.model);
				if(app.spare.parameter) formData.append('parameter', app.spare.parameter);
				if(app.spare.qty) formData.append('qty', app.spare.qty);
				formData.append('unit', app.spare.unit);
				if(app.spare.note) formData.append('note', app.spare.note);
				
				formData.append('_method', 'PATCH');
				
				axios.post('/api/v1/spares/' + app.spareID, formData, {
						headers: {'Content-Type': 'multipart/form-data'}
					})
					.then(function (resp) {
						app.$router.push({path: '/admin/spares/index'});
					})
					.catch(function (resp) {
						console.log(resp);
						if(JSON.parse(resp.request.responseText).message == 'The given data was invalid.') app.errors = JSON.parse(resp.request.responseText).errors; else alert("Ошибка на сервере");
					});				
				
			},
		}
	}
</script>