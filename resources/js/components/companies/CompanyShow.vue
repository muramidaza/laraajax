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
				<div class="card" v-for="department, index in company.departments">
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
		
		<div class="card" v-if="company.persons.length > 0">
			<div class="card-header">
				Перечень персонала
			</div>
			<div class="card-body" v-for="person, index in company.persons">
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
		
		<div class="card" v-if="company.equipments.length > 0">
			<div class="card-header">
				Перечень оборудования
			</div>
			<div class="card-body" v-for="equipment, index in company.equipments">
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
			let id = +app.$route.params.id;
			app.companyId = id;
			console.log('Company ID');
			console.log(typeof(app.$route.params.id));
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