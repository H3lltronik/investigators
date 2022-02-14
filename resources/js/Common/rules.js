export const userForm = {
    name: [
        { required: true, message: 'Este campo es requerido', trigger: 'submit' },
    ],
    email: [
        { required: true, message: 'Este campo es requerido', trigger: 'submit' },
        { type: 'email', message: 'Ingrese un email valido', trigger: ['submit', 'change'] }
    ],
    password: [
        { required: true, message: 'Este campo es requerido', trigger: 'submit' },
    ],
}