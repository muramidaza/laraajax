<template>
	<div>
		<div class="form-group">
			<router-link to="/admin/departments/index" class="btn btn-success">Назад</router-link>
		</div>
		
		<div class="card">
			<div class="card-header">
				Просмотр записи об объекте
			</div>
			<div class="card-body" style="margin-left: 40px">
				<div>

						<div class="col-xs-12 form-group">
							<label class="control-label">Название объекта</label>
							<div class="form-control">{{ department.name }}</div>							
						</div>

						<div class="col-xs-12 form-group">
							<label class="control-label">Адрес объекта</label>
							<div class="form-control">{{ department.address }}</div>
						</div>
						
						<div class="col-xs-12 form-group">
							<label class="control-label">ФИО менеджера</label>
							<div class="form-control">{{ department.manager }}</div>
						</div>
						
						<div class="col-xs-12 form-group">
							<label class="control-label">Телефон 1</label>
							<div class="form-control">{{ department.phone1 }}</div>				
						</div>

						<div class="col-xs-12 form-group">
							<label class="control-label">Телефон 2</label>
							<div class="form-control">{{ department.phone2 }}</div>
						</div>	
						
						<div class="col-xs-12 form-group" v-if="department.company">
							<label class="control-label">Контрагент</label>
							<div class="form-control">{{ department.company.name }}</div>
						</div>

				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		mounted() {
			let app = this;
			let id = app.$route.params.id;
			app.departmentId = id;
			axios.get('/api/v1/departments/' + id)
				.then(function (resp) {
					app.department = resp.data.department;
					app.department.company = resp.data.company;
				})
				.catch(function () {
					alert("Не удалось загрузить отделы")
				});
		},
		data: function () {
			return {
				departmentId: null,
				department: {
					name: '',
					address: '',
					manager: '',
					phone1: '',
					phone2: '',
					company: null
				},
				errors: {
					name: null,
					manager: null,
					phone1: null
				}
			}
		},
		methods: {
			saveForm() {
				event.preventDefault();
				var app = this;
				var newDepartment = app.department;
				axios.patch('/api/v1/departments/' + app.departmentId, newDepartment)
					.then(function (resp) {
						app.$router.push({path: '/admin/departments/index'});
					})
					.catch(function (resp) {
						if(JSON.parse(resp.request.responseText).message == 'The given data was invalid.') app.errors = JSON.parse(resp.request.responseText).errors;						
					});
			}
		}
	}
</script>