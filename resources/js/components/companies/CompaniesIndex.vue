<template>
	<div>
		<div class="form-group">
			<div @click="$router.go(-1)" class="btn btn-success">Назад</div>
		</div>
		<div class="form-group">
			<router-link :to="{name: 'createCompany'}" class="btn btn-success">Создать новую запись</router-link>
		</div>
	
		<div class="card">
			<div class="card-header">
				<h3>Перечень контрагентов (юр. лица)</h3>
				<div class="form-check">
					<input type="checkbox" class="form-check-input" id="onlyContract" v-model="onlyContract">
					<label class="form-check-label" for="onlyContract">Только по договору</label>
				</div>
			</div>
			<div class="card-body">
				<div v-for="company, index in companies" class="card">
					<div class="card-header">
						<router-link :to="{name: 'showCompany', params: {id: company.id}}" class="nav-link">{{ company.name }}</router-link>
					</div>
					<div class="card-body">
						<template v-if="company.contract">Договор № {{ company.contract }} <br></template>
						<template v-if="company.city">Город: {{ company.city }} <br></template>
						<template v-if="company.director">Директор: {{ company.director }} <br></template>
						<template v-if="company.phone1">Контактный телефон: {{ company.phone1 }} </template>
					</div>
					<div class="card-footer" v-if="company.departments.length > 0">
						<router-link :to="{name: 'indexDepartments', params: {idcompany: company.id}}" class="nav-link">Подразделения</router-link>
					</div>
				</div>
			</div>
			<div class="card-footer">
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
				companies: [],
				paginData: {
					paginatorButtons: [], 
					currentPage: 1,
					recordsInPage: 5,
					paginatorLength: 5,
					paginatorPage: 0,
					countPages: 0,					
				},
				onlyContract: true
			}
		},
		mounted() {
				let app = this;
				app.loaddata();
			},
		watch: {
			onlyContract: function () {
				let app = this;
				app.loaddata();
			}
		},
		methods: {
			loaddata() {
				let app = this;
				const formData = new FormData();
				let id = app.paginData.currentPage;
				let count = app.paginData.recordsInPage;

				axios.get('/api/v1/companies/indexpage/' + count + '/' + id + '/' + +app.onlyContract)
					.then(function (resp) {
						app.companies = resp.data.companies;
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