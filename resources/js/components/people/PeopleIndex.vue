<template>
	<div>
		<div class="form-group">
			<router-link :to="{name: 'Adminka'}" class="btn btn-success">Main</router-link>
		</div>
		<div class="form-group">
			<router-link :to="{name: 'createPeople'}" class="btn btn-success">Create new people</router-link>
		</div>
	
	<div class="panel panel-default">
		<div class="panel-heading">People list</div>
			<div class="panel-body">
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>Name</th>
							<th>Surname</th>
							<th>Patronymic</th>
							<th>Job</th>
							<th width="100">&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="onepeople, index in people">
							<td>{{ onepeople.name }}</td>
							<td>{{ onepeople.surname }}</td>
							<td>{{ onepeople.patronymic }}</td>
							<td>{{ onepeople.address }}</td>
							<td>
								<router-link :to="{name: 'editPeople', params: {id: onepeople.id}}" class="btn btn-xs btn-default">Edit</router-link>
								<a href="#" class="btn btn-xs btn-danger" v-on:click="deleteEntry(onepeople.id, index)">Delete</a>
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
				people: []
			}
		},
		mounted() {
			var app = this;
			axios.get('/api/v1/people')
				.then(function (resp) {
					app.people = resp.data.people;
				})
				.catch(function (resp) {
					alert("Не удалось загрузить людей");
				});
			},
		methods: {
			deleteEntry(id) {
				if (confirm("Вы действительно хотите удалить человека?")) {
					var app = this;
					axios.delete('/api/v1/people/' + id)
						.then(function (resp) {
							app.$router.push({path: '/admin/people/index'});
						})
						.catch(function (resp) {
							alert("Не удалось удалить человека");
						});
				}
			}
		}
	}
</script>