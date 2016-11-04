import Vue from 'vue'


export default {
	store: (params, done, error) => {
		return Vue.http
			.post('/api/events', params)
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


