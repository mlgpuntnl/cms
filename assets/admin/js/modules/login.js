import $ from 'jquery'
import 'jquery-validation'
import { Api } from '../lib/api'

$(function () {
    const api = new Api()

    $('#login-form').validate()
    $('#login-form').on('submit', function (e) {
        e.preventDefault()
        if (!$(this).valid()) {
            return
        }
        const data = new FormData(this)
        api.post('admin/login', data).then(async (res) => {
            const response = await res.json()
            if (res.status === 200 && response.success) {
                window.location.pathname = response.goto ?? '/admin/'
                return
            }
            const errorMsg = err.error ?? 'Something went wrong'
            $(this).find('.errors').html(errorMsg)
        }).catch(err =>{
            const errorMsg = err.error ?? 'Something went wrong'
            $(this).find('.errors').html(errorMsg)
        })
    })
})