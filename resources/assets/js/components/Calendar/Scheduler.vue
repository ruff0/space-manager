<template>
	<div class="Calendar">
		<div class="Calendar--List">
		</div>
		<div class="Calendar--Calendar">
			<div id="calendar"></div>
		</div>
	</div>

</template>

<script>
	store = {
		state : {
			bookables : {
				collection : []
			},
			bookings : {
				collection: []
			},
		}
	}

export default {
	name: "Scheduler",
	data(){
		return {

		}
	},
	props : {
		bookables : [],
		bookings : [],
		resources : [],
	},
	watch : {
		resources(){
		}
	},
	ready(){
		var me = this;
		$('#calendar').fullCalendar({
		 	dayClick: function(date, jsEvent, view) {
		 		if(view.name == 'month')
		 		{
		 			$('#calendar').fullCalendar( 'changeView', "timelineDay" )
		 			$('#calendar').fullCalendar( 'gotoDate', date )
		 		}
    	},
			eventClick: function (calEvent, jsEvent, view) {
				me.$router.go({ name : "bookings::bookings::edit", params : { id : calEvent.id}})
			},
			editable: true,
			weekends: false,
			aspectRatio: 3,
			scrollTime: '09:00',
			minTime: "09:00",
			maxTime: "22:00",
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
					labelText: 'Type',
					field: 'type'
				},
				{
					labelText: 'Rooms',
					field: 'name'
				},
			],
			resources(callback)
			{
				var resources = [];
				for(bookable of me.resources) resources.push(bookable.resource);

				callback(resources)
			},
			events: function(start, end, timezone, callback) {
				var events = [];
				for(booking of me.events) events.push(booking.event);

        callback(events);
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
</style>
