<template>
	<div>
		<div class="form-group">
			<div @click="$router.go(-1)" class="btn btn-success">Назад</div>
		</div>
		
		<div class="card">
			<div class="card-header">
				Редактирование существующей записи
			</div>
			
			<div class="card-body">
				<form v-on:submit="saveForm()">
					<div><h2>{{ user.name }}</h2></div>
					
					<hr>
					
					<div class="col-xs-12 form-group">
						<label class="control-label">Имя</label>
						<input type="text" v-model="user.realname" class="form-control" required>
						<ul v-if="errors.name" class="alert-danger">
							<li v-for="error in errors.realname">{{error}}</li>
						</ul>	
					</div>

					<div class="col-xs-12 form-group">
						<label class="control-label">Фамилия</label>
						<input type="text" v-model="user.surname" class="form-control">
					</div>

					<div class="col-xs-12 form-group">
						<label class="control-label">Отчество</label>
						<input type="text" v-model="user.patronymic" class="form-control">
					</div>
					
					<div class="col-xs-12 form-group">
						<label class="control-label">Дата рождения</label>
						<input type="date" v-model="user.datebirth" class="form-control">
					</div>						

					<div class="col-xs-12 form-group">
						<label class="control-label">Пол:  </label>
						<input type="radio" value="man" v-model="user.sex"><label>М</label>
						<input type="radio" value="woman" v-model="user.sex"><label>Ж</label>
					</div>							
					
					<div class="col-xs-12 form-group">
						<label class="control-label">Номер телефона 1</label>
						<input type="text" v-model="user.phone1" class="form-control">
					</div>

					<div class="col-xs-12 form-group">
						<label class="control-label">Номер телефона 2</label>
						<input type="text" v-model="user.phone2" class="form-control">
					</div>

					<div class="col-xs-12 form-group">
						<label class="control-label">Должность</label>
						<input type="text" v-model="user.post" class="form-control">
					</div>

					<div class="col-xs-12 form-group">
						<label class="control-label">Адрес</label>
						<input type="text" v-model="user.address" class="form-control">
					</div>

					<div class="col-xs-12 form-group">
						<label class="control-label">E-mail</label>
						<input type="text" v-model="user.email" class="form-control">
					</div>

					<div class="col-xs-12 form-group">
						<label class="control-label">Соц сеть</label>
						<input type="text" v-model="user.web" class="form-control">
					</div>

					<div class="col-xs-12 form-group">
						<label class="control-label">Является представителем руководства</label>
						<input type="checkbox" id="executive" v-model="user.executive">
					</div>						
					
					<hr>
					
					<div class="col-xs-12 form-group" v-if="user.files.length>0">
						<label class="control-label">Уже загруженные фотографии</label>
													
						<div class="container">
							<div class="row">
								<div class="col-md-4 border" v-for="(image, index) in user.files">
									<img v-bind:src="image['pathFile']" class="img-thumbnail" v-if="image['pathFile'].length>0">
									<p v-on:click="user.files.splice(index, 1); filesDeleteID.push(image['id'])">X</p>
								</div>
							</div>
						</div>
					</div>

					<hr>
					
					<div class="col-xs-12 form-group">
						<label class="control-label">Фотографии которые нужно загрузить</label>
						<input type="file" class="form-control" multiple v-on:change="onAttachmentChange">
						
						<div class="container">
							<div class="row">
								<div class="col-md-4 border" v-for="(image, index) in imagesData">
									<img v-bind:src="image" class="img-thumbnail" v-if="image.length>0">
									<p href="#" v-on:click="imagesData.splice(index, 1); files.splice(index, 1)">X</p>
								</div>
							</div>
						</div>
					</div>							
					
					<hr>

					<div class="col-xs-12 form-group">
						<button class="btn btn-success">Сохранить изменения</button>
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
					files: [] //список файлов на сервере- при удалении их ID добавляются в filesDeleteID
				},
				
				errors: {
					name: null
				},
				
				imagesData: [], //пути на диске клиента к файлам, которые нужно загрузить на сервер
				files: [], //файлы, которые нужно загрузить на сервер
				filesDeleteID: [], //ID файлов которые нужно удалить

			}
		},
		mounted() {
			let app = this;
			let id = app.$route.params.id;
			app.userID = id;
			axios.get('/api/v1/users/' + id + '/edit')
				.then(function (resp) {
					app.user = resp.data.user;
				})
			 .catch(function () {
				 alert("Не удалось загрузить данные")
			  });
		},
		methods: {
			saveForm() {
				event.preventDefault();
				var app = this;
				console.log('save');
				
				const formData = new FormData();
				formData.append('name', app.user.name);
				if(app.user.realname) formData.append('realname', app.user.realname);
				if(app.user.surname) formData.append('surname', app.user.surname);
				if(app.user.patronymic) formData.append('patronymic', app.user.patronymic);
				if(app.user.datebirth) formData.append('datebirth', app.user.datebirth); // если не указано не передаем - если передать то будет попытка записать в виде строки null в поле DATE
				if(app.user.sex) formData.append('sex', app.user.sex);
				if(app.user.phone1) formData.append('phone1', app.user.phone1);
				if(app.user.phone2) formData.append('phone2', app.user.phone2);
				if(app.user.email) formData.append('email', app.user.email);
				if(app.user.web) formData.append('web', app.user.web);
				if(app.user.post) formData.append('post', app.user.post);
				if(app.user.address) formData.append('address', app.user.address);
				formData.append('executive', +app.user.executive); //преобразуем в число иначе будет попытка записать в виде строки null в TINYINT
				formData.append('companies', app.IDcompaniesToSave);
				formData.append('departments', app.IDdepartmentsToSave);
				if(app.filesDeleteID) formData.append('delfiles', app.filesDeleteID);
				
				formData.append('_method', 'PATCH');
				
				app.files.forEach(function (file, i) {                    
					formData.append('Attachment[' + i + ']', file); //прямо вот так по одному и втаскиваем в формДата - в контроллере понимает эти записи за один массив
				});
				
				axios.post('/api/v1/users/' + app.userID, formData, {
						headers: {'Content-Type': 'multipart/form-data'}
					})
					.then(function (resp) {
						app.$router.push({path: '/admin/user/index'});
					})
					.catch(function (resp) {
						console.log(resp);
						if(JSON.parse(resp.request.responseText).message == 'The given data was invalid.') app.errors = JSON.parse(resp.request.responseText).errors; else alert("Ошибка на сервере");
					});				
				
			},
			onAttachmentChange (e) {
				var app = this;
				
				var arrfiles = [];
				for(var i = 0; i < e.target.files.length; i++) {
					arrfiles[i] = e.target.files[i];
					
					var reader = new FileReader();
					reader.onload = (e) => {
						app.imagesData.push(e.target.result);
					}
					reader.readAsDataURL(e.target.files[i]);					
				}
				
				app.files = arrfiles;
			}
		}
	}
</script>