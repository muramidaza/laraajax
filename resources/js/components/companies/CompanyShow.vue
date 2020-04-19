<template>
	<div>
		<div class="form-group">
			<div @click="$router.go(-1)" class="btn btn-success">Назад</div>
		</div>
		
		<div class="card">
			<div class="card-header">
				Просмотр записи об организации
			</div>
			<div class="card-body">
				<div class="col-xs-12 form-group">
					<label class="control-label">Название организации</label>
					<div class="form-control">{{ company.name }}</div>
				</div>

				<div class="col-xs-12 form-group" v-if="company.city">
					<label class="control-label">Город</label>
					<div class="form-control">{{ company.city }}</div>
				</div>
				
				<div class="col-xs-12 form-group" v-if="company.address">
					<label class="control-label">Физический адрес</label>
					<div class="form-control">{{ company.address }}</div>
				</div>
				
				<div class="col-xs-12 form-group" v-if="company.contract">
					<label class="control-label">Номер договора</label>
					<div class="form-control">{{ company.contract }}</div>
				</div>

				<div class="col-xs-12 form-group" v-if="company.director">
					<label class="control-label">ФИО директора</label>
					<div class="form-control">{{ company.director }}</div>
				</div>	
				
				<div class="col-xs-12 form-group" v-if="company.phone1">
					<label class="control-label">Телефон 1</label>
					<div class="form-control">{{ company.phone1 }}</div>	
				</div>
				
				<div class="col-xs-12 form-group" v-if="company.phone2">
					<label class="control-label">Телефон 2</label>
					<div class="form-control">{{ company.phone2 }}</div>
				</div>	
				
				<div class="col-xs-12 form-group" v-if="company.website">
					<label class="control-label">Сайт</label>
					<div class="form-control">{{ company.website }}</div>
				</div>

				<div class="col-xs-12 form-group" v-if="company.email">
					<label class="control-label">E-mail</label>
					<div class="form-control">{{ company.email }}</div>
				</div>
				
				<div class="card">
					<div class="card-header">
						<div v-on:click="toggle=!toggle" class="btn btn-link">{{ toggle? 'Скрыть реквизиты' : 'Показать реквизиты'}}</div>
					</div>
					
					<div class="card-body" v-show="toggle">
					
						<div class="col-xs-12 form-group">
							<label class="control-label">ОГРН</label>
							<div class="form-control">{{ company.OGRN }}</div>
						</div>

						<div class="col-xs-12 form-group">
							<label class="control-label">ИНН</label>
							<div class="form-control">{{ company.INN }}</div>
						</div>

						<div class="col-xs-12 form-group">
							<label class="control-label">КПП</label>
							<div class="form-control">{{ company.KPP }}</div>
						</div>

						<div class="col-xs-12 form-group">
							<label class="control-label">Юр. адрес</label>
							<div class="form-control">{{ company.UridAddress }}</div>
						</div>

						<div class="col-xs-12 form-group">
							<label class="control-label">ОКПО</label>
							<div class="form-control">{{ company.OKPO }}</div>
						</div>

						<div class="col-xs-12 form-group">
							<label class="control-label">ОКВЭД</label>
							<div class="form-control">{{ company.OKVED }}</div>
						</div>

						<div class="col-xs-12 form-group">
							<label class="control-label">Расчетный счет</label>
							<div class="form-control">{{ company.RSchet }}</div>
						</div>

						<div class="col-xs-12 form-group">
							<label class="control-label">Корр. счет</label>
							<div class="form-control">{{ company.KSchet }}</div>
						</div>

						<div class="col-xs-12 form-group">
							<label class="control-label">БИК банка</label>
							<div class="form-control">{{ company.BIK }}</div>
						</div>
						
					</div>
				</div>
			</div>
			<div class="card-footer">
				<router-link :to="{name: 'editCompany', params: {id: companyId}}" class="btn btn-xs btn-warning">Изменить</router-link>
				<a href="#" class="btn btn-xs btn-danger" v-on:click="deleteEntry(companyId)">Удалить</a>			
			</div>		
		</div>
		
		<div class="card" v-if="company.departments.length > 0">
			<div class="card-header">
				Перечень подразделений (отделов)
			</div>
			<div class="card-body">
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>Название</th>
							<th>Адрес</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="department, index in company.departments" class="nav-item">
							<td><router-link :to="{name: 'showDepartment', params: {id: department.id}}" class="nav-link">{{ department.name }}</router-link></td>
							<td>{{ department.address }}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		
		<div class="card" v-if="company.persons.length > 0">
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
						<tr v-for="person, index in company.persons" class="nav-item">
							<td><router-link :to="{name: 'showPerson', params: {id: person.id}}" class="nav-link">{{ person.name }} <br> {{ person.surname }} <br> {{ person.patronymic }}</router-link></td>
							<td>{{ person.post }}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>		
		
		<div class="card" v-if="company.equipments.length > 0">
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
						<tr v-for="equipment, index in company.equipments" class="nav-item">
							<td><router-link :to="{name: 'showEquipment', params: {id: equipment.id}}" class="nav-link">{{ equipment.type }} <br> {{ equipment.manufacturer }} <br> {{ equipment.model }}</router-link></td>
							<td>{{ equipment.sernumber }}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		
		<hr>
		<div class="card">
			<div class="card-header">
				Добавить новую запись
			</div>
			<div class="card-body">
				<router-link :to="{name: 'createDepartment', params: {companyId: companyId}}" class="btn btn-success">О подразделении</router-link>
				<router-link :to="{name: 'createEquipment', params: {companyId: companyId}}" class="btn btn-success">Об оборудование</router-link>
				<router-link :to="{name: 'createPerson', params: {companyId: companyId}}" class="btn btn-success">О сотруднике</router-link>
			</div>
		</div>
			
	</div>
</template>

<script>
	export default {
		mounted() {
			let app = this;
			let id = app.$route.params.id;
			app.companyId = id;
			axios.get('/api/v1/companies/' + id)
				.then(function (resp) {
					app.company = resp.data.companies;
					
				})
				.catch(function () {
					alert("Не удалось загрузить данные")
				});
		},
		data: function () {
			return {
				companyId: null,
				company: {
					name: '',
					address: '',
					director: '',
					website: '',
					email: '',
					phone1: '',
					phone2: '',
					city: '',
					contract: '',
					
					OGRN: '',
					INN: '',
					KPP: '',
					UridAddress: '',
					OKPO: '',
					OKVED: '',
					RSchet: '',
					KSchet: '',
					BIK: '',
					
					departments: [],
					persons: [],
					equipments: []				
				},
				toggle: false
			}
		},
		methods: {
			deleteEntry(id) {
				if (confirm("Вы действительно удалить хотите запись?")) {
					var app = this;
					
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