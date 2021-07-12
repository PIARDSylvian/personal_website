<template>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <router-link
                    class="navbar-brand"
                    to="/home"
                >
                    App
                </router-link>
                <button
                    class="navbar-toggler"
                    type="button"
                    data-toggle="collapse"
                    data-bs-toggle="collapse"
                    data-target="#navbarNav"
                    data-bs-target="#navbarNav"
                    aria-controls="navbarNav"
                    aria-bs-controls="navbarNav"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
                    <span class="navbar-toggler-icon" />
                </button>
                <div
                    id="navbarNav"
                    class="collapse navbar-collapse"
                >
                    <ul class="navbar-nav">
                        <router-link
                            class="nav-item"
                            tag="li"
                            to="/home"
                            active-class="active"
                        >
                            <a class="nav-link">Home</a>
                        </router-link>
                        <router-link
                            class="nav-item"
                            tag="li"
                            to="/test"
                        >
                            <a class="nav-link">test</a>
                        </router-link>
                    </ul>
                </div>
            </div>
        </nav>

        <router-view />
    </div>
</template>

<script>
  export default {
    name: "App",
  }
</script>