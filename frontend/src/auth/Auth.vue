<template>
    <b-row>
        <b-col></b-col>
        <b-col sm="12" md="6">
            <b-card title="Card Title" no-body class="mt-2">
                <b-form @submit="register ? signup : signin">
                    <b-card-header>
                        {{ register ? 'Cadastro' : 'Login' }}
                    </b-card-header>
                    <b-card-body>

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


                    </b-card-body>
                    <b-card-footer class="d-flex justify-content-between">
                        <a href @click.prevent="register = !register" class="nav-link">
                            <span v-if="register">Já tem cadastro? Faça login!</span>
                            <span v-else>Não tem cadastro? Registre-se aqui!</span>
                        </a>
                        <b-button type="submit" variant="primary" v-if="register" @click="signup">Registrar</b-button>
                        <b-button type="submit" variant="primary" v-else @click="signin">Entrar</b-button>
                    </b-card-footer>
                </b-form>
            </b-card>
        </b-col>
        <b-col></b-col>
    </b-row>
</template>

<script>
    import {userKey, showErrors} from '@/global'
    import {useToast} from "vue-toastification";
    import api from "@/api";

    export default {
        setup() {
            const toast = useToast();
            return {toast};
        },
        name: 'Auth',
        data() {
            return {
                register: false,
                user: {}
            }
        },
        methods: {
            signin() {
                api.post(`/auth/login`, this.user)
                    .then(res => {
                        this.toast.success("Login efetuado com sucesso");
                        this.$store.commit('setUser', res.data)
                        localStorage.setItem(userKey, JSON.stringify(res.data))
                        this.$router.push({path: '/'})
                    })
                    .catch((e) => {
                        showErrors(e)
                    })
            },
            signup() {
                api.post(`/auth/register`, this.user)
                    .then((res) => {
                        this.toast.success(res.data.message);
                        this.user = {}
                        this.register = false
                    })
                    .catch((e) => {
                        showErrors(e)
                    })
            }
        }
    }
</script>

<style>

</style>
