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
		props: ['nameProps', 'labelProps', 'inputTextProps', 'errorsProps'],   
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
			if(app.inputTextProps) app.inputText = app.inputTextProps;
			if(app.labelProps) app.label = app.labelProps;
			if(app.errorsProps) app.errors = app.errorsProps;

        }  
    }
</script>  