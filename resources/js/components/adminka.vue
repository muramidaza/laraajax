<template>
	<div>
		<div class="form-group">
			<router-link :to="{name: 'indexCompanies'}" class="btn btn-success">Компании</router-link>
			<router-link :to="{name: 'indexPersons'}" class="btn btn-success">Частные лица</router-link>
			<router-link :to="{name: 'indexEquipments'}" class="btn btn-success">Оборудование</router-link>
			<hr>
			<router-link :to="{name: 'indexUsers'}" class="btn btn-success">Сотрудники</router-link>
			<hr>
			<router-link :to="{name: 'indexActs'}" class="btn btn-success">Заявки</router-link>
			<router-link :to="{name: 'indexSpares'}" class="btn btn-success">Запчасти</router-link>
		</div>
	</div>
</template>
	
<script>
</script>