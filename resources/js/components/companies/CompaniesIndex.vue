<template>
	<div>
		<div class="form-group">
			<div @click="$router.go(-1)" class="btn btn-success">Назад</div>
		</div>
		<div class="form-group">
			<router-link :to="{name: 'createCompany'}" class="btn btn-success">Создать новую запись</router-link>
		</div>
	
		<div class="card" v-if="companies.length>0">
			<div class="card-header">
				<h3>Перечень контрагентов (юр. лица)</h3>
				<div class="form-check">
					<input type="checkbox" class="form-check-input" id="onlyContract" v-model="onlyContract">
					<label class="form-check-label" for="onlyContract">Только по договору</label>
				</div>
			</div>
			<div class="card-body">
				<div v-for="company, index in companies" class="card">
					<div class="card-header">
						<router-link :to="{name: 'showCompany', params: {id: company.id}}" class="nav-link">{{ company.name }}</router-link>
					</div>
					<div class="card-body">
						<template v-if="company.contract">Договор № {{ company.contract }} <br></template>
						<template v-if="company.city">Город: {{ company.city }} <br></template>
						<template v-if="company.director">Директор: {{ company.director }} <br></template>
						<template v-if="company.phone1">Контактный телефон: {{ company.phone1 }} </template>
					</div>
					<div class="card-footer">
						<span v-if="company.departments.length > 0"><router-link :to="{name: 'indexDepartments', params: {idcompany: company.id}}" class="nav-link">Подразделения</router-link></span>
						<span><router-link :to="{name: 'indexPersons', params: {idcompany: company.id}}" class="nav-link">Сотрудники</router-link></span>
						<span><router-link :to="{name: 'indexEquipments', params: {idcompany: company.id}}" class="nav-link">Оборудование</router-link></span>
						<span><router-link :to="{name: 'indexActs', params: {idcompany: company.id}}" class="nav-link">Заявки</router-link></span>
					</div>					
				</div>
			</div>
			<div class="card-footer">
				<paginator v-bind:countRecords="paginData.countRecords" v-bind:recordsInPage="paginData.recordsInPage" v-on:onChangePage="handleChangePage" />
			</div>			
		</div>
	</div>	
</template>
	
<script>
	import paginator from '../common/paginator/paginator.vue'
	
	const RECORDS_IN_PAGE = 5;
	
	export default {
		components: {paginator},
		data: function () {
			return {
				companies: [],
				paginData: {
					currentPage: 1,
					countRecords: 0,
					recordsInPage: 5
				},
				onlyContract: true
			}
		},
		mounted() {
				const app = this;
				app.loaddata();
			},
		watch: {
			onlyContract: function () {
				const app = this;
				app.loaddata();
			},
			'paginData.currentPage': function () {
				const app = this;
				app.loaddata();
			}
		},
		methods: {
			loaddata() {
				const app = this;
				
				axios.get('/api/v1/companies/indexpage/' + app.paginData.recordsInPage + '/' + app.paginData.currentPage + '/' + +app.onlyContract)
					.then(function (resp) {
						app.companies = resp.data.companies;
						app.paginData.countRecords = resp.data.countrecords;
						//app.paginData.countRecords = 100;
						
					})
					.catch(function (resp) {
						alert("Не удалось загрузить данные");
					});				
			},
			handleChangePage(value) {
				const app = this;
				app.paginData.currentPage = value;
			}
		}
	}
</script>