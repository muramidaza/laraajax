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
						<label class="control-label">Город</label>
						<div class="form-control">{{ department.city }}</div>
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
					
				</div>
			</div>
			
			<div class="card-footer">
				<router-link :to="{name: 'editDepartment', params: {id: departmentId}}" class="btn btn-xs btn-warning">Изменить</router-link>
				<a href="#" class="btn btn-xs btn-danger" v-on:click="deleteEntry(departmentId, index)">Удалить</a>
			</div>
			
		</div>
		
		<div class="card" v-if="department.persons && department.persons.length > 0">
			<div class="card-header">
				Перечень персонала
			</div>
			<div class="card-body">
				<div class="card" v-for="person, index in department.persons">
					<div class="card-header">
						<td><router-link :to="{name: 'showPerson', params: {id: person.id}}" class="nav-link">{{ person.name }} {{ person.surname }} {{ person.patronymic }}</router-link></td>
					</div>
					<div class="card-body">
						<template v-if="person.post">Должность: {{ person.post }} <br></template>
						<template v-if="person.phone1">Телефон: {{ person.phone1 }} </template>
					</div>
				</div>
			</div>
		</div>		
		
		<div class="card" v-if="department.equipments && department.equipments.length > 0">
			<div class="card-header">
				Перечень оборудования
			</div>
			<div class="card-body">
				<div class="card" v-for="equipment, index in department.equipments">
					<div class="card-header">
						<router-link :to="{name: 'showEquipment', params: {id: equipment.id}}" class="nav-link">{{ equipment.type }} {{ equipment.manufacturer }} {{ equipment.model }}</router-link>
					</div>
					<div class="card-body">
						<template v-if="equipment.sernumber">Серийный номер: {{ equipment.sernumber }} <br></template>
						<template v-if="equipment.invnumber">Инвентарный номер: {{ equipment.invnumber }} </template>
					</div>
				</div>
			</div>
		</div>
		
		<div class="card">
			<div class="card-header">
				Добавить новую запись
			</div>
			<div class="card-body">
				<router-link :to="{name: 'createEquipment', params: {companyId: companyId, departmentId: departmentId}}" class="btn btn-success">Об оборудование</router-link>
				<router-link :to="{name: 'createPerson', params: {companyId: companyId, departmentId: departmentId}}" class="btn btn-success">О сотруднике</router-link>
			</div>
		</div>
		
	</div>
</template>

<script>
	export default {
		mounted() {
			let app = this;
			let id = +app.$route.params.id;
			app.departmentId = id;
			axios.get('/api/v1/departments/' + id)
				.then(function (resp) {
					app.department = resp.data.department;
					if(resp.data.department.company) app.companyId = resp.data.department.company.id;
					console.log('Owner of selected depatment: ' + app.companyId);
				})
				.catch(function () {
					alert("Не удалось загрузить отделы")
				});
		},
		data: function () {
			return {
				companyId: null,
				departmentId: null,
				department: {
					name: '',
					address: '',
					city: '',
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
			deleteEntry(id) {
				if (confirm("Вы действительно удалить хотите запись?")) {
					let app = this;
					
					axios.delete('/api/v1/departments/' + id)
						.then(function (resp) {
							router.push('indexDepartments');
						})
						.catch(function (resp) {
							alert("Не удалось удалить запись");
						});
				}
			}
		}
	}
</script>