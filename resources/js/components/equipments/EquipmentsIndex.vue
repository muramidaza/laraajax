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
						<li class="page-item">
							<button class="page-link" @click="paginatorPage--" v-if="paginatorPage > 0">Previous</button>
						</li>
						<li class="page-item" v-for="number in paginatorButtons[paginatorPage]" v-bind:class="{active: currentPage == number}">
							<button class="page-link" @click="currentPage = number">
								{{ number }} <span v-if="number == currentPage" class="sr-only">(current)</span>
							</button>
						</li>
						<li class="page-item">
							<button class="page-link" @click="paginatorPage++" v-if="paginatorPage < paginatorButtons.length - 1">Next</button>
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
				recordsInPage: 2,
				paginatorLength: 5,
				paginatorPage: 0,
				countPages: 0
			}
		},
		watch: {
			currentPage: function() {
				let app = this;
				app.loaddata();
			}
		},
		mounted() {
				let app = this;
				app.loaddata();
			},
		methods: {
			loaddata() {
				let app = this;
				const formData = new FormData();
				let id = app.currentPage;
				let count = app.recordsInPage;

				axios.get('/api/v1/equipments/indexpage/' + count + '/' + id)
					.then(function (resp) {
						app.equipments = resp.data.equipments;
						let countRecords = resp.data.countrecords;
						//countRecords = 100;
						app.countPages = Math.ceil(countRecords / app.recordsInPage);
						console.log(countRecords + '-' + app.countPages);
						app.paginatorButtons = [];
						let pageNum = 1;
						for(let i = 0; pageNum <= countRecords; i++) {
							app.paginatorButtons[i] = [];
							for(let j = 0; j < app.paginatorLength && pageNum <= countRecords; j++, pageNum++) {
								app.paginatorButtons[i].push(pageNum);
							}
						}
						console.log(app.paginatorButtons.length);
					})
					.catch(function (resp) {
						alert("Не удалось загрузить данные");
					});				
			}
		}
	}
</script>