<template>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-12 col-sm-4 col-md-2 bg-light vh-col-sm-100">
                <router-link class="align-items-center mb-md-0 me-md-auto link-dark text-decoration-none" to="/home">
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
                    <router-link to="home" active-class="active" v-slot="{ navigate, isActive, isExactActive }" custom>
                        <li class="nav-item" :class="[isActive && 'router-link-active', isExactActive && 'router-link-exact-active']">
                            <a href="/home" @click="navigate" class="nav-link link-dark" :class="[isActive && 'active', isExactActive && 'active']">home</a>
                        </li>
                    </router-link>

                    <li v-if="isLoading" class="nav-item">
                        <span v-if="isLoading" class="nav-link navbar-text link-dark text-decoration-none">Loading...</span>
                    </li>

                    <li v-else-if="hasError" class="nav-item">
                        <p class="alert alert-danger nav-link" role="alert">{{ error }}</p>
                    </li>

                    <router-link v-for="link in menu" v-else :key="link" :to="link" active-class="active" v-slot="{ navigate, isActive, isExactActive }" custom >
                        <li class="nav-item" :class="[isActive && 'router-link-active', isExactActive && 'router-link-exact-active']">
                            <a :href="'/'+link" @click="navigate" class="nav-link link-dark" :class="[isActive && 'active', isExactActive && 'active']">{{ link }}</a>
                        </li>
                    </router-link>

                    <router-link to="test" active-class="active" v-slot="{ navigate, isActive, isExactActive }" custom>
                        <li class="nav-item" :class="[isActive && 'router-link-active', isExactActive && 'router-link-exact-active']">
                            <a href="/test" @click="navigate" class="nav-link link-dark" :class="[isActive && 'active', isExactActive && 'active']">test</a>
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

import Test from "./views/Test";
import router from "./router/index";

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
            let menu = this.$store.getters["menu/menu"];
            menu.forEach(link => { 
                router.addRoute({ path: '/'+link, name: link, component: Test }) 
            })
            return menu
        }
    },
    created() {
        this.$store.dispatch("menu/getMenu");
    }
}
</script>