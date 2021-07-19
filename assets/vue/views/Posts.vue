<template>
  <div class="row px-4">
    <h1 class="text-center">{{category.name}}</h1>
    <div v-if="isLoading" class="disabled d-flex justify-content-center mt-4">
        <span class="spinner-border" role="status"></span>
    </div>

    <div v-else-if="hasError" class="disabled mt-4">
        <div class="alert alert-danger" role="alert">
            {{ error }}
        </div>
    </div>                            
    <div v-for="post in posts" v-else :key="post.id" class="col-12	col-sm-6 col-md-4">
      <div class="card m-4">
        <img v-if="post.image" :src="post.image" class="card-img-top" :alt="post.title">
          <div class="card-body">
            <h5 class="card-title">{{post.title}}</h5>
            <p class="card-text">{{post.content}}</p>
            <router-link :to="{name: (post.category.name + '/post'), params: { slug: post.slug }}" v-slot="{ href, navigate}" custom>
              <a :href="href" @click="navigate" class="btn btn-primary">Lire</a>
            </router-link>
          </div>
      </div>
    </div>
    <button :disabled="loading" v-if="!(isEnd[category.id] || isEnd[0])" v-on:click="more(posts, category.id)" type="button" class="btn btn-secondary">More</button>
  </div>
</template>

<script>
export default {
  name: "Posts",
  data () {
    return {
      loading: false
    }
  },
  props: {
    category: {
      type: Object,
      default: () => ({
        id: null,
        name: 'home',
        url: 'home'
      })
    },
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
    posts() {
		if (this.$props.category.id != null) {
			return this.$store.getters["post/postsById"](this.$props.category.id)
		} else {
			return this.$store.getters["post/posts"]
		}
    },
    isEnd() {
      return this.$store.getters["post/isEnd"];
    }
  },
  methods: {
    more: function (posts, category) {
		this.loading = true
		this.$store.dispatch("post/getPosts", {more:true, category:category, offset:posts.length, search:null}).finally(() => {
			this.loading = false
      	})
    }
  },
  filters: {
    url: function (value) {
      if (!value) return ''
      return value.replace(/\s/g, "").toLowerCase();
    }
  }
};
</script>