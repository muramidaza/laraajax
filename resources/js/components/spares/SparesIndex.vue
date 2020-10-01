<template>
	<div>
		<div class="form-group">
			<div @click="$router.go(-1)" class="btn btn-success">Назад</div>
		</div>
	
		<div class="card">
			<div class="card-header">
				Перечень требующихся запасных частей<br>
			</div>
			<div class="card-body">
				
				<div v-for="spare, index in spares" class="card">
					<div class="card-header">
						<router-link :to="{name: 'showAct', params: {id: spare.act.id}}" class="nav-link">{{ spare.type }} {{ spare.name }}</router-link>
					</div>
					<div class="card-body">
						<template v-if="spare.model">Модель {{ spare.model }} <br></template>
						<template v-if="spare.parameter">Параметр {{ spare.parameter }} <br></template>
						<template v-if="spare.qty">Количество {{ spare.qty }} {{ spare.unit }}<br></template>
						<template v-if="spare.note">Примечание {{ spare.note }} <br></template>							
					</div>
					<div class="card-footer">
						<div v-on:click="spares.splice(index, 1)" class="btn btn-success">Удалить</div>
					</div>					
				</div>
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
				spares: [],
				owner: null,
				paginData: {
					paginatorButtons: [], 
					currentPage: 1,
					recordsInPage: 5,
					paginatorLength: 5,
					paginatorPage: 0,
					countPages: 0,					
				},
				
			}
		},
		mounted() {
				let app = this;
				app.loaddata();
			},
		methods: {
			loaddata() {
				let app = this;
				
				let id = app.paginData.currentPage;
				let count = app.paginData.recordsInPage;
				
				axios.get('/api/v1/spares/indexpage/' + count + '/' + id + '/' + window.orderBy)
					.then(function (resp) {
						app.spares = resp.data.spares;
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