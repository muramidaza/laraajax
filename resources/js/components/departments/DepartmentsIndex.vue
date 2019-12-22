<template>
	<div>
		<div class="form-group">
			<router-link :to="{name: 'Adminka'}" class="btn btn-success">Main</router-link>
		</div>	
		<div class="form-group">
			<router-link :to="{name: 'createDepartment'}" class="btn btn-success">Create new department</router-link>
		</div>
		
		<div class="panel panel-default">
			<div class="panel-heading">Departaments list</div>
			<div class="panel-body">
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
								<router-link :to="{name: 'editDepartment', params: {id: department.id}}" class="btn btn-xs btn-default">Edit</router-link>
								<a href="#" class="btn btn-xs btn-danger" v-on:click="deleteEntry(department.id, index)">Delete</a>
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
				alert("Не удалось загрузить отделения");
			});
	},
	methods: {
			deleteEntry(id, index) {
				if (confirm("Вы действительно хотите удалить отделение?")) {
					var app = this;
					axios.delete('/api/v1/departments/' + id)
						.then(function (resp) {
							axios.get('/api/v1/departments')
								.then(function (resp) {
									app.departments = resp.data.departments;
								})
								.catch(function (resp) {
									alert("Не удалось загрузить отделения");
								});
						})
						.catch(function (resp) {
							alert("Не удалось удалить отдел");
						});
				}
			}
		}
	}
</script>