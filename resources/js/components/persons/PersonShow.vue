<template>
	<div>
	
		<div class="form-group">
			<div @click="$router.go(-1)" class="btn btn-success">Назад</div>
		</div>
		
		<div class="card">
			<div class="card-header">
				Просмотр существующей записи
			</div>
			
			<div class="card-body">
				<form v-on:submit="saveForm()">

					<div class="col-xs-12 form-group" v-if="person.companies.length>0">
						<div class="control-label" v-if="person.executive"><b>Является представителем руководства компании</b></div>
						<div class="control-label" v-else><b>Является сотрудником компании</b></div>
						<ul v-for="company in person.companies" class="list-group">
							<li class="list-group-item"> {{ company.name }} </li>
						</ul>
					</div>
					
					<div class="col-xs-12 form-group" v-if="person.departments.length>0">
						<div class="control-label" v-if="person.executive"><b>Является представителем руководства подразделения</b></div>
						<div class="control-label" v-else><b>Является сотрудником подразделения</b></div>
						<label class="control-label">Компания</label>
						<div class="list-group-item" v-if="person.departments.length > 0">{{ person.departments[0].company.name }}</div>
						<label class="control-label">Подразделение</label>
						<ul v-for="department in person.departments" class="list-group">
							<li class="list-group-item"> {{ department.name }} </li>
						</ul>
					</div>
					
					<div class="col-xs-12 form-group" v-if="!person.companies.length>0 && !person.departments.length>0">
						<div class="control-label"><b>Является частным лицом</b></div>

						</ul>
					</div>					
					
					<hr>

					<div class="col-xs-12 form-group">
						<label class="control-label">Имя</label>
						<div class="form-control">{{ person.name }}</div>
					</div>

					<div class="col-xs-12 form-group" v-if="person.surname">
						<label class="control-label">Фамилия</label>
						<div class="form-control">{{ person.surname }}</div>
					</div>

					<div class="col-xs-12 form-group" v-if="person.patronymic">
						<label class="control-label">Отчество</label>
						<div class="form-control">{{ person.patronymic }}</div>
					</div>
					
					<div class="col-xs-12 form-group" v-if="person.datebirth">
						<label class="control-label">Дата рождения</label>
						<div class="form-control">{{ person.datebirth }}</div>
					</div>						

					<div class="col-xs-12 form-group" v-if="person.sex">
						<label class="control-label">Пол:  </label>
						<div class="form-control" v-if="person.sex == 'woman'">Женский</div>
						<div class="form-control" v-if="person.sex == 'man'">Мужской</div>
					</div>							
					
					<div class="col-xs-12 form-group" v-if="person.phone1">
						<label class="control-label">Номер телефона 1</label>
						<div class="form-control">{{ person.phone1 }}</div>
					</div>

					<div class="col-xs-12 form-group" v-if="person.phone2">
						<label class="control-label">Номер телефона 2</label>
						<div class="form-control">{{ person.phone2 }}</div>
					</div>

					<div class="col-xs-12 form-group" v-if="person.post">
						<label class="control-label">Должность</label>
						<div class="form-control">{{ person.post }}</div>
					</div>

					<div class="col-xs-12 form-group" v-if="person.address">
						<label class="control-label">Адрес</label>
						<div class="form-control">{{ person.address }}</div>
					</div>

					<div class="col-xs-12 form-group" v-if="person.email">
						<label class="control-label">E-mail</label>
						<div class="form-control">{{ person.email }}</div>
					</div>

					<div class="col-xs-12 form-group" v-if="person.web">
						<label class="control-label">Соц сеть</label>
						<div class="form-control">{{ person.web }}</div>
					</div>						

					<hr>
					
					<div class="col-xs-12 form-group" v-if="person.files.length>0">
						<label class="control-label">Фотографии</label>
													
						<div class="container">
							<div class="row">
								<div class="col-md-4 border" v-for="(image, index) in person.files">
									<img v-bind:src="image['pathFile']" class="img-thumbnail" v-if="image['pathFile'].length>0">
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="card-footer">
				<router-link :to="{name: 'editPerson', params: {id: person.id}}" class="btn btn-xs btn-warning">Изменить</router-link>
				<a href="#" class="btn btn-xs btn-danger" v-on:click="deleteEntry(person.id, index)">Удалить</a>
			</div>
		</div>
		
		<div class="card" v-if="person.equipments">
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
						<tr v-for="equipment, index in person.equipments" class="nav-item">
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
				<router-link :to="{name: 'createEquipment', params: {personId: personId}}" class="btn btn-success">Об оборудование</router-link>
			</div>
		</div>		
		
	</div>
</template>
 
<script>
	export default {
		data: function () {
			return {
				personId: null,
				currentTab: 'single',
				person: {
					name: '',
					surname: '',
					patronymic: '',
					datebirth: null,
					sex: null,
					sexNum: null,
					phone1: '',
					phone2: '',
					address: '',
					post: '',
					email: '',
					web: '',
					executive: false,
					companies: [],
					departments: [],
					files: []
				}
			}
		},
		mounted() {
			let app = this;
			let id = app.$route.params.id;
			app.personId = id;
			axios.get('/api/v1/persons/' + id)
				.then(function (resp) {
					app.person = resp.data.person;
					console.log(app.person);
				})
			 .catch(function () {
				 alert("Не удалось загрузить данные")
			  });
		},
		methods: {
			deleteEntry(id) {
				if (confirm("Вы действительно удалить хотите запись?")) {
					var app = this;
					
					axios.delete('/api/v1/persons/' + id)
						.then(function (resp) {
						
						})
						.catch(function (resp) {
							alert("Не удалось удалить запись");
						});
				}
			}
		}
	}
</script>