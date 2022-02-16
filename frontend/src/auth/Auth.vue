<template>
    <b-col></b-col>
    <b-col sm="12" md="6">
        <b-card title="Card Title" no-body class="mt-2">
            <b-card-header>
                {{ register ? 'Cadastro' : 'Login' }}
            </b-card-header>
            <b-card-body>
                <b-form>

                    <b-form-group v-if="register"
                                  label="Nome:">
                        <b-form-input
                            v-model="user.name"
                            type="text"
                            required
                        ></b-form-input>
                    </b-form-group>
                    <b-form-group
                        label="E-mail:">
                        <b-form-input
                            v-model="user.email"
                            type="email"
                            required
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group
                        label="Senha:">
                        <b-form-input
                            v-model="user.password"
                            type="password"
                            required
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group
                        v-if="register"
                        label="Confirme a senha:">
                        <b-form-input
                            v-model="user.password_confirmation"
                            type="password"
                            required
                        ></b-form-input>
                    </b-form-group>


                    <b-button type="submit" variant="primary">Submit</b-button>
                    <b-button type="reset" variant="danger">Reset</b-button>
                </b-form>
            </b-card-body>
            <b-card-footer class="d-flex justify-content-between">
                <a href @click.prevent="register = !register">
                    <span v-if="register">Já tem cadastro? Acesse o Login!</span>
                    <span v-else>Não tem cadastro? Registre-se aqui!</span>
                </a>
                <button v-if="register" @click="signup">Registrar</button>
                <button v-else @click="signin">Entrar</button>
            </b-card-footer>
        </b-card>
    </b-col>
    <b-col></b-col>
</template>

<script>
    import {baseApiUrl, userKey} from '@/global'
    import axios from 'axios'

    export default {
        name: 'Auth',
        data: function () {
            return {
                register: false,
                user: {}
            }
        },
        methods: {
            signin() {
                axios.post(`${baseApiUrl}/login`, this.user)
                    .then(res => {
                        this.$store.commit('setUser', res.data)
                        localStorage.setItem(userKey, JSON.stringify(res.data))
                        this.$router.push({path: '/'})
                    })
                    .catch((e) => {
                        console.log(e)
                    })
            },
            signup() {
                axios.post(`${baseApiUrl}/register`, this.user)
                    .then((res) => {
                        console.log(res)
                        this.user = {}
                        this.showSignup = false
                    })
                    .catch((e) => {
                        console.log(e)
                    })
            }
        }
    }
</script>

<style>
    .auth-content {
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .auth-modal {
        background-color: #FFF;
        width: 350px;
        padding: 35px;
        box-shadow: 0 1px 5px rgba(0, 0, 0, 0.15);

        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .auth-title {
        font-size: 1.2rem;
        font-weight: 100;
        margin-top: 10px;
        margin-bottom: 15px;
    }

    .auth-modal input {
        border: 1px solid #BBB;
        width: 100%;
        margin-bottom: 15px;
        padding: 3px 8px;
        outline: none;
    }

    .auth-modal button {
        align-self: flex-end;
        background-color: #2460ae;
        color: #FFF;
        padding: 5px 15px;
    }

    .auth-modal a {
        margin-top: 35px;
    }

    .auth-modal hr {
        border: 0;
        width: 100%;
        height: 1px;
        background-image: linear-gradient(to right,
        rgba(120, 120, 120, 0),
        rgba(120, 120, 120, 0.75),
        rgba(120, 120, 120, 0));
    }
</style>
