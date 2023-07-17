export const validateForm = {
    methods: {
        validateEmail(email) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        },
        validatePassword(password, repeatPassword){
            return password === repeatPassword
        }
    },
};