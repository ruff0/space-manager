<template>
	<div class="Calendar">
		<div class="Calendar--List">
		</div>
		<div class="Calendar--Calendar">
			<div id="scheduler"></div>
		</div>
	</div>

</template>

<script>

export default {
	name: "Scheduler",
	data(){
		return {

		}
	},
	props : {
		bookables : [],
		events : [],
		resources : [],
	},
	watch : {
		resources(){
		}
	},
	ready(){
		var me = this;
		$('#scheduler').fullCalendar({
		 	dayClick: function(date, jsEvent, view) {
		 		if(view.name == 'month')
		 		{
		 			$('#scheduler').fullCalendar( 'changeView', "timelineDay" )
		 			$('#scheduler').fullCalendar( 'gotoDate', date )
		 		}
    	},
			eventClick: function (calEvent, jsEvent, view) {
				console.log(view)
			},
			eventLimit: true,
			editable: true,
			weekends: true,
			aspectRatio: 3,
			scrollTime: '08:00',
			minTime: "08:00",
			maxTime: "21:00",
			eventOverlap : false,
			header: {
				left: 'today prev,next',
				center: 'title',
				right: 'timelineDay,timelineHoleWeek,month'
			},
			defaultView: 'timelineDay',
			views: {
				timelineDay:{
					slotDuration: "01:00",
					slotWidth: 50,
					slotLabelFormat: [
					    'HH:mm'        // lower level of text
					]
				},
				timelineHoleWeek: {
					type: 'timeline',
					duration: { days: 7 },
					slotDuration: "1:00",
					slotWidth: 35,
					slotLabelFormat: [
					    'ddd DD/MM/YYYY', // top level of text
					    'HH'        // lower level of text
					]
				}
			},
			resourceAreaWidth: '25%',
			resourceColumns: [
				{
					group: true,
					labelText: 'Tipo',
					field: 'type'
				},
				{
					labelText: 'Sala',
					field: 'name'
				},
			],
			resources(callback)
			{
//				var resources = [];
//				for(bookable of me.resources) resources.push(bookable.resource);

				callback(me.resources)
			},
			events: function(start, end, timezone, callback) {
//				var events = [];
//				console.log(me.bookings)
//				for(booking of me.bookings) events.push(booking.event);

        callback(me.events);
    	}
		})
	}

}

</script>

<style lang="stylus">

.Calendar
	display flex
	flex-direction column
	&--List
		flex 1 0 0
	&--Calendar
		flex 1 0 20em
		margin 1em 4em

.fc-license-message{
	display: none !important
}
.fc-head .fc-scroller{
	min-height: auto !important;
}
</style>
