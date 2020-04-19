<template>
	<div>
		<div class="form-group">
			<div @click="$router.go(-1)" class="btn btn-success">Назад</div>
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
						</tr>
					</thead>
					<tbody>
						<tr v-for="department, index in departments">
							<td><router-link :to="{name: 'showDepartment', params: {id: department.id}}" class="nav-link">{{ department.name }}</router-link></td>
							<td>{{ department.address }}</td>
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
		}
	}
</script>