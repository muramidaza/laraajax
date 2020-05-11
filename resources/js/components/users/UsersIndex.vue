<template>
	<div>
		<div class="form-group">
			<div @click="$router.go(-1)" class="btn btn-success">Назад</div>
		</div>
	
		<div class="card">
			<div class="card-header">
				Перечень сотрудников
			</div>
			<div class="card-body">
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>ФИО</th>
							<th>Должность</th>
							<th width="100">&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="user, index in users">
						
							<td>{{ user.name }} <hr> {{ user.realname }} <br> {{ user.surname }} <br> {{ user.patronymic }} </td>
							<td>{{ user.post }}</td>
							<td>
								<router-link :to="{name: 'showUser', params: {id: user.id}}" class="btn btn-xs btn-success">Посмотреть</router-link><br>
								<router-link :to="{name: 'editUser', params: {id: user.id}}" class="btn btn-xs btn-warning">Изменить</router-link>
								<a href="#" class="btn btn-xs btn-danger" v-on:click="deleteEntry(user.id, index)">Удалить</a>
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
				users: [],
			}
		},
		mounted() {
			var app = this;
			axios.get('/api/v1/users')
				.then(function (resp) {
					app.users = resp.data.users;
				})
				.catch(function (resp) {
					alert("Не удалось загрузить данные");
				});
			},
		methods: {
			deleteEntry(id) {
				if (confirm("Вы действительно хотите удалить запись?")) {
					var app = this;
					
					axios.delete('/api/v1/users/' + id)
						.then(function (resp) {
							console.log('quit');
							axios.get('/api/v1/users')
								.then(function (resp) {
									app.users = resp.data.users;
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