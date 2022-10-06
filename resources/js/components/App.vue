<template>
    <div class="content">
       <AppHeader :title="title"/> 
       <main class="container">
          <PostsList/>
       </main>
    </div>
</template>

<script>
    import AppHeader from './AppHeader.vue';
    import PostsList from './posts/PostsList.vue';
    export default {
    name: "App",
    data() {
        return {
            title: "Boolpress"
        };
    },
    components: { 
        AppHeader,
        PostsList 
    }
};
</script>