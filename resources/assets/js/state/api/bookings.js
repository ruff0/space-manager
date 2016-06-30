import Vue from 'vue'


export default {
	getAll: (params , done, error) => {
		return Vue.http
			.get('/api/bookings', {params: params})
			.then(
				(response) => {
					const data = response.json()
					done(data.available.concat(data.notavailable))
				},
				(response) => {
					if (response.status == 422) {
						error(response.data)
					}
				}
			)
	},

	calculate: (params , done, error) => {
		return Vue.http
			.post('/api/bookings/calculate', params)
			.then(
				(response) => {
					done(response.json())
				},
				(response) => {
					if (response.status == 422) {
						error(response.data)
					}
				}
			)
	},

	store: (params , done, error) => {
		return Vue.http
			.post('/api/bookings', params)
			.then(
				(response) => {
					done(response.json())
				},
				(response) => {
					if (response.status == 422 || response.status == 404 || response.status == 500) {
						error(response.data)
					}
				}
			)
	}
}


