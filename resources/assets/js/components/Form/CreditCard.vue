<template>
	<div>
		<div class="errors col-sm-12">
			<div class="alert alert-danger" v-if="errors.length > 0">
				<li>{{errors}}</li>
			</div>
		</div>

		<input type="hidden" name="stripe_token" v-model="token" id="stripe_token">

		<div class="form-group">
			<label for="card-number">Tarjeta de credito</label>
			<input class="form-control"
						 name="card"
						 type="text"
						 id="card"
						 placeholder="**** **** **** {{ placeholder }}" v-model="number">
		</div>

		<div class="form-group row">
			<div class="col-sm-3">
				<label for="card-expiry-month">Mes Exp.</label>
				<input class="form-control"
							 type="text"
							 id="card-expiry-month"
							 name="month"
							 placeholder="MM" v-model="month">
			</div>
			<div class="col-sm-3">
				<label for="card-expiry-year">Año Exp.</label>
				<input class="form-control"
							 type="text"
							 id="card-expiry-year"
							 name="year"
							 placeholder="YYYY" v-model="year">
			</div>
			<div class="col-sm-3">
				<label for="card-cvc">CVC</label>
				<input class="form-control"
							 type="text"
							 id="card-cvc"
							 name="cvc"
							 placeholder="CVC" v-model="cvc">
			</div>
			<div class="col-sm-3">
				<label>&nbsp;</label>
				<button type="button"
								:disabled="!!valid"
								class="btn btn-block {{valid ? 'btn-success' :'btn-info'}} btn-small {{disabled? 'disabled': ''}}"
								@click="stripeGenerateToken()"
				>
					{{valid ? 'Tarjeta valida' : 'Verificar Tarjeta'}}
				</button>
			</div>
		</div>
	</div>
</template>

<script>
	export default{
		name: "CreditCard",
		data(){
			return {
				errors: "",
				token: "",
				disabled: false,
				valid: false,
			}
		},
		props: {
			placeholder: {
				type: String,
				default: "****"
			},

			number: "",
			month: "",
			year: "",
			cvc: "",
		},
		ready: function () {
			if (this.number && this.month && this.year && this.cvc) {
				this.stripeGenerateToken()
				this.$dispatch('stripe::valid', this.valid)
			}
		},
		methods: {
			stripeResponseHandler(status, response) {
				if (response.error) {
					// show the errors on the form
					this.errors = response.error.message;
					this.disabled = false
					this.valid = false
				} else {
					this.errors = "";
					this.valid = true
					this.token = response['id'];
					this.$dispatch('stripe::token', this.token)
					this.$dispatch('stripe::valid', this.valid)
				}

				this.$dispatch('hide::spinner')
			},
			stripeGenerateToken(){
				this.disabled = true
				this.$dispatch('show::spinner')
				Stripe.createToken({
					number: this.number,
					cvc: this.cvc,
					exp_month: this.month,
					exp_year: this.year
				}, this.stripeResponseHandler);
			}
		}
	}

</script>
