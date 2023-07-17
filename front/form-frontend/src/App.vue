<template>
  <div id="app">
    <Header msg="Заповніть будь-ласка форму"/>
    <b-container class="bv-example-row">
      <div v-if="!status" class="row justify-content-center">
        <FormSend
          :status="status" 
          @updateNewStatus="updateStatus"/>
      </div>
      <div class="mt-5 text-center" v-else>
        <h3>Інформація була надіслана. Дякуємо!</h3>
      </div>
    </b-container>
  </div>
</template>

<script>
import Header from './components/Header.vue'
import FormSend from "./components/FormSend.vue"
//import axios from 'axios'

export default {
  name: 'App',
  components: {
    Header,
    FormSend
  },
  data() {
    return {
      status: false,
    }
  },
  methods:{
    updateStatus(statusVal){
      this.status = statusVal
    }
  }
}
</script>

<style></style>
