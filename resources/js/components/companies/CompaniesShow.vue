<template>
	<div>
		<div class="form-group">
			<router-link to="/admin/companies/index" class="btn btn-success">Назад</router-link>
		</div>
		
		<div class="card">
			<div class="card-header">
				Просмотр записи об организации
			</div>
			<div class="card-body">
				<div>
						<div class="col-xs-12 form-group">
							<label class="control-label">Название организации</label>
							<div class="form-control">{{ company.name }}</div>
						</div>

						<div class="col-xs-12 form-group">
							<label class="control-label">Город</label>
							<div class="form-control">{{ company.city }}</div>
						</div>
						
						<div class="col-xs-12 form-group">
							<label class="control-label">Физический адрес</label>
							<div class="form-control">{{ company.address }}</div>
						</div>
						
						<div class="col-xs-12 form-group">
							<label class="control-label">Номер договора</label>
							<div class="form-control">{{ company.contract }}</div>
						</div>

						<div class="col-xs-12 form-group">
							<label class="control-label">ФИО директора</label>
							<div class="form-control">{{ company.director }}</div>
						</div>	
						
						<div class="col-xs-12 form-group">
							<label class="control-label">Телефон 1</label>
							<div class="form-control">{{ company.phone1 }}</div>	
						</div>
						
						<div class="col-xs-12 form-group">
							<label class="control-label">Телефон 2</label>
							<div class="form-control">{{ company.phone2 }}</div>
						</div>	
						
						<div class="col-xs-12 form-group">
							<label class="control-label">Сайт</label>
							<div class="form-control">{{ company.website }}</div>
						</div>

						<div class="col-xs-12 form-group">
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
			</div>
			<div class="card-footer">
				<router-link :to="{name: 'editCompany', params: {id: companyId}}" class="btn btn-xs btn-warning">Изменить</router-link><br>
				<a href="#" class="btn btn-xs btn-danger" v-on:click="deleteEntry(companyId)">Удалить</a>			
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
		},
		methods: {
			deleteEntry(id) {
				if (confirm("Вы действительно хотите удалить запись?")) {
					var app = this;
					axios.delete('/api/v1/companies/' + id)
						.then(function (resp) {
							axios.get('/api/v1/companies')
								.then(function (resp) {
									app.companies = resp.data.companies;
								})
								.catch(function (resp) {
									alert("Не удалось загрузить данные");
								});
						})
						.catch(function (resp) {
							alert("Не удалось удалить запись");
						});
				}
			}
		}		
	}
</script>