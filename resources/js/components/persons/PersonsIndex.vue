<template>
	<div>
		<div class="form-group">
			<div @click="$router.go(-1)" class="btn btn-success">Назад</div>
		</div>
		<div class="form-group">
			<router-link :to="{name: 'createPerson'}" class="btn btn-success">Создать новую запись</router-link>
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
						</tr>
					</thead>
					<tbody>
						<tr v-for="person, index in persons">
							<td><router-link :to="{name: 'showPerson', params: {id: person.id}}" class="nav-link">{{ person.name }} <br> {{ person.surname }} <br> {{ person.patronymic }}</router-link></td>
							<td>{{ person.post }}</td>
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
				persons: [],
			}
		},
		mounted() {
			var app = this;
			axios.get('/api/v1/persons')
				.then(function (resp) {
					app.persons = resp.data.persons;
				})
				.catch(function (resp) {
					alert("Не удалось загрузить данные");
				});
			}
	}
</script>