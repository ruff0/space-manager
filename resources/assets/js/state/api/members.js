import Vue from 'vue'


export default {
	getAll: (params , done, error) => {
		return Vue.http
			.get('/api/members', {params: params})
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
}


