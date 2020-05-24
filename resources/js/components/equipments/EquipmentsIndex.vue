<template>
	<div>
		<div class="form-group">
			<div @click="$router.go(-1)" class="btn btn-success">Назад</div>
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
			<div>
				<nav>
					<ul class="pagination justify-content-center">
						<li class="page-item" v-for="number in paginatorButtons" v-bind:class="{active: currentPage == number}">
							<div class="page-link" @click="currentPage = number">
								{{ number }} <span v-if="number == currentPage" class="sr-only">(current)</span>
							</div>
						</li>
					</ul>
				</nav>			
			</div>
		</div>
	</div>
</template>
	
<script>
	export default {
		data: function () {
			return {
				equipments: [],
				paginatorButtons: [], 
				currentPage: 1,
				recordsInPage: 10,
				parinatorItems: 10,
				countPages: 0
			}
		},
		watch: {
			currentPage: function() {
				let app = this;
				app.data.method.loaddata();
			}
		},
		mounted() {
				var app = this;
				const formData = new FormData();
				formData.append('currentPage', app.currentPage);
				formData.append('recordsInPage', app.recordsInPage);

				axios.get('/api/v1/equipments', formData)
					.then(function (resp) {
						app.equipments = resp.data.equipments;
						let countRecords = resp.data.countrecords;
						app.countPages = Math.ceil(countRecords / app.recordsInPage);
						
						for(let i = 1; i <= app.countPages; i++) {
							app.paginatorButtons.push(i);
						}
					})
					.catch(function (resp) {
						alert("Не удалось загрузить данные");
					});	
			},
		method: {
			loaddata() {
				var app = this;
				const formData = new FormData();
				formData.append('currentPage', app.currentPage);
				formData.append('recordsInPage', app.recordsInPage);

				axios.get('/api/v1/equipments', formData)
					.then(function (resp) {
						app.equipments = resp.data.equipments;
						let countRecords = resp.data.countRecords;
						app.countPages = Math.ceil(countRecords / app.recordsInPage);
						
						for(i = 1; i <= app.countPages; i++) {
							app.paginatorButtons.push(i);
						}
					})
					.catch(function (resp) {
						alert("Не удалось загрузить данные");
					});				
			}
		}
	}
</script>