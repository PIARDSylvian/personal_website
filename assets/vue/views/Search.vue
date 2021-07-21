<template>
  <div class="row px-4">
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
    <button :disabled="isMore" v-if="!isLoading && !isEnd && posts.length > 0" v-on:click="more(posts)" type="button" class="btn btn-secondary">
      <span v-if="isMore" class="spinner-border" role="status"></span>
      <span v-else> More</span>
    </button>
  </div>
</template>

<script>
export default {
  name: "Search",
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
        return this.$store.getters["search/posts"];
    },
    isEnd() {
      return this.$store.getters["search/isEnd"];
    }
  },
  methods: {
    more: function (posts) {
      this.$store.dispatch("search/getSearch", {more:true, offset:posts.length})
    }
  },
};
</script>