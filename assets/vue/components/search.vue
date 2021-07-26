<template>
<form @submit="search">
	<div class="input-group">
		<input type="text" class="form-control" placeholder="search" aria-label="Search" aria-describedby="search" v-model="query">
		<button class="btn btn-outline-secondary" type="submit" value="Submit" id="button-addon1"><i class="bi bi-search"></i></button>
	</div>
</form>
</template>

<script>
export default {
	name: "Search",
	data () {
		return {
			query: null
		}
	},
	methods: {
		search: function (e) {
			e.preventDefault();
			if (this.$route.name != 'search') {
				this.$router.push({name :'search'});
			}
			this.$store.dispatch("search/getSearch", {search:this.query, more:false});
		}
	}
};
</script>