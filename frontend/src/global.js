export const userKey = '_app_revenda_carros_user'
export const baseApiUrl = 'http://localhost:8000/api'

import {useToast} from "vue-toastification";

export function showErrors(errors) {
    const toast = useToast();
    if (errors && errors.response && errors.response.data) {
        const msg = errors.response.data.message;
        if (Array.isArray(msg)) {
            msg.reverse().forEach((element) => {
                toast.error(element)
            })
        } else {
            toast.error(msg)
        }
    } else {
        toast.error('Ocorreu algum erro')
    }
}

export default {baseApiUrl, userKey}
