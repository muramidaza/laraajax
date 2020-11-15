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
						
						<InputTextComponent name-props='name' label-props='Название' v-bind:list-data='listData' v-bind:errors-props='errors' v-on:onChange="handleChangeText"/>
						<InputTextComponent name-props='city' label-props='Город' v-bind:list-data='listData' v-bind:errors-props='errors' v-on:onChange="handleChangeText"/>
						<InputTextComponent name-props='address' label-props='Физический адрес' v-bind:list-data='listData' v-bind:errors-props='errors' v-on:onChange="handleChangeText"/>
						<InputTextComponent name-props='contract' label-props='Номер договора' v-bind:list-data='listData' v-bind:errors-props='errors' v-on:onChange="handleChangeText"/>
						<InputTextComponent name-props='director' label-props='ФИО директора' v-bind:list-data='listData' v-bind:errors-props='errors' v-on:onChange="handleChangeText"/>
						<InputTextComponent name-props='phone1' label-props='Телефон 1' v-bind:list-data='listData' v-bind:errors-props='errors' v-on:onChange="handleChangeText"/>
						<InputTextComponent name-props='phone2' label-props='Телефон 2' v-bind:list-data='listData' v-bind:errors-props='errors' v-on:onChange="handleChangeText"/>
						<InputTextComponent name-props='website' label-props='Сайт' v-bind:list-data='listData' v-bind:errors-props='errors' v-on:onChange="handleChangeText"/>
						<InputTextComponent name-props='email' label-props='Е-майл' v-bind:list-data='listData' v-bind:errors-props='errors' v-on:onChange="handleChangeText"/>
						
						<div class="card">
							<div class="card-header">
								<div v-on:click="toggle=!toggle" class="btn btn-link">{{ toggle? 'Скрыть реквизиты' : 'Показать реквизиты'}}</div>
							</div>
							
							<div class="card-body" v-if="toggle">
							
								<InputTextComponent name-props='UridAddress' label-props='Юридический адрес'v-bind:errors-props='errors' v-on:onChange="handleChangeText"/>
								<hr>
								<InputTextComponent name-props='OGRN' label-props='ОГРН' v-bind:list-data='listData' v-bind:errors-props='errors' v-on:onChange="handleChangeText"/>
								<InputTextComponent name-props='INN' label-props='ИНН' v-bind:list-data='listData' v-bind:errors-props='errors' v-on:onChange="handleChangeText"/>
								<InputTextComponent name-props='KPP' label-props='КПП' v-bind:list-data='listData' v-bind:errors-props='errors' v-on:onChange="handleChangeText"/>
								<InputTextComponent name-props='OKPO' label-props='ОКПО' v-bind:list-data='listData' v-bind:errors-props='errors' v-on:onChange="handleChangeText"/>
								<InputTextComponent name-props='OKVED' label-props='ОКВЭД' v-bind:list-data='listData' v-bind:errors-props='errors' v-on:onChange="handleChangeText"/>
								<InputTextComponent name-props='RSchet' label-props='Расчетный счет' v-bind:list-data='listData' v-bind:errors-props='errors' v-on:onChange="handleChangeText"/>
								<InputTextComponent name-props='KSchet' label-props='Корр. счет' v-bind:list-data='listData' v-bind:errors-props='errors' v-on:onChange="handleChangeText"/>
								<InputTextComponent name-props='BIK' label-props='БИК' v-bind:list-data='listData' v-bind:errors-props='errors' v-on:onChange="handleChangeText"/>
								
							</div>
						</div>
						
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
	import InputTextComponent from '../Common/InputComponents/InputTextComponent';

	export default {
		data: function () {
			return {
				listData: {
				},
				errors: {
				},
				toggle: false
			}
		},
		components: {
			InputTextComponent
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
						//alert("Не удалось создать компанию");
						if(JSON.parse(resp.request.responseText).message == 'The given data was invalid.') app.errors = JSON.parse(resp.request.responseText).errors; else alert("Ошибка на сервере");

						console.log(JSON.parse(resp.request.responseText).message);
					});
			},
			handleChangeText(retObj) {
				const app = this;
				app.listData[retObj.key] = retObj.payload;
				console.log(app.listData[retObj.key]);
			}			
		}
	}
</script>