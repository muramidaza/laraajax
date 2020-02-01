<template>
	<div>
		<div class="form-group">
			<router-link :to="{name: 'Adminka'}" class="btn btn-success">Назад</router-link>
		</div>
		<div class="form-group">
			<router-link :to="{name: 'createPeople'}" class="btn btn-success">Создать новую запись</router-link>
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
						<tr v-for="onepeople, index in people">
							<td>{{ onepeople.name }} <br> {{ onepeople.surname }} <br> {{ onepeople.patronymic }} </td>
							<td>{{ onepeople.post }}</td>
							<td>
								<router-link :to="{name: 'showPeople', params: {id: onepeople.id}}" class="btn btn-xs btn-success">Посмотреть</router-link><br>
								<router-link :to="{name: 'editPeople', params: {id: onepeople.id}}" class="btn btn-xs btn-warning">Изменить</router-link>
								<a href="#" class="btn btn-xs btn-danger" v-on:click="deleteEntry(onepeople.id, index)">Удалить</a>
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
				people: [],
			}
		},
		mounted() {
			var app = this;
			axios.get('/api/v1/people')
				.then(function (resp) {
					app.people = resp.data.people;
				})
				.catch(function (resp) {
					alert("Не удалось загрузить данные");
				});
			},
		methods: {
			deleteEntry(id) {
				if (confirm("Вы действительно хотите запись?")) {
					var app = this;
					
					axios.delete('/api/v1/people/' + id)
						.then(function (resp) {
							console.log('quit');
							axios.get('/api/v1/people')
								.then(function (resp) {
									app.people = resp.data.people;
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