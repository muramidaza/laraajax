<template>
	<div>
		<div class="form-group">
			<router-link :to="{name: 'Adminka'}" class="btn btn-success">Назад</router-link>
		</div>
		<div class="form-group">
			<router-link :to="{name: 'createEquipment'}" class="btn btn-success">Создать новую запись</router-link>
		</div>
	
		<div class="card">
			<div class="card-header">
				Перечень сотрудников
			</div>
			<div class="card-body">
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>Наименование</th>
							<th>Серийный №</th>
							<th width="100">&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="equipment, index in equipments">
							<td>{{ equipment.type }} <br> {{ equipment.manufacturer }} <br> {{ equipment.model }} </td>
							<td>{{ equipment.sernumber }}</td>
							<td>
								<router-link :to="{name: 'showEquipment', params: {id: equipment.id}}" class="btn btn-xs btn-success">Посмотреть</router-link><br>
								<router-link :to="{name: 'editEquipment', params: {id: equipment.id}}" class="btn btn-xs btn-warning">Изменить</router-link>
								<a href="#" class="btn btn-xs btn-danger" v-on:click="deleteEntry(equipment.id, index)">Удалить</a>
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
				equipments: [],
			}
		},
		mounted() {
			var app = this;
			axios.get('/api/v1/equipments')
				.then(function (resp) {
					app.equipments = resp.data.equipments;
				})
				.catch(function (resp) {
					alert("Не удалось загрузить данные");
				});
			},
		methods: {
			deleteEntry(id) {
				if (confirm("Вы действительно удалить хотите запись?")) {
					var app = this;
					
					axios.delete('/api/v1/equipments/' + id)
						.then(function (resp) {
							console.log('quit');
							axios.get('/api/v1/equipments')
								.then(function (resp) {
									app.equipments = resp.data.equipments;
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