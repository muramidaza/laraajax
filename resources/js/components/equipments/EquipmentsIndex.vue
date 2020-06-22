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
							<button class="page-link" @click="paginData.paginatorPage--" v-if="paginData.paginatorPage > 0">Previous</button>
						</li>
						<li class="page-item" v-for="number in paginData.paginatorButtons[paginData.paginatorPage]" v-bind:class="{active: paginData.currentPage == number}">
							<button class="page-link" @click="paginData.currentPage = number; loaddata();">
								{{ number }} <span v-if="number == paginData.currentPage" class="sr-only">(current)</span>
							</button>
						</li>
						<li class="page-item">
							<button class="page-link" @click="paginData.paginatorPage++" v-if="paginData.paginatorPage < paginData.paginatorButtons.length - 1">Next</button>
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
				paginData: {
					paginatorButtons: [], 
					currentPage: 1,
					recordsInPage: 2,
					paginatorLength: 5,
					paginatorPage: 0,
					countPages: 0,					
				}
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
				let id = app.paginData.currentPage;
				let count = app.paginData.recordsInPage;

				axios.get('/api/v1/equipments/indexpage/' + count + '/' + id)
					.then(function (resp) {
						app.equipments = resp.data.equipments;
						app.paginData.countRecords = resp.data.countrecords;
						
						app.paginator();//данные для своей работы он возьмет из data.paginator
					})
					.catch(function (resp) {
						alert("Не удалось загрузить данные");
					});				
			},
			paginator() {
				let app = this;
				console.log('paginator');
				app.paginData.countPages = Math.ceil(app.paginData.countRecords / app.paginData.recordsInPage);
				app.paginData.paginatorButtons = [];
				let pageNum = 1;
				console.log(app.paginData.countPages);
				for(let i = 0; pageNum <= app.paginData.countPages; i++) {
					app.paginData.paginatorButtons[i] = [];
					for(let j = 0; j < app.paginData.paginatorLength && pageNum <= app.paginData.countPages; j++, pageNum++) {
						app.paginData.paginatorButtons[i].push(pageNum);
					}
				}				
			}
		}
	}
</script>