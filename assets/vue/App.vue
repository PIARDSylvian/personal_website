<template>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-12 col-sm-4 col-md-2 bg-light vh-col-sm-100">
                <router-link class="align-items-center mb-md-0 me-md-auto link-dark text-decoration-none" to="/">
                    <span class="fs-4">App</span>
                </router-link>
                <hr>
                <div class="d-flex">
                    <div class="form-group">
                        <input class="form-control input-sm" type="search" placeholder="Search" aria-label="Search">
                    </div>
                    <div class="form-group ms-1">
                        <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
                    </div>
                </div>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <router-link to="/" active-class="active" v-slot="{ href, navigate, isExactActive}" custom>
                        <li class="nav-item">
                            <a :href="href" @click="navigate" class="nav-link link-dark" :class="[isExactActive && 'active']">Home</a>
                        </li>
                    </router-link>

                    <li v-if="isLoading" class="nav-item disabled">
                        <div class="d-flex justify-content-center mt-4">
                            <span class="spinner-border" role="status"></span>
                        </div>
                    </li>

                    <li v-else-if="hasError" class="nav-item disabled mt-3">
                        <div class="alert alert-danger" role="alert">
                            {{ error }}
                        </div>
                    </li>

                    <router-link v-for="link in menu" v-else :key="link.name" :to="link.name|lowerCase" active-class="active" v-slot="{ navigate, isExactActive }" custom >
                        <li class="nav-item">
                            <a :href="'/'+link.name|lowerCase" @click="navigate" class="nav-link link-dark" :class="[isExactActive && 'active']">{{ link.name }}</a>
                        </li>
                    </router-link>
                </ul>
            </nav>
            <main class="col-12 col-sm-8 col-md-10">
                <router-view />
            </main>
        </div>
    </div>
</template>

<script>

export default {
    name: "App",
    computed: {
        isLoading() {
            return this.$store.getters["menu/isLoading"];
        },
        hasError() {
            return this.$store.getters["menu/hasError"];
        },
        error() {
            return this.$store.getters["menu/error"];
        },
        hasMenu() {
            return this.$store.getters["menu/hasMenu"];
        },
        menu() {
            return this.$store.getters["menu/menu"];
        }
    },
    filters : {
        lowerCase : function (value) {
            return value.replace(/\s/g, "").toLowerCase();
        }
    }
}
</script>