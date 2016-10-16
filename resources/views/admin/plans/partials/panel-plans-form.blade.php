<div class="panel panel-white">
	<div class="panel-heading">
		<h6 class="panel-title">
			<a data-toggle="collapse" href="#collapse-group1">Subscripción</a>
		</h6>
	</div>
	<div id="collapse-group1" class="panel-collapse collapse in">
		<div class="panel-body">
			<form action="#">
				<div class="row pb-20">
					<div class="col-sm-12">
						<label>Plan del usuario</label>
						@inject('plans', 'App\Space\Plan')
						<select id="plan_id" name="plan_id" data-value="{{$member->subscriptions->count() > 0 ? $member->subscriptions->first()->plan_id:0}}" data-placeholder="Selecciona el plan" class="select">
							<option></option>
							@foreach($plans->whereActive(true)->get() as $plan)
								<option value="{{$plan->id}}"
								        @if($member->onPlan($plan)) selected @endif
								>
									{{$plan->name}}
								</option>
							@endforeach
						</select>

					</div>
				</div>
				<button type="submit" class="btn btn-primary pull-right hidden" id="save-plan-change">Cambiar el plan</button>
			</form>
		</div>
	</div>
</div>