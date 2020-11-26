<template>
	<div>
		<div class="form-group">
			<div @click="$router.go(-1)" class="btn btn-success">Назад</div>
		</div>
		
		<div class="card">
			<div class="card-header">
				Просмотр записи об организации
			</div>
			
			<div class="card-body"  v-if="Object.keys(listData).length > 0">
				<InputsList v-bind:list-data-props='listData' v-bind:read-only='true' />
			</div>
			
			<div class="card-footer">
				<router-link :to="{name: 'editCompany', params: {id: id}}" class="btn btn-xs btn-warning">Изменить</router-link>
				<a href="#" class="btn btn-xs btn-danger" v-on:click="deleteEntry(id)">Удалить</a>			
			</div>		
		</div>
		
		<div class="card" v-if="listData.departments && listData.departments.length > 0">
			<div class="card-header">
				Перечень подразделений (отделов)
			</div>
			<div class="card-body">
				<div class="card" v-for="department, index in listData.departments">
					<div class="card-header">
						<td><router-link :to="{name: 'showDepartment', params: {id: department.id}}" class="nav-link">{{ department.name }}</router-link></td>
					</div>
					<div class="card-body">
						<template v-if="department.city">Город: {{ department.city }} <br></template>
						<template v-if="department.address">Адрес: {{ department.address }} <br></template>
						<template v-if="department.phone1">Контактный телефон: {{ department.phone1 }} </template>					
					</div>
				</div>
			</div>
		</div>
		
		<div class="card" v-if="listData.persons && listData.persons.length > 0">
			<div class="card-header">
				Перечень персонала
			</div>
			<div class="card-body" v-for="person, index in listData.persons">
				<div class="card">
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
		
		<div class="card" v-if="listData.equipments && listData.equipments.length > 0">
			<div class="card-header">
				Перечень оборудования
			</div>
			<div class="card-body" v-for="equipment, index in listData.equipments">
				<div class="card">
					<div class="card-header">
						<td><router-link :to="{name: 'showEquipment', params: {id: equipment.id}}" class="nav-link">{{ equipment.type }} {{ equipment.manufacturer }} {{ equipment.model }}</router-link></td>
					</div>
					<div class="card-body">
						<template v-if="equipment.sernumber">Серийный номер: {{ equipment.sernumber }} <br></template>
						<template v-if="equipment.invnumber">Инвентарный номер: {{ equipment.invnumber }} </template>
					</div>
				</div>
			</div>
		</div>
		
		<hr>
		<div class="card">
			<div class="card-header">
				Добавить новую запись
			</div>
			<div class="card-body">
				<router-link :to="{name: 'createDepartment', params: {companyId: id}}" class="btn btn-success">О подразделении</router-link>
				<router-link :to="{name: 'createEquipment', params: {companyId: id}}" class="btn btn-success">Об оборудование</router-link>
				<router-link :to="{name: 'createPerson', params: {companyId: id}}" class="btn btn-success">О сотруднике</router-link>
			</div>
		</div>
			
	</div>
</template>

<script>
	import InputsList from './InputsList';
	
	export default {
		mounted() {
			const app = this;
			const id = +app.$route.params.id;
			app.id = id;
			axios.get('/api/v1/companies/' + id)
				.then(function (resp) {
					app.listData = resp.data;
				})
				.catch(function () {
					alert("Не удалось загрузить данные")
				});
		},
		data: function () {
			return {
				id: null,
				listData: {	
				},
				readonly: true
			}
		},
		components: {
			InputsList
		},		
		methods: {
			deleteEntry(id) {
				if (confirm("Вы действительно удалить хотите запись?")) {
					let app = this;
					
					axios.delete('/api/v1/companies/' + id)
						.then(function (resp) {
							router.push('indexCompanies');
						})
						.catch(function (resp) {
							alert("Не удалось удалить запись");
						});
				}
			}
		}		
	}
</script>