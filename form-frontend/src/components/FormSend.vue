<template>
    <b-form class="col-md-6 mt-4" @submit="onSubmit">
        <div class="mb-4">
            <b-form-input 
              v-model="form.name" 
              placeholder="Ім'я"/>
        </div>
        <div class="mb-4">
            <b-form-input
              v-model="form.surname"
              placeholder="Прізвище"/>
        </div>
        <div class="mb-4">
            <b-form-input 
              v-model="form.email" 
              placeholder="Email"/>
        </div>
        <div class="mb-4">
            <b-form-input
              type="password"
              v-model="form.password" 
              placeholder="Пароль"/>
        </div>
        <div class="mb-4">
            <b-form-input
              type="password"
              v-model="form.repeatPassword" 
              placeholder="Підтвердження паролю"/>
        </div>
        <b-button 
            type="submit"
            variant="primary">Надіслати</b-button>
        
        <p class="error">{{ message }}</p>
    </b-form>
</template>

<script>
import { validateForm } from '../mixins/validateForm.js';
import axios from "axios"

export default {
    name: 'FormSend',
    mixins: [validateForm],
    props:{
        status: {
            type: Boolean, 
            required: true
        },
        updateNewStatus: { 
            type: Function, 
            required: true 
        }
    },
    data() {
        return {
            message: "",
            form:{
                name: '',
                surname: '',
                email: '',
                password: '',
                repeatPassword: ''
            }
        };
    },
    methods: {
        onSubmit(e) {
            e.preventDefault()
            const { name, surname, email, password, repeatPassword } = this.form
            if(!surname || !name || !password || !repeatPassword)
            {
                this.message = "Не введені усі дані"
                return
            }
            const checkEmail = validateForm.methods.validateEmail(email)
            if(!checkEmail)
            {
                this.message = "Введіть коректну пошту"
                return
            }
            const checkPassword = validateForm.methods.validatePassword(password,repeatPassword)
            if(!checkPassword)
            {
                this.message = "Паролі не збігаються"
                return
            }
            axios.post(process.env.VUE_APP_SERVICE_URL + "/create-user", this.form)
            .then(() => {
                this.message = ""
                this.$emit('updateNewStatus', true);
            }).catch(() => {
                this.message = "Користувач за поштою вже існує"
                return
            });
        },
    },
}
</script>

<style scoped>
    .error{
        color: red;
        font-weight: bold;
        margin-top: 20px;
    }
</style>