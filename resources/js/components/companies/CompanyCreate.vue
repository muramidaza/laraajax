<template>
	<div>
		<div class="form-group">
			<div @click="$router.go(-1)" class="btn btn-success">Назад</div>
		</div>
		
		<div class="card">
			<div class="card-header">
				Создать новую запись об организации
			</div>
			
			<div class="card-body">
				<form v-on:submit="saveForm()">
						
						<InputsList v-bind:list-data-props='listData' v-bind:errors-props='errors' v-on:onChangeData='handleChangeData'/>
						
						<hr>
						
						<div class="col-xs-12 form-group">
							<button class="btn btn-success">Создать запись</button>
						</div>

				</form>
			</div>
		</div>
	</div>
</template>
 
<script>
	import InputsList from './InputsList';
	
	export default {
		data: function () {
			return {
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
				let app = this;
				axios.post('/api/v1/companies', listData)
					.then(function (resp) {
						app.$router.go(-1);
					})
					.catch(function (resp) {
						if(JSON.parse(resp.request.responseText).message == 'The given data was invalid.') app.errors = JSON.parse(resp.request.responseText).errors; else alert("Ошибка на сервере");
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