<template>
  <div>
    <div class="row col">
      <h1>{{category.name}}</h1>
    </div>

    <div class="row col">
      <p>props route passed : {{category.id}} :: {{category.name}}</p>
    </div>

    <div v-if="isLoading" class="disabled d-flex justify-content-center mt-4">
        <span class="spinner-border" role="status"></span>
    </div>

    <div v-else-if="hasError" class="disabled mt-4">
        <div class="alert alert-danger" role="alert">
            {{ error }}
        </div>
    </div>

    <div v-for="post in posts" v-else :key="post.id">
        <p>{{post.id}}</p>
        <p>{{post.title}}</p>
        <p>{{post.content}}</p>
    </div>

  </div>
</template>

<script>
export default {
  name: "Home",
  props: {
    category: {
      type: Object,
      default: () => ({
        id: null,
        name: 'home'
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
    hasMenu() {
        return this.$store.getters["post/hasMenu"];
    },
    posts() {
        return this.$store.getters["post/posts"];
    }
  }
};
</script>