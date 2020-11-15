<template>
	<div class="col-xs-12 form-group">
		<label class="control-label">{{label}}</label>
		<input type="text" v-model="inputText" class="form-control" @change="$emit('onChange', retObj = {key: name, payload: inputText})">
		<ul v-if="errors.length > 0" class="alert-danger">
			<li v-for="error in errors">{{error}}</li>
		</ul>
	</div>
</template>

<script>
	export default {
		props: ['nameProps', 'labelProps', 'listData', 'errorsProps'],   
		data() {
			return {
				inputText: '', 
				errors: [],
				name: null,
				label: '',
				retObj: {}
           }
        },
        mounted() {
			const app = this;

			app.name = app.nameProps;			
			if(app.listData.hasOwnProperty(app.name)) app.inputText = app.listData[app.name];
			if(app.labelProps) app.label = app.labelProps;
			if(app.errorsProps.hasOwnProperty(app.name)) app.errors = app.errorsProps[app.name];

        }  
    }
</script>  