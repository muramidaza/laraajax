<template>
	<div>
		<div class="form-group">
			<router-link to="/admin/companies/index" class="btn btn-success">Назад</router-link>
		</div>
		
		<div class="card">
			<div class="card-header">
				Просмтор записи об организации
			</div>
			<div class="card-body">
				<div>
						<div class="col-xs-12 form-group">
							<label class="control-label">Название организации</label>
							<input type="text" v-model="company.name" class="form-control">
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
	
						</div>	
						
						<div class="col-xs-12 form-group">
							<label class="control-label">Телефон 1</label>
							<input type="text" v-model="company.phone1" class="form-control">
	
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

				</div>
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
					app.company = resp.data;
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
					BIK: ''
				},
				toggle: false
			}
		}
	}
</script>