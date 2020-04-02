<template>
	<div>
		<div class="form-group">
			<div @click="$router.go(-1)" class="btn btn-success">Назад</div>
		</div>
		
		<div class="card">
			<div class="card-header">
				Просмотр записи об объекте
			</div>
			<div class="card-body" style="margin-left: 40px">
				<div>
					<div class="control-label"><b>Принадлежит компании</b></div>
					<div class="col-xs-12 form-group">
						<div class="form-control" v-if="department.company">Компания: {{ department.company.name }}</div>
					</div>				

					<div class="col-xs-12 form-group">
						<label class="control-label">Название объекта</label>
						<div class="form-control">{{ department.name }}</div>							
					</div>

					<div class="col-xs-12 form-group" v-if="department.address">
						<label class="control-label">Адрес объекта</label>
						<div class="form-control">{{ department.address }}</div>
					</div>
					
					<div class="col-xs-12 form-group" v-if="department.manager">
						<label class="control-label">ФИО менеджера</label>
						<div class="form-control">{{ department.manager }}</div>
					</div>
					
					<div class="col-xs-12 form-group" v-if="department.phone1">
						<label class="control-label">Телефон 1</label>
						<div class="form-control">{{ department.phone1 }}</div>				
					</div>

					<div class="col-xs-12 form-group" v-if="department.phone2">
						<label class="control-label">Телефон 2</label>
						<div class="form-control">{{ department.phone2 }}</div>
					</div>	
					
					<div class="col-xs-12 form-group" v-if="department.company">
						<label class="control-label">Контрагент</label>
						<div class="form-control">{{ department.company.name }}</div>
					</div>
				</div>
			</div>
			
			<div class="card-footer">
				<router-link :to="{name: 'editDepartment', params: {id: department.id}}" class="btn btn-xs btn-warning">Изменить</router-link>
				<a href="#" class="btn btn-xs btn-danger" v-on:click="deleteEntry(department.id, index)">Удалить</a>
			</div>
			
		</div>
		
		<div class="card" v-if="department.persons">
			<div class="card-header">
				Перечень персонала
			</div>
			<div class="card-body">
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>ФИО</th>
							<th>Должность</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="person, index in department.persons" class="nav-item">
							<td><router-link :to="{name: 'showPerson', params: {id: person.id}}" class="nav-link">{{ person.name }} <br> {{ person.surname }} <br> {{ person.patronymic }}</router-link></td>
							<td>{{ person.post }}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>		
		
		<div class="card" v-if="department.equipments">
			<div class="card-header">
				Перечень оборудования
			</div>
			<div class="card-body">
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>Наименование</th>
							<th>Серийный №</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="equipment, index in department.equipments" class="nav-item">
							<td><router-link :to="{name: 'showEquipment', params: {id: equipment.id}}" class="nav-link">{{ equipment.type }} <br> {{ equipment.manufacturer }} <br> {{ equipment.model }}</router-link></td>
							<td>{{ equipment.sernumber }}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		
		<div class="card">
			<div class="card-header">
				Добавить новую запись
			</div>
			<div class="card-body">
				<router-link :to="{name: 'createEquipment', params: {departmentId: departmentId}}" class="btn btn-success">Об оборудование</router-link>
				<router-link :to="{name: 'createPerson', params: {departmentId: departmentId}}" class="btn btn-success">О сотруднике</router-link>
			</div>
		</div>
		
	</div>
</template>

<script>
	export default {
		mounted() {
			let app = this;
			let id = app.$route.params.id;
			app.departmentId = id;
			axios.get('/api/v1/departments/' + id)
				.then(function (resp) {
					app.department = resp.data.department;
				})
				.catch(function () {
					alert("Не удалось загрузить отделы")
				});
		},
		data: function () {
			return {
				departmentId: null,
				department: {
					name: '',
					address: '',
					manager: '',
					phone1: '',
					phone2: '',
					company: null,
					persons: null,
					equipments: null
				},
				errors: {
					name: null,
					manager: null,
					phone1: null
				}
			}
		},
		methods: {
			saveForm() {
				event.preventDefault();
				var app = this;
				var newDepartment = app.department;
				axios.get('/api/v1/departments/' + app.departmentId, newDepartment)
					.then(function (resp) {
						app.$router.push({path: '/admin/departments/index'});
					})
					.catch(function (resp) {
						if(JSON.parse(resp.request.responseText).message == 'The given data was invalid.') app.errors = JSON.parse(resp.request.responseText).errors;						
					});
			}
		}
	}
</script>