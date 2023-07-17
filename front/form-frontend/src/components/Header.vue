<template>
    <b-container class="bv-example-row text-center mt-5">
      <h1>{{ msg }}</h1>
    </b-container>
</template>

<script>
export default {
  name: 'HeaderContainer',
  props: {
    msg: String
  }
}
</script>

<style scoped>

</style>
