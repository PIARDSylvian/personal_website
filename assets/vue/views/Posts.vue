<template>
<div class="my-2">
	<h1 v-if="category" class="text-center d-none">{{category.name}}</h1>
	<div v-if="isLoading" class="disabled d-flex justify-content-center align-items-center mt-4 vh-100">
		<span class="spinner-border" role="status"></span>
	</div>
	<div id="masonry-grid">
		<Card :post="post" v-for="post in posts" :key="post.id"/>
	</div>
	<div class="col-12 my-2 px-2">
		<button :disabled="isMore" v-if="category && !(isEnd[category.id] || isEnd[0])" v-on:click="more(posts, category.id)" type="button" class="btn btn-secondary w-100 fw-bold" :class="category.color">
			<span v-if="isMore" class="spinner-border" role="status"></span>
			<span v-else> More</span>
		</button>
	</div>
</div>
</template>

<script>
import Card from "../components/card";
import Masonry from 'masonry-layout';
import Imagesloaded from 'imagesloaded';

export default {
	name: "Posts",
	components: {Card},
	props: {
		category: {
			type: Object,
			default: () => ({
				id: null,
				name: 'Home',
				slug: null
			})
		}
	},
	computed: {
		isLoading() {
			return this.$store.getters["post/isLoading"];
		},
		isMore() {
			return this.$store.getters["post/isMore"];
		},
		isEnd() {
			return this.$store.getters["post/isEnd"];
		},
		posts() {
			let posts = null
			if (this.$props.category && this.$props.category.id != null) {
				posts = this.$store.getters["post/postsById"](this.$props.category.id)
			} else {
				posts = this.$store.getters["post/posts"]
			}
			if (this.$props.category && !(this.isEnd[this.$props.category.id] || this.isEnd[0]) && !this.isMore && !this.isLoading && posts.length === 0) {
				this.more([], this.$props.category.id)
			}

			this.$nextTick(() => {
				let container = document.querySelector('#masonry-grid');
				if (container && !this.isLoading) {
					const msnry = new Masonry( container, {
						itemSelector: '.masonry-card',
						percentPosition: true,
						transitionDuration: '0.1s'
					});

					new Imagesloaded(container,function() {
						msnry.layout();
					});
				}
			});

			return posts
		},
		isEnd() {
			return this.$store.getters["post/isEnd"];
		}
	},
	methods: {
		more: function (posts, category) {
			this.$store.dispatch("post/getPosts", {more:true, category:category, offset:posts.length, search:null})
		}
	}
};
</script>