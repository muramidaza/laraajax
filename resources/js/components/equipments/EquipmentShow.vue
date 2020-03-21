<template>
	<div>
		<div class="form-group">
			<router-link to="/admin/equipment/index" class="btn btn-success">Назад</router-link>
		</div>
		
		<div class="card">
			<div class="card-header">
				Просмотр существующей записи
			</div>
			
			<div class="card-body">
				<form v-on:submit="saveForm()">

					<div class="col-xs-12 form-group">
						<label class="control-label">Тип</label>
						<div class="form-control">{{ equipment.type }}</div>
					</div>

					<div class="col-xs-12 form-group">
						<label class="control-label">Производитель</label>
						<div class="form-control">{{ equipment.manufacturer }}</div>
					</div>

					<div class="col-xs-12 form-group">
						<label class="control-label">Модель</label>
						<div class="form-control">{{ equipment.model }}</div>
					</div>
					
					<div class="col-xs-12 form-group" v-if="equipment.modification">
						<label class="control-label">Модификация</label>
						<div class="form-control">{{ equipment.modification }}</div>
					</div>

					<div class="col-xs-12 form-group" v-if="equipment.sernumber">
						<label class="control-label">Серийный номер</label>
						<div class="form-control">{{ equipment.sernumber }}</div>
					</div>						
					
					<div class="col-xs-12 form-group" v-if="equipment.datemanuf">
						<label class="control-label">Дата изготовления</label>
						<div class="form-control">{{ equipment.datemanuf }}</div>
					</div>			

					<div class="col-xs-12 form-group" v-if="equipment.invnumber">
						<label class="control-label">Инвентарный номер</label>
						<div class="form-control">{{ equipment.invnumber }}</div>
					</div>

					<div class="col-xs-12 form-group" v-if="equipment.voltage">
						<label class="control-label">Напряжение питания</label>
						<div class="form-control">{{ equipment.voltage }}</div>
					</div>

					<div class="col-xs-12 form-group" v-if="equipment.current">
						<label class="control-label">Потребляемый ток</label>
						<div class="form-control">{{ equipment.current }}</div>
					</div>

					<div class="col-xs-12 form-group" v-if="equipment.power">
						<label class="control-label">Мощность</label>
						<div class="form-control">{{ equipment.power }}</div>
					</div>

					<div class="col-xs-12 form-group" v-if="equipment.weight">
						<label class="control-label">Вес</label>
						<div class="form-control">{{ equipment.weight }}</div>
					</div>
					
					<div class="col-xs-12 form-group" v-if="equipment.sizes">
						<label class="control-label">Размеры</label>
						<div class="form-control">{{ equipment.sizes }}</div>
					</div>

					<div class="col-xs-12 form-group" v-if="equipment.manufсountry">
						<label class="control-label">Страна производитель</label>
						<div class="form-control">{{ equipment.manufсountry }}</div>
					</div>

					<div class="col-xs-12 form-group" v-if="equipment.note">
						<label class="control-label">Описание</label><br>
						<p> {{ equipment.note }}</p>
					</div>					

					<div class="col-xs-12 form-group" v-if="equipment.incontract">
						<label class="control-label">Состоит на обслуживании</label>
					</div>						
					
					<hr>
					
					<div class="col-xs-12 form-group" v-if="equipment.files.length>0">
						<label class="control-label">Фотографии</label>
													
						<div class="container">
							<div class="row">
								<div class="col-md-4 border" v-for="(image, index) in equipment.files">
									<img v-bind:src="image['pathFile']" class="img-thumbnail" v-if="image['pathFile'].length>0">
									<p v-on:click="equipment.files.splice(index, 1); filesDeleteID.push(image['id'])">X</p>
								</div>
							</div>
						</div>
					</div>

					<hr>
					
					<div class="col-xs-12 form-group" v-if="equipment.owner_type == 'App\\Company'">
						<div class="control-label">Владелец</div>
						<div class="form-control" v-if="equipment.owner">Компания: {{ equipment.owner.name }}</div>
					</div>
					<div class="col-xs-12 form-group" v-if="equipment.owner_type == 'App\\Department'">
						<div class="control-label">Владелец</div>
						<div class="form-control" v-if="equipment.owner">Компания: {{ equipment.owner.company.name }}</div>
						<div class="form-control" v-if="equipment.owner">Подразделение: {{ equipment.owner.name }}</div>
					</div>
					<div class="col-xs-12 form-group" v-if="equipment.owner_type == 'App\\Person'">
						<div class="control-label">Владелец</div>
						<div class="form-control" v-if="equipment.owner">Частное лицо: {{ equipment.owner.name }} {{ equipment.owner.surname }} {{ equipment.owner.patronymic }}</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</template>
 
<script>
	export default {
		data: function () {
			return {
				equipmentID: null,
				equipment: {
					type: '',
					model: '',
					modification: '',
					manufacturer: '',
					sernumber: '',
					datemanuf: null,
					invnumber: '',
					voltage: '',
					current: '',
					power: '',
					weight: '',
					sizes: '',
					manufсountry: '',
					note: '',
					incontract: false,
					companies: null,
					departments: null,
					person: null,
					files: [], //список файлов на сервере- при удалении их ID добавляются в filesDeleteID
					owner_type: null,
					owner: null
				}
			}
		},
		mounted() {
			let app = this;
			let id = app.$route.params.id;
			app.equipmentID = id;
			axios.get('/api/v1/equipments/' + id + '/edit')
				.then(function (resp) {
					app.equipment = resp.data.equipment;
					console.log(app.equipment);
				})
			 .catch(function () {
				 alert("Не удалось загрузить данные")
			  });
		},
		methods: {		
		}
	}
</script>