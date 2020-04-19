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
						</tr>
					</thead>
					<tbody>
						<tr v-for="equipment, index in equipments">
							<td><router-link :to="{name: 'showEquipment', params: {id: equipment.id}}" class="nav-link">{{ equipment.type }} <br> {{ equipment.manufacturer }} <br> {{ equipment.model }}</router-link></td>
							<td>{{ equipment.sernumber }}</td>
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
			}
	}
</script>