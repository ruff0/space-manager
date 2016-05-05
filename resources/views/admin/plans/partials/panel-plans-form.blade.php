<div class="panel panel-white">
	<div class="panel-heading">
		<h6 class="panel-title">
			<a data-toggle="collapse" href="#collapse-group1">Subscripción</a>
		</h6>
	</div>
	<div id="collapse-group1" class="panel-collapse collapse in">
		<div class="panel-body">
			<label>Plan del usuario</label>
			@inject('plans', 'App\Space\Plan')
			<select name="plan_id" data-placeholder="Selecciona el plan" class="select">
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
</div>