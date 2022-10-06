<template>
   <section id="posts-list">
      <h2>Posts</h2>
      <div v-if="posts.length">
        <PostCard v-for="post in posts" :key="post.id"
        :post="post" /> 
      </div>
      <h5 v-else>nessun post</h5>
   </section>
</template>

<script>

import PostCard from './PostCard.vue';

  export default{
    name: "PostsList",
    components: { PostCard },
    data() {
        return { 
            posts: [], 
        };
    },
    methods: {
        fetchPosts() {
            axios
                .get("http://localhost:8000/api/posts")
                .then((res) => {
                this.posts = res.data;
            })
                .catch((err) => {
                console.error(err);
            })
                .then(() => {
                console.info("chiamata terminata");
            });
        },
    },
    mounted() {
        this.fetchPosts();
    },
   
};
</script>

