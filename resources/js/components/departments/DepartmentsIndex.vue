<template>
	<div>
		<div class="form-group">
			<router-link :to="{name: 'Adminka'}" class="btn btn btn-success">Назад</router-link>
		</div>	
		<div class="form-group">
			<router-link :to="{name: 'createDepartment'}" class="btn btn-success">Создать новую запись</router-link>
		</div>
		
		<div class="card">
			<div class="card-header">
				Перечень объектов контрагента
			</div>
			<div class="card-body">
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>Name</th>
							<th>Address</th>
							<th width="100">&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="department, index in departments">
							<td>{{ department.name }}</td>
							<td>{{ department.address }}</td>
							<td>
								<router-link :to="{name: 'showDepartment', params: {id: department.id}}" class="btn btn-xs btn-success">Посмотреть</router-link><br>
								<router-link :to="{name: 'editDepartment', params: {id: department.id}}" class="btn btn-xs btn-warning">Изменить</router-link>
								<a href="#" class="btn btn-xs btn-danger" v-on:click="deleteEntry(department.id, index)">Удалить</a>
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
			departments: []
		}
	},
	mounted() {
		var app = this;
		axios.get('/api/v1/departments')
			.then(function (resp) {
				app.departments = resp.data.departments;
			})
			.catch(function (resp) {
				alert("Не удалось загрузить данные");
			});
	},
	methods: {
			deleteEntry(id, index) {
				if (confirm("Вы действительно хотите удалить запись?")) {
					var app = this;
					axios.delete('/api/v1/departments/' + id)
						.then(function (resp) {
							axios.get('/api/v1/departments')
								.then(function (resp) {
									app.departments = resp.data.departments;
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