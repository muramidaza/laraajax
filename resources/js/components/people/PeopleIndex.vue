<template>
	<div>
	 <div class="form-group">
	  <router-link :to="{name: 'createPeople'}" class="btn btn-success">Create new people</router-link>
	 </div>
	
	 <div class="panel panel-default">
	  <div class="panel-heading">People list</div>
	  <div class="panel-body">
	   <table class="table table-bordered table-striped">
	    <thead>
	     <tr>
	      <th>Name</th>
	      <th>Address</th>

	      <th width="100">&nbsp;</th>
	     </tr>
	    </thead>
	    <tbody>
	    <tr v-for="people, index in peoples">
	      <td>{{ people.name }}</td>
	      <td>{{ people.address }}</td>

	    <td>
	    <router-link :to="{name: 'editPeople', params: {id: people.id}}" class="btn btn-xs btn-default">
	     Edit
	   </router-link>
	    <a href="#"
	      class="btn btn-xs btn-danger"
	      v-on:click="deleteEntry(people.id, index)">
	      Delete
	     </a>
	    </td>
	    </tr>
	   </tbody>
	  </table>
	</div>
	</div>
	</div>
</template>
	
<script>
	export default {
	data: function () {
	   return {
	     people: []
	   }
	   },
	mounted() {
	   var app = this;
	   axios.get('/api/v1/people')
	   .then(function (resp) {
	   app.people = resp.data.people;
	})
	.catch(function (resp) {
	   console.log(resp);
	   alert("Не удалось загрузить людей");
	});
	},
	methods: {
	  deleteEntry(id, index) {
	  if (confirm("Вы действительно хотите удалить человека?")) {
	    var app = this;
	    axios.delete('/api/v1/people/' + id)
	    .then(function (resp) {
	    app.peoples.splice(index, 1);
	})
	.catch(function (resp) {
	   alert("Не удалось удалить человека");
	});
	}
	}
	}
	}
</script>