<template>
	<div>
		<div class="form-group">
			<router-link to="/admin/users/index" class="btn btn-success">Назад</router-link>
		</div>
		
		<div class="card">
			<div class="card-header">
				Просмотр существующей записи
			</div>
			
			<div class="card-body">
				<form v-on:submit="saveForm()">

						<div><h2>{{ user.name }}</h2></div>
					
						<hr>				
				
						<div class="col-xs-12 form-group">
							<label class="control-label">Имя</label>
							<div class="form-control">{{ user.realname }}</div>
						</div>

						<div class="col-xs-12 form-group" v-if="user.surname">
							<label class="control-label">Фамилия</label>
							<div class="form-control">{{ user.surname }}</div>
						</div>

						<div class="col-xs-12 form-group" v-if="user.patronymic">
							<label class="control-label">Отчество</label>
							<div class="form-control">{{ user.patronymic }}</div>
						</div>
						
						<div class="col-xs-12 form-group" v-if="user.datebirth">
							<label class="control-label">Дата рождения</label>
							<div class="form-control">{{ user.datebirth }}</div>
						</div>						

						<div class="col-xs-12 form-group" v-if="user.sex">
							<label class="control-label">Пол:  </label>
							<div class="form-control" v-if="user.sex == 'woman'">Женский</div>
							<div class="form-control" v-if="user.sex == 'man'">Мужской</div>
						</div>							
						
						<div class="col-xs-12 form-group" v-if="user.phone1">
							<label class="control-label">Номер телефона 1</label>
							<div class="form-control">{{ user.phone1 }}</div>
						</div>

						<div class="col-xs-12 form-group" v-if="user.phone2">
							<label class="control-label">Номер телефона 2</label>
							<div class="form-control">{{ user.phone2 }}</div>
						</div>

						<div class="col-xs-12 form-group" v-if="user.post">
							<label class="control-label">Должность</label>
							<div class="form-control">{{ user.post }}</div>
						</div>

						<div class="col-xs-12 form-group" v-if="user.address">
							<label class="control-label">Адрес</label>
							<div class="form-control">{{ user.address }}</div>
						</div>

						<div class="col-xs-12 form-group" v-if="user.email">
							<label class="control-label">E-mail</label>
							<div class="form-control">{{ user.email }}</div>
						</div>

						<div class="col-xs-12 form-group" v-if="user.web">
							<label class="control-label">Соц сеть</label>
							<div class="form-control">{{ user.web }}</div>
						</div>						

						<hr>
						
						<div class="col-xs-12 form-group">
							<div class="control-label" v-if="user.executive">Является представителем руководства</div>
						</div>		
						
						<hr>
						
						<div class="col-xs-12 form-group" v-if="user.files.length>0">
							<label class="control-label">Фотографии</label>
														
							<div class="container">
								<div class="row">
									<div class="col-md-4 border" v-for="(image, index) in user.files">
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
				userID: null,
				user: {
					name: '',
					realname: '',
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
			app.userID = id;
			axios.get('/api/v1/users/' + id)
				.then(function (resp) {
					app.user = resp.data.user;
					console.log(app.user);
				})
			 .catch(function () {
				 alert("Не удалось загрузить данные")
			  });
		}
	}
</script>