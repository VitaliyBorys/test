<template>
    <div>
        <vue-snotify></vue-snotify>
        <header>
            <!-- Fixed navbar -->
            <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
                <a class="navbar-brand" href="/">Test</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
                        aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <router-link :to="{name : 'profile'}" class="nav-link">Мой профиль</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="{name : 'lottery'}" class="nav-link">Лотерея</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="{name : 'logout'}" class="nav-link">Выйти</router-link>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <!-- Begin page content -->
        <main role="main" class="container">
          <router-view></router-view>
        </main>
    </div>
</template>

<script>
    import URI from 'urijs'

    export default {

    }
</script>

<style>


    /* Custom page CSS
    -------------------------------------------------- */
    /* Not required for template or sticky footer method. */

    .container {
        padding: 60px 15px 0;
    }

   .router-link-exact-active{
        color: #e75151 !important;
    }


</style>
