<template>
	<div>
		<div class="form-group">
			<div @click="$router.go(-1)" class="btn btn-success">Назад</div>
		</div>
		
		<div class="card">
			<div class="card-header">
				Создать новую запись об организации
			</div>
			
			<div class="card-body">
				<form v-on:submit="saveForm()">
						
						<div class="col-xs-12 form-group">
							<label class="control-label">Название организации</label>
							<input type="text" v-model="company.name" class="form-control">
							<ul v-if="errors.name" class="alert-danger">
								<li v-for="error in errors.name">{{error}}</li>
							</ul>
						</div>

						<div class="col-xs-12 form-group">
							<label class="control-label">Город</label>
							<input type="text" v-model="company.city" class="form-control">
						</div>
						
						<div class="col-xs-12 form-group">
							<label class="control-label">Физический адрес</label>
							<input type="text" v-model="company.address" class="form-control">
						</div>
						
						<div class="col-xs-12 form-group">
							<label class="control-label">Номер договора</label>
							<input type="text" v-model="company.contract" class="form-control">
						</div>

						<div class="col-xs-12 form-group">
							<label class="control-label">ФИО директора</label>
							<input type="text" v-model="company.director" class="form-control">
							<ul v-if="errors.director" class="alert-danger">
								<li v-for="error in errors.director">{{error}}</li>
							</ul>						
						</div>	
						
						<div class="col-xs-12 form-group">
							<label class="control-label">Телефон 1</label>
							<input type="text" v-model="company.phone1" class="form-control">
							<ul v-if="errors.phone1" class="alert-danger">
								<li v-for="error in errors.phone1">{{error}}</li>
							</ul>							
						</div>
						
						<div class="col-xs-12 form-group">
							<label class="control-label">Телефон 2</label>
							<input type="text" v-model="company.phone2" class="form-control">
						</div>	
						
						<div class="col-xs-12 form-group">
							<label class="control-label">Сайт</label>
							<input type="text" v-model="company.website" class="form-control">
						</div>

						<div class="col-xs-12 form-group">
							<label class="control-label">E-mail</label>
							<input type="text" v-model="company.email" class="form-control">
						</div>
						
						<div class="card">
							<div class="card-header">
								<div v-on:click="toggle=!toggle" class="btn btn-link">{{ toggle? 'Скрыть реквизиты' : 'Показать реквизиты'}}</div>
							</div>
							
							<div class="card-body" v-show="toggle">
							
								<div class="col-xs-12 form-group">
									<label class="control-label">ОГРН</label>
									<input type="text" v-model="company.OGRN" class="form-control">
								</div>

								<div class="col-xs-12 form-group">
									<label class="control-label">ИНН</label>
									<input type="text" v-model="company.INN" class="form-control">
								</div>

								<div class="col-xs-12 form-group">
									<label class="control-label">КПП</label>
									<input type="text" v-model="company.KPP" class="form-control">
								</div>

								<div class="col-xs-12 form-group">
									<label class="control-label">Юр. адрес</label>
									<input type="text" v-model="company.UridAddress" class="form-control">
								</div>

								<div class="col-xs-12 form-group">
									<label class="control-label">ОКПО</label>
									<input type="text" v-model="company.OKPO" class="form-control">
								</div>

								<div class="col-xs-12 form-group">
									<label class="control-label">ОКВЭД</label>
									<input type="text" v-model="company.OKVED" class="form-control">
								</div>

								<div class="col-xs-12 form-group">
									<label class="control-label">Расчетный счет</label>
									<input type="text" v-model="company.RSchet" class="form-control">
								</div>

								<div class="col-xs-12 form-group">
									<label class="control-label">Корр. счет</label>
									<input type="text" v-model="company.KSchet" class="form-control">
								</div>

								<div class="col-xs-12 form-group">
									<label class="control-label">БИК банка</label>
									<input type="text" v-model="company.BIK" class="form-control">
								</div>
								
							</div>
						</div>
						
						<hr>
						
						<div class="col-xs-12 form-group">
							<button class="btn btn-success">Создать запись</button>
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
					BIK: ''
				},
				errors: {
					name: null,
					director: null,
					phone1: null
				},
				toggle: false
			}
		},
		methods: {
			saveForm() {
				event.preventDefault();
				var app = this;
				var newCompany = app.company;
				axios.post('/api/v1/companies', newCompany)
					.then(function (resp) {
						app.$router.go(-1);
					})
					.catch(function (resp) {
						//alert("Не удалось создать компанию");
						if(JSON.parse(resp.request.responseText).message == 'The given data was invalid.') app.errors = JSON.parse(resp.request.responseText).errors; else alert("Ошибка на сервере");

						console.log(JSON.parse(resp.request.responseText).message);
					});
			}
		}
	}
</script>