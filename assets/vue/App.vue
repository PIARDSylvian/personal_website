<template>
<div class="container-fluid">
    <div class="row">
        <nav class="col-12 col-sm-4 col-md-3 col-lg-2 navbar-expand-sm navbar-light bg-light">
            <router-link class="d-flex justify-content-center img-fluid" to="/">
                <img :src="'/build/logo-sp-min.png'" class="img-fluid my-2" alt="logo">
            </router-link>
            <div class="d-flex justify-content-between">
                <div class="col-8 col-sm-12">
                    <Search />
                </div>
                <button class="col-md navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <hr>
            <ul class="nav nav-pills flex-column mb-2 collapse navbar-collapse align-items-stretch fw-bold" id="navbarSupportedContent">
                <router-link to="/" active-class="active" v-slot="{ href, navigate, isExactActive}" custom>
                    <li class="nav-item">
                        <a :href="href" v-on="{ click: [navigate, closeMenu] }" class="nav-link gray" :class="[isExactActive && 'active']"><i class="bi bi-house-fill me-2 text-secondary"></i>Home</a>
                    </li>
                </router-link>
                <li v-if="hasError" class="nav-item disabled mt-3">
                    <div class="alert alert-danger" role="alert">
                        {{ error }}
                    </div>
                </li>
                <li v-else-if="isLoading || !isPopulated" class="nav-item disabled">
                    <div class="d-flex justify-content-center mt-4">
                        <span class="spinner-border" role="status"></span>
                    </div>
                </li>
                <router-link v-for="link in menu" v-else :key="link.id" :to="{name:'category', params: {category: link.slug}}" active-class="active" v-slot="{href,navigate, isActive, isExactActive }" custom >
                    <li class="nav-item">
                        <a :href="href" v-on="{ click: [navigate, closeMenu] }" class="nav-link" :class="[isActive && 'active' ,isExactActive && 'active', link.color]"><i class="bi bi-circle-fill me-2" :class="[!isActive && link.color]"></i>{{ link.name }}</a>
                    </li>
                </router-link>
            </ul>
        </nav>
        <main v-if="!isLoading && !hasError" class="col-12 col-sm-8 col-md-9 col-lg-10">
            <router-view />
            <button id="scroll-btn" class="btn btn-secondary fixed-bottom me-5 mb-5 float-right d-none" v-on:click="scrollToTop"><i class="bi bi-chevron-up"></i></button>
        </main>
    </div>
</div>
</template>

<script>

import Search from "./components/search";

export default {
    name: "App",
    components: {Search},
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
        },
        isPopulated() {
            return this.$store.getters["menu/isPopulated"];
        }
    },
    created: function () {
        window.addEventListener('scroll', this.handleScroll);
    },
    destroyed: function () {
        window.removeEventListener('scroll', this.handleScroll);
    },
    methods: {
        closeMenu: function () {
            document.body.querySelector("#navbarSupportedContent").classList.remove("show")
        },
        handleScroll: function () {
            if (window.scrollY > 100) {
                document.body.querySelector("#scroll-btn").classList.remove("d-none")
            } else {
                document.body.querySelector("#scroll-btn").classList.add("d-none")
            }
        },
        scrollToTop: function () {
            window.scrollTo(0,0);
        }

    }
}
</script>