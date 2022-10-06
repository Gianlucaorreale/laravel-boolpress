<template>

<div class="card mb-3">
  <div class="card-body">
    <h5 class="card-title">{{post.title}}</h5>
    <h6 class="card-subtitle mb-2 text-muted"> Post creato il:{{publishedAt}}</h6>
    <p class="card-text">{{post.content}}</p>
   <!-- <a href="#" class="card-link">Card link</a>
    <a href="#" class="card-link">Another link</a>-->
  </div>
</div>

</template>

<script>
    export default{
       name:'PostCard',
       props: {
        post: Object,
       },
       computed:{
        publishedAt(){
          const postDate = new Date(this.post.created_at);
          let day = postDate.getDate();
          let month = postDate.getMonth();
          let year = postDate.getFullYear();

          return `${day}/${month}/${year}`;
        }
       }
    }
</script>

<style>

</style>