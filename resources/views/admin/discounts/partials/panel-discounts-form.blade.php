<div class="panel panel-white">
	<discount :member="{{$entity->id}}"
	          :discounts="{{$entity->appliedDiscounts()}}"
	          token="{{csrf_token()}}"
	></discount>
</div>