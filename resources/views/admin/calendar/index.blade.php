@extends('admin.index')
@section('main')
<div class="container-fluid px-4">
    <div class="container">
        <div class="response"></div>
        <div id='calendar'></div>  
    </div>
    <script>
    $(document).ready(function () {
      var SITEURL = "{{url('/admin')}}";
      $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
        var calendar = $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,listMonth'
            },
            editable: true,
            events: SITEURL + "",
            displayEventTime: true,//if true, show time
            timeFormat: 'H(:mm)',
            dayRender: function(date, cell){
                if (moment().diff(date,'days') > 0){
                    cell.css("background-color","silver");
                }
            },
            displayEventEnd: true,// if false, not show end time
            eventColor: '#378006',
            editable: true,
            eventRender: function (event, element, view) {
            if (event.allDay === 'true') {
            event.allDay = true;
            } else {
            event.allDay = false;
            }
        },
        selectable: true,
        selectHelper: true,
        select: function (start, end, allDay) {
        var title = prompt('Event Title:');
        if (title) {
        //if add event with click, make it from 12:00 to 13:00 
        var start = $.fullCalendar.formatDate(start, "Y-MM-DD 12:00:00");
        var end = moment(start).add(1, "h").format("Y-MM-DD HH:mm:ss");//$.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss")(to next day event)
        $.ajax({
            url: SITEURL + "/fullcalendar/create",
            data: 'title=' + title + '&start=' + start + '&end=' + end,
            type: "POST",
            success: function (data) {
            displayMessage("Added Successfully");
        }
        });
        calendar.fullCalendar('renderEvent',
        {
            title: title,
            start: start,
            end: end,
            allDay: false
        },
        true
        );
        }
        calendar.fullCalendar('unselect');
        },
        eventDrop: function (event, delta) {
        var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
        var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
        $.ajax({
            url: SITEURL + '/fullcalendar/update',
            data: 'title=' + event.title + '&start=' + start + '&end=' + end + '&id=' + event.id,
            type: "POST",
            success: function (response) {
            displayMessage("Updated Successfully");
        }
        });
        },
        eventClick: function (event) {
        var deleteMsg = confirm("Do you really want to delete?");
        if (deleteMsg) {
            $.ajax({
            type: "POST",
            url: SITEURL + '/fullcalendar/delete',
            data: "&id=" + event.id,
            success: function (response) {
            if(parseInt(response) > 0) {
            $('#calendar').fullCalendar('removeEvents', event.id);
            displayMessage("Deleted Successfully");
            }
        }
        });
        }
        }
      });
      });
      function displayMessage(message) {
      $(".response").html("<div class='success'>"+message+"</div>");
      setInterval(function() { $(".success").fadeOut(); }, 1000);
    }
    </script>

@endsection
@section('links')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.css" />
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.27.0/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.js"></script>
@endsection