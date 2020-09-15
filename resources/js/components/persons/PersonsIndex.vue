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
				Физические лица
				<h3></h3>
				<div class="form-check">
					<input type="checkbox" class="form-check-input" id="freePersons" v-model="freePersons">
					<label class="form-check-label" for="freePersons">Работающие в компаниях-клиентах</label>
				</div>				
			</div>
			<div class="card-body">
				<div class="card" v-for="person, index in persons">
					<div class="card-header">
						<router-link :to="{name: 'showPerson', params: {id: person.id}}" class="nav-link">{{ person.name }} {{ person.surname }} {{ person.patronymic }}</router-link>						
					</div>
					<div class="card-body">
						<template v-if="person.post">Должность: {{ person.post }} <br></template>
						<template v-if="person.phone1">Телефон: {{ person.phone1 }} </template>
					</div>
					<div class="card-footer">
						<span v-if="person.equipments.length > 0"><router-link :to="{name: 'indexEquipments', params: {idperson: person.id}}" class="nav-link">Оборудование</router-link></span>
						<span v-if="person.acts.length > 0"><router-link :to="{name: 'indexActs', params: {idperson: person.id}}" class="nav-link">Заявки</router-link></span>
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
				persons: [],
				paginData: {
					paginatorButtons: [], 
					currentPage: 1,
					recordsInPage: 5,
					paginatorLength: 5,
					paginatorPage: 0,
					countPages: 0,					
				},
				freePersons: false,

			}
		},
		mounted() {
				let app = this;
				app.loaddata();
			},
		watch: {
			freePersons: function () {
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
				
				if(typeof(app.$route.params.idcompany) != 'undefined') {
					window.referID = +app.$route.params.idcompany;
					window.referType = 'company';
				}
				if(typeof(app.$route.params.iddepartment) != 'undefined') {
					window.referID = +app.$route.params.iddepartment;
					window.referType = 'department';
				}
				
				console.log(app.$route.params.idcompany);
				console.log(app.$route.params.iddepartment);
				
				axios.get('/api/v1/persons/indexpage/' + count + '/' + id + '/' + +app.freePersons + '/' + window.referType + '/' + window.referID)
					.then(function (resp) {
						app.persons = resp.data.persons;
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