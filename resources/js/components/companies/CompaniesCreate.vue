<template>
	<div>
		<div class="form-group">
			<router-link to="/admin/companies/index" class="btn btn-default">Back</router-link>
		</div>
		
		<div class="panel panel-default">
			<div class="panel-heading">Create new company</div>
			<div class="panel-body">
				<form v-on:submit="saveForm()">
						
						<p v-if="haveerrors">
						
						</p>
						
						<div class="col-xs-12 form-group">
							<label class="control-label">Company name</label>
							<input type="text" v-model="company.name" class="form-control">
						</div>

						<div class="col-xs-12 form-group">
							<label class="control-label">Company address</label>
							<input type="text" v-model="company.address" class="form-control">
						</div>

						<div class="col-xs-12 form-group">
							<label class="control-label">Director</label>
							<input type="text" v-model="company.director" class="form-control">
						</div>						
						
						<div class="col-xs-12 form-group">
							<label class="control-label">Company website</label>
							<input type="text" v-model="company.website" class="form-control">
						</div>

						<div class="col-xs-12 form-group">
							<label class="control-label">Company email</label>
							<input type="text" v-model="company.email" class="form-control">
						</div>

						<div class="col-xs-12 form-group">
							<button class="btn btn-success">Create</button>
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
				company: {
					name: '',
					address: '',
					website: '',
					email: '',
				},
				errors: null
			}
		},
		methods: {
			saveForm() {
				event.preventDefault();
				var app = this;
				var newCompany = app.company;
				axios.post('/api/v1/companies', newCompany)
					.then(function (resp) {
						app.$router.push({path: '/admin/companies/index'});
					})
					.catch(function (resp) {
						//alert("Не удалось создать компанию");
						console.log(resp.request.responseText);
						console.log(resp.toJSON());
					});
			}
		}
	}
</script>