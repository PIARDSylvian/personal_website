<template>
<div class="my-3 mx-3">
	<div v-if="isLoading" class="disabled d-flex justify-content-center align-items-center mt-4 vh-100">
		<span class="spinner-border" role="status"></span>
	</div>
	<div v-else-if="hasError" class="disabled mt-4">
		<div class="alert alert-danger" role="alert">
			{{ error }}
		</div>
	</div>
	<div v-if='check && data_post' class="row">
		<div class="col bg-white text-secondary post" :class="data_post.category.color">
			<h1 class="text-center display-6 fw-bold py-5">{{data_post.title}}</h1>
			<img v-if="data_post.image" :src="data_post.image" class="img-fluid mx-auto d-block pb-5" :alt="data_post.title" />
			<div class="col-xs-12 mx-auto col-md-10 mb-5 text-justify">
				<p><strong>Crée le</strong> <em>{{data_post.created_at | dateFormat}}</em><span v-if="data_post.updated_at"><br /><strong>Mis à jour le</strong> <em>{{data_post.updated_at | dateFormat}}</em></span></p>
				<p class="lead" v-html="data_post.content"></p>
			</div>
		</div>
	</div>
</div>
</template>

<script>
import moment from 'moment';
moment.locale('fr');

export default {
	name: "Post",
	data () {
		return {
			data_post: null
		}
	},
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
	computed: {
		isLoading() {
			return this.$store.getters["post/isLoading"];
		},
		hasError() {
			return this.$store.getters["post/hasError"];
		},
		error() {
			return this.$store.getters["post/error"];
		},
		check() {
			this.$nextTick(() => {
				if(this.$props.post === null) {
					this.$store.dispatch("post/getPost", this.$route.params.slug).then((values) => {
						if (!values || values.category.slug !==  this.$route.params.category) {
							this.$router.push({name: 'category', params: {category: this.$route.params.category}}) // TODO 404 NOT FOUND
						} else {
							this.$data.data_post = values
						}
					})
				} else {
					this.$data.data_post = this.$props.post
				}
			})
			return true
		}
	},
	filters : {
		dateFormat( $date ) {
			return moment(String($date)).format('lll');
		}
	}
};
</script>