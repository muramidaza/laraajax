<template>
	<div>
		<div class="form-group">
			<div @click="$router.go(-1)" class="btn btn-success">Назад</div>
		</div>
		
		<div class="card">
			<div class="card-header">
				Перечень объектов контрагента <template v-if="company">" {{company.name}} "</template>
			</div>
			<div class="card-body">
				<div class="card" v-for="department, index in departments">
					<div class="card-header">
						<router-link :to="{name: 'showDepartment', params: {id: department.id}}" class="nav-link">{{ department.name }}</router-link>
					</div>
					<div class="card-body">
						<template v-if="department.city">Город: {{ department.city }} </template>							
						<template v-if="department.address">Адрес: {{ department.address }} <br></template>
						<template v-if="department.manager">Менеджер: {{ department.manager }} <br></template>
						<template v-if="department.phone1">Телефон: {{ department.phone1 }} <br></template>
					</div>
					<div class="card-footer">
						<span v-if="department.persons.length > 0"><router-link :to="{name: 'indexPersons', params: {iddepartment: department.id}}" class="nav-link">Сотрудники</router-link></span>
						<span v-if="department.equipments.length > 0"><router-link :to="{name: 'indexEquipments', params: {iddepartment: department.id}}" class="nav-link">Оборудование</router-link></span>
						<span v-if="department.acts.length > 0"><router-link :to="{name: 'indexActs', params: {iddepartment: department.id}}" class="nav-link">Заявки</router-link></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
	
<script>
	export default {
		data: function () {
			return {
				departments: [],
				idCompany: null,
				company: null
			}
		},
		mounted() {
			let app = this;
			if(app.$route.params.idcompany) window.idCompany = +app.$route.params.idcompany;
			
			if(window.idCompany === null) {
				axios.get('/api/v1/departments')
					.then(function (resp) {
						app.departments = resp.data.departments;
						console.log(app.departments);
					})
					.catch(function (resp) {
						alert("Не удалось загрузить данные");
					});
			} else {
				axios.get('/api/v1/departments/extendindex/' + window.idCompany)
					.then(function (resp) {
						app.departments = resp.data.departments;
						app.company = resp.data.company;
						console.log(app.departments);
					})
					.catch(function (resp) {
						alert("Не удалось загрузить данные");
					});
			
			}
		}
	}
</script>