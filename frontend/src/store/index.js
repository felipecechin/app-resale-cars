import {createStore} from 'vuex'
import axios from "axios";

export default createStore({
    state: {
        user: null
    },
    mutations: {
        setUser(state, user) {
            state.user = user
        }
    },
    actions: {},
    modules: {}
})
