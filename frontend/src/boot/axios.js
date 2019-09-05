import axios from 'axios'

export default async ({ Vue }) => {
  axios.defaults.baseURL = process.env.API_URL
  axios.defaults.headers = {
    'Content-Type': 'application/ld+json',
    'Accept': 'application/ld+json'
  }
  Vue.prototype.$axios = axios
}
