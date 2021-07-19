<template>
  <div>
    <div v-if="isLoading" class="disabled d-flex justify-content-center mt-4">
        <span class="spinner-border" role="status"></span>
    </div>

    <div v-else-if="hasError" class="disabled mt-4">
        <div class="alert alert-danger" role="alert">
            {{ error }}
        </div>
    </div>

    <div v-if='check && data_post' class="row col">
      <h1>{{data_post.title}}</h1>
      <p>{{data_post.slug}}</p>
      <p>{{data_post.content}}</p>
    </div>
  </div>
</template>

<script>
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
      if(this.$props.post === null) {
        this.$store.dispatch("post/getPost", this.$route.params.slug).then((values) => {
          if (values.length == 0) {
            this.$router.push({name: 'home'})
          } else {
            this.$data.data_post = values
          }
        })
      } else {
        this.$data.data_post = this.$props.post
      }
      return true
    }
  }
};
</script>