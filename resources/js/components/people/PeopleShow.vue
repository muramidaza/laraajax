<template>
	<div>
		<div class="form-group">
			<router-link to="/admin/people/index" class="btn btn-success">Назад</router-link>
		</div>
		
		<div class="card">
			<div class="card-header">
				Просмотр существующей записи
			</div>
			
			<div class="card-body">
				<form v-on:submit="saveForm()">

						<div class="col-xs-12 form-group">
							<label class="control-label">Имя</label>
							<div class="form-control">{{ people.name }}</div>
						</div>

						<div class="col-xs-12 form-group" v-if="people.surname">
							<label class="control-label">Фамилия</label>
							<div class="form-control">{{ people.surname }}</div>
						</div>

						<div class="col-xs-12 form-group" v-if="people.patronymic">
							<label class="control-label">Отчество</label>
							<div class="form-control">{{ people.patronymic }}</div>
						</div>
						
						<div class="col-xs-12 form-group" v-if="people.datebirth">
							<label class="control-label">Дата рождения</label>
							<div class="form-control">{{ people.datebirth }}</div>
						</div>						

						<div class="col-xs-12 form-group" v-if="people.sex">
							<label class="control-label">Пол:  </label>
							<div class="form-control" v-if="people.sex == 'woman'">Женский</div>
							<div class="form-control" v-if="people.sex == 'man'">Мужской</div>
						</div>							
						
						<div class="col-xs-12 form-group" v-if="people.phone1">
							<label class="control-label">Номер телефона 1</label>
							<div class="form-control">{{ people.phone1 }}</div>
						</div>

						<div class="col-xs-12 form-group" v-if="people.phone2">
							<label class="control-label">Номер телефона 2</label>
							<div class="form-control">{{ people.phone2 }}</div>
						</div>

						<div class="col-xs-12 form-group" v-if="people.post">
							<label class="control-label">Должность</label>
							<div class="form-control">{{ people.post }}</div>
						</div>

						<div class="col-xs-12 form-group" v-if="people.address">
							<label class="control-label">Адрес</label>
							<div class="form-control">{{ people.address }}</div>
						</div>

						<div class="col-xs-12 form-group" v-if="people.email">
							<label class="control-label">E-mail</label>
							<div class="form-control">{{ people.email }}</div>
						</div>

						<div class="col-xs-12 form-group" v-if="people.web">
							<label class="control-label">Соц сеть</label>
							<div class="form-control">{{ people.web }}</div>
						</div>						

						<hr>
						
						<div class="col-xs-12 form-group" v-if="people.companies.length>0">
							<div class="control-label" v-if="people.executive">Является представителем руководства компании</div>
							<div class="control-label" v-else>Является сотрудником компании</div>
							<ul v-for="company in people.companies">
								<li> {{ company.name }} </li>
							</ul>
						</div>
						
						<div class="col-xs-12 form-group" v-if="people.departments.length>0">
							<div class="control-label" v-if="people.executive">Является представителем руководства подразделения</div>
							<div class="control-label" v-else>Является сотрудником подразделения</div>
							<ul v-for="department in people.departments">
								<li> {{ department.name }} </li>
							</ul>
						</div>
						
						<hr>
						
						<div class="col-xs-12 form-group" v-if="imagesLoadData.length>0">
							<label class="control-label">Фотографии</label>
														
							<div class="container">
								<div class="row">
									<div class="col-md-4 border" v-for="(image, index) in imagesLoadData">
										<img v-bind:src="image['pathFile']" class="img-thumbnail" v-if="image['pathFile'].length>0">
									</div>
								</div>
							</div>
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
				peopleID: null,
				currentTab: 'single',
				people: {
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
				},
				imagesLoadData: [], //url уже загруженных файлов на сервере
			}
		},
		mounted() {
			let app = this;
			let id = app.$route.params.id;
			app.peopleID = id;
			axios.get('/api/v1/people/' + id)
				.then(function (resp) {
					app.people = resp.data.onepeople;
					app.people.companies = resp.data.relcompanies;
					app.people.departments = resp.data.reldepartments;
					app.imagesLoadData = resp.data.filesdata;
				})
			 .catch(function () {
				 alert("Не удалось загрузить данные")
			  });
		}
	}
</script>