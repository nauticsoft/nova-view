<template>
  <div>
    <Head :title="title" />
    <LoadingView :loading="loading" />
    <div v-html="tool"></div>
  </div>
</template>

<script setup>
import { onMounted, reactive } from 'vue';

const props = defineProps({ title: String, route: String, tool: String })

let loading = true;

onMounted(() => {
    Nova.request().get('/'+props.route).then((response) => {
        props.tool = response.data;
        loading = false;
    });
});
</script>

<style>
/* Scoped Styles */
</style>
