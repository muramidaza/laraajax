<template>
	<div>
		<div class="form-group">
			<router-link :to="{name: 'Adminka'}" class="btn btn-success">Назад</router-link>
		</div>
		<div class="form-group">
			<router-link :to="{name: 'createCompany'}" class="btn btn-success">Создать новую запись</router-link>
		</div>
	
		<div class="card">
			<div class="card-header">Список юридических лиц</div>
			<div class="card-body">
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>Название</th>
							<th>Адрес</th>
							<th>Сайт</th>
							<th>E-Mail</th>
							<th width="100">&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="company, index in companies">
							<td>{{ company.name }}</td>
							<td>{{ company.address }}</td>
							<td>{{ company.phone1 }}</td>
							<td>{{ company.email }}</td>
							
							<td>
								<router-link :to="{name: 'editCompany', params: {id: company.id}}" class="btn btn-xs btn-warning">Изменить</router-link><br>
								<a href="#" class="btn btn-xs btn-danger" v-on:click="deleteEntry(company.id, index)">Удалить</a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>	
</template>
	
<script>
	export default {
		data: function () {
			return {
				companies: []
			}
		},
		mounted() {
			var app = this;
			axios.get('/api/v1/companies')
				.then(function (resp) {
					app.companies = resp.data.companies;
				})
				.catch(function (resp) {
					alert("Не удалось загрузить данные");
				});
		},
		methods: {
			deleteEntry(id, index) {
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