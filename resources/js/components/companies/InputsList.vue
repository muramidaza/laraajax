<template>
	<div   v-if="Object.keys(listData).length > 0">
		<InputTextComponent name-props='name' label-props='Название' v-bind:input-text-props='listData.name' v-bind:errors-props='errorsProps && errorsProps.name' v-on:onChange='handleChangeText' v-bind:read-only='readOnly'/>
		<InputTextComponent name-props='city' label-props='Город' v-bind:input-text-props='listData.city' v-bind:errors-props='errorsProps && errorsProps.city' v-on:onChange='handleChangeText' v-bind:read-only='readOnly'/>
		<InputTextComponent name-props='address' label-props='Физический адрес' v-bind:input-text-props='listData.address' v-bind:errors-props='errorsProps && errorsProps.address' v-on:onChange='handleChangeText' v-bind:read-only='readOnly'/>
		<InputTextComponent name-props='contract' label-props='Номер договора' v-bind:input-text-props='listData.contract' v-bind:errors-props='errorsProps && errorsProps.contract' v-on:onChange='handleChangeText' v-bind:read-only='readOnly'/>
		<InputTextComponent name-props='director' label-props='ФИО директора' v-bind:input-text-props='listData.director' v-bind:errors-props='errorsProps && errorsProps.director' v-on:onChange='handleChangeText' v-bind:read-only='readOnly'/>
		<InputTextComponent name-props='phone1' label-props='Телефон 1' v-bind:input-text-props='listData.phone1' v-bind:errors-props='errorsProps && errorsProps.phone1' v-on:onChange='handleChangeText' v-bind:read-only='readOnly'/>
		<InputTextComponent name-props='phone2' label-props='Телефон 2' v-bind:input-text-props='listData.phone2' v-bind:errors-props='errorsProps && errorsProps.phone2' v-on:onChange='handleChangeText' v-bind:read-only='readOnly'/>
		<InputTextComponent name-props='website' label-props='Сайт' v-bind:input-text-props='listData.website' v-bind:errors-props='errorsProps && errorsProps.website' v-on:onChange='handleChangeText' v-bind:read-only='readOnly'/>
		<InputTextComponent name-props='email' label-props='Е-майл' v-bind:input-text-props='listData.email' v-bind:errors-props='errorsProps && errorsProps.email' v-on:onChange='handleChangeText' v-bind:read-only='readOnly'/>
		
		<div class="card">
			<div class="card-header">
				<div v-on:click="toggle=!toggle" class="btn btn-link">{{ toggle? 'Скрыть реквизиты' : 'Показать реквизиты'}}</div>
			</div>
			
			<div class="card-body" v-if="toggle">
			
				<InputTextComponent name-props='UridAddress' label-props='Юридический адрес'v-bind:errors-props='errors' v-on:onChange='handleChangeText' v-bind:read-only='readOnly'/>
				<hr>
				<InputTextComponent name-props='OGRN' label-props='ОГРН' v-bind:input-text-props='listData.OGRN' v-bind:errors-props='errorsProps && errorsProps.OGRN' v-on:onChange='handleChangeText' v-bind:read-only='readOnly'/>
				<InputTextComponent name-props='INN' label-props='ИНН' v-bind:input-text-props='listData.INN' v-bind:errors-props='errorsProps && errorsProps.INN' v-on:onChange='handleChangeText' v-bind:read-only='readOnly'/>
				<InputTextComponent name-props='KPP' label-props='КПП' v-bind:input-text-props='listData.KPP' v-bind:errors-props='errorsProps && errorsProps.KPP' v-on:onChange='handleChangeText' v-bind:read-only='readOnly'/>
				<InputTextComponent name-props='OKPO' label-props='ОКПО' v-bind:input-text-props='listData.OKPO' v-bind:errors-props='errorsProps && errorsProps.OKPO' v-on:onChange='handleChangeText' v-bind:read-only='readOnly'/>
				<InputTextComponent name-props='OKVED' label-props='ОКВЭД' v-bind:input-text-props='listData.OKVED' v-bind:errors-props='errorsProps && errorsProps.OKVED' v-on:onChange='handleChangeText' v-bind:read-only='readOnly'/>
				<InputTextComponent name-props='RSchet' label-props='Расчетный счет' v-bind:input-text-props='listData.RSchet' v-bind:errors-props='errorsProps && errorsProps.RSchet' v-on:onChange='handleChangeText' v-bind:read-only='readOnly'/>
				<InputTextComponent name-props='KSchet' label-props='Корр. счет' v-bind:input-text-props='listData.KSchet' v-bind:errors-props='errorsProps && errorsProps.KSchet' v-on:onChange='handleChangeText' v-bind:read-only='readOnly'/>
				<InputTextComponent name-props='BIK' label-props='БИК' v-bind:input-text-props='listData.BIK' v-bind:errors-props='errorsProps && errorsProps.BIK' v-on:onChange='handleChangeText' v-bind:read-only='readOnly'/>
				
			</div>
		</div>
	</div>
</template>

<script>
	import InputTextComponent from '../Common/InputComponents/InputTextComponent';

	export default {
		props: ['listDataProps', 'errorsProps', 'readOnly'],   
		data: function () {
			return {
				listData: {
				},
				toggle: false
			}
		},
		components: {
			InputTextComponent
		},
        mounted() {
			const app = this;
			if(app.listDataProps) app.listData = app.listDataProps;
        },
		methods: {
			handleChangeText(retObj) {
				this.$emit('onChangeData', retObj);
			}
		}
    }
</script>