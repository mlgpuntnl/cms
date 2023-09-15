
export class Api {

    constructor(baseUrl = undefined) {
        if (!baseUrl) {
            baseUrl = `${window.location.protocol}//${window.location.host}/`
        }
        this.baseUrl = baseUrl
    }

    async get(path, params = {}, headers = {}) {
        if (params) {
            path += '?' + (new URLSearchParams(params)).toString()
        }
        return this.request('GET', path, headers)
    }

    async delete(path, params = {}, headers = {}) {
        if (params) {
            path += '?' + (new URLSearchParams(params)).toString()
        }
        return this.request('DELETE', path, headers)
    }

    async post(path, body = {}, headers = {}) {
        return this.request('POST', path, headers, this.#parseBody(body))
    }

    async put(path, body = {}, headers = {}) {
        return this.request('PUT', path, headers, this.#parseBody(body))
    }

    async patch(path, body = {}, headers = {}) {
        return this.request('PATCH', path, headers, this.#parseBody(body))
    }

    /**
     * 
     * @param {string} method The request method
     * @param {string} path The request path
     * @param {object} headers An object filled with headers
     * @param {string|undefined} body The request body
     * @returns {Response} The Http fetch response
     * @see https://developer.mozilla.org/en-US/docs/Web/API/Response
     */
    async request(method, path, headers, body = undefined) {
        return await fetch(this.baseUrl + path, {
            method: method,
            meaders: headers,
            body: body
        })
    }

    #parseBody(body) {
        if (body instanceof FormData) {
            return body
        }
        return JSON.stringify(body)
    }
}
