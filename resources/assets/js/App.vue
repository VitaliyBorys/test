<template>
    <div>
        <router-view></router-view>
    </div>

</template>

<script>
    export default {
        data() {
            return {
                notFound: false
            }
        },
    }
</script>
<style lang="scss">
    // Import Main styles for this application
    @import "../scss/style";
    @import "~vue-snotify/styles/material";
</style>