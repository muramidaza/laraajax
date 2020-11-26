<template>
	<div>
		<div class="form-group">
			<div @click="$router.go(-1)" class="btn btn-success">Назад</div>
		</div>
		
		<div class="card">
			<div class="card-header">
				Редактировать существующую запись об организации
			</div>
			<div class="card-body" v-if="Object.keys(listData).length > 0">
				<form v-on:submit="saveForm()">

						<InputsList v-bind:list-data-props='listData' v-bind:errors-props='errors' v-on:onChangeData='handleChangeData'/>
						
						<hr>
						
						<div class="col-xs-12 form-group">
							<button class="btn btn-success">Сохранить запись</button>
						</div>

				</form>
			</div>
		</div>
	</div>
</template>

<script>
	import InputsList from './InputsList';
	
	export default {
		mounted() {
			const app = this;
			const id = app.$route.params.id;
			app.id = id;
			axios.get('/api/v1/companies/' + id + '/edit')
				.then(function (resp) {
					app.listData = resp.data;
				})
				.catch(function () {
					alert("Не удалось загрузить данные")
				});
		},
		data: function () {
			return {
				id: null,
				listData: {},
				errors: {}
			}
		},
		components: {
			InputsList
		},		
		methods: {
			saveForm() {
				event.preventDefault();
				const app = this;
				axios.patch('/api/v1/companies/' + app.id, app.company)
					.then(function (resp) {
						app.$router.go(-1);
					})
					.catch(function (resp) {
						if(JSON.parse(resp.request.responseText).message == 'The given data was invalid.') app.errors = JSON.parse(resp.request.responseText).errors; else alert("Ошибка на сервере");
						console.log(JSON.parse(resp.request.responseText).message);
					});
			},
			handleChangeData(retObj) {
				const app = this;
				app.listData[retObj.key] = retObj.payload;
				console.log(retObj);
			}			
		}
	}
</script>