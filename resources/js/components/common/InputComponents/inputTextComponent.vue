<template>
	<div class="col-xs-12 form-group">
		<label class="control-label">{{labelProps ? labelProps : ''}}</label>
		<input type="text" v-model="inputText" class="form-control" @change="$emit('onChange', {key: nameProps, payload: inputText})" v-if="!readOnly">
		<div class="form-control"  v-if="readOnly">{{inputText}}</div>
		<ul v-if="errorsProps && errorsProps.length > 0" class="alert-danger">
			<li v-for="error in errors">{{error}}</li>
		</ul>
	</div>
</template>

<script>
	export default {
		props: ['nameProps', 'labelProps', 'inputTextProps', 'errorsProps', 'readOnly'],   
		data() {
			return {
				inputText: ''
			}
        },
        mounted() {
			const app = this;			
			if(app.inputTextProps) app.inputText = app.inputTextProps;
        }  
    }
</script>  