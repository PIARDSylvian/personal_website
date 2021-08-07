<template>
<div class="col-12 col-md-4 masonry-card">
	<div class="card m-2 text-center text-secondary">
		<img v-if="post.image" :src="post.image" class="card-img-top" :alt="post.title">
		<div class="card-body">
			<router-link :to="{name:'post', params: { category: post.category.slug, slug: post.slug }}" v-slot="{ href, navigate}" custom>
				<h5 class="card-title">
					<a :href="href" @click="navigate" class="stretched-link text-decoration-none text-reset">{{post.title}}</a>
				</h5>
			</router-link>
			<p class="card-text">{{post.content}}</p>
		</div>
	</div>
</div>
</template>

<script>
export default {
	name: "Card",
    props: {
		post: {
		type: Object,
		default: () => ({
			id: null,
			slug: null,
			title: null,
			image: null,
			content: null
			})
		}
	},
};
</script>