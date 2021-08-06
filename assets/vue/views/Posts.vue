<template>
<div class="row px-4">
	<h1 v-if="category" class="text-center">{{category.name}}</h1>
	<div v-if="isLoading" class="disabled d-flex justify-content-center align-items-center mt-4 vh-100">
		<span class="spinner-border" role="status"></span>
	</div>                          
	<div v-for="post in posts" v-else :key="post.id" class="col-12 col-sm-6 col-md-4">
		<div class="card m-4">
			<img v-if="post.image" :src="post.image" class="card-img-top" :alt="post.title">
			<div class="card-body">
				<h5 class="card-title">{{post.title}}</h5>
				<p class="card-text">{{post.content}}</p>
				<router-link :to="{name:'post', params: { category: post.category.slug, slug: post.slug }}" v-slot="{ href, navigate}" custom>
					<a :href="href" @click="navigate" class="btn btn-primary" :class="post.category.color">Lire</a>
				</router-link>
			</div>
		</div>
	</div>
	<button :disabled="isMore" v-if="category && !(isEnd[category.id] || isEnd[0])" v-on:click="more(posts, category.id)" type="button" class="btn btn-secondary">
		<span v-if="isMore" class="spinner-border" role="status"></span>
		<span v-else> More</span>
	</button>
</div>
</template>

<script>
export default {
	name: "Posts",
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