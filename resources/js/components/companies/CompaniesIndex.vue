<template>
	<div>
		<div class="form-group">
			<div @click="$router.go(-1)" class="btn btn-success">Назад</div>
		</div>
		<div class="form-group">
			<router-link :to="{name: 'createCompany'}" class="btn btn-success">Создать новую запись</router-link>
		</div>
	
		<div class="card">
			<div class="card-header">
				Перечень контрагентов (юр. лица)
			</div>
			<div class="card-body">
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>Название</th>
							<th>Адрес</th>
							<th>Договор</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="company, index in companies" class="nav-item">
							<td><router-link :to="{name: 'showCompany', params: {id: company.id}}" class="nav-link">{{ company.name }}</router-link></td>
							<td>{{ company.city }} <br> {{ company.address }}</td>
							<td>{{ company.contract }}</td>
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
		}
	}
</script>