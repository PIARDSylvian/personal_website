<template>
<div>
	<h1 class="text-center d-none">Search</h1>
	<div v-if="isLoading" class="disabled d-flex justify-content-center align-items-center mt-4 vh-100">
		<span class="spinner-border" role="status"></span>
	</div>
	<div v-else-if="hasError" class="disabled">
		<div class="alert alert-danger" role="alert">{{ error }}</div>
	</div>
	<div v-else-if="posts.length === 0">
		<div class="alert alert-primary d-flex align-items-center" role="alert">
			<div><i class="bi bi-info-circle-fill"></i>Aucun résultat</div>
		</div>
	</div>
	<div id="masonry-grid">
		<Card :post="post" v-for="post in posts" :key="post.id"/>
	</div>
	<button :disabled="isMore" v-if="!isLoading && !isEnd && posts.length > 0" v-on:click="more(posts)" type="button" class="btn btn-secondary w-100 my-2">
		<span v-if="isMore" class="spinner-border" role="status"></span>
		<span v-else> More</span>
	</button>
</div>
</template>

<script>
import Card from "../components/card";
import Masonry from 'masonry-layout';

export default {
	name: "Search",
	components: {Card},
	computed: {
		isLoading() {
			return this.$store.getters["search/isLoading"];
		},
		isMore() {
			return this.$store.getters["search/isMore"];
		},
		hasError() {
			return this.$store.getters["search/hasError"];
		},
		error() {
			return this.$store.getters["search/error"];
		},
		posts() {
			let posts = this.$store.getters["search/posts"];
			if (posts.length === 0 && !this.isEnd && !this.hasError) {
				this.$store.dispatch("search/getSearch", {search:'', more:false});
			}

			this.$nextTick(() => {
				let container = document.querySelector('#masonry-grid');
				if (container && !this.isLoading) {
					new Masonry( container, {
						itemSelector: '.masonry-card',
						percentPosition: true
					}); 
				}
			});

			return posts;
		},
		isEnd() {
			return this.$store.getters["search/isEnd"];
		}
	},
	methods: {
		more: function (posts) {
			this.$store.dispatch("search/getSearch", {more:true, offset:posts.length})
		}
	}
};
</script>