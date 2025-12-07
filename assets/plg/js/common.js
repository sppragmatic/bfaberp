$(document).ready(function(){

setTimeout(function(){
  $("#alert").fadeOut("slow", function () {
      });
 
}, 2000);
/* timer functions */ 
 $('.timepicker1').timepicker();


/* chosen */ 
$(".chzn-select").chosen();
//get the time 
   $('.digital-clock').clock({offset: '+5.50', type: 'digital'});
   
$('.datepicker').datepicker({
				format: 'yyyy-mm-dd',
				buttonImage: "../images/datepicker.png"				
			
			}) .on('changeDate', function(e){    
            $('.datepicker').datepicker('hide')
    });
			
			var nowTemp = new Date();
var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
//alert(now);
 
var checkin = $('#dpd1').datepicker({
	format: 'yyyy-mm-dd',
  onRender: function(date) {
    return date.valueOf()+1 < now.valueOf() ? 'disabled' : '';
  }
}).on('changeDate', function(ev) {
  if (ev.date.valueOf() > checkout.date.valueOf()) {
    var newDate = new Date(ev.date)
    newDate.setDate(newDate.getDate()+1);
    checkout.setValue(newDate);
  }
  checkin.hide();
  $('#dpd2')[0].focus();
}).data('datepicker');
var checkout = $('#dpd2').datepicker({
	format: 'yyyy-mm-dd',
  onRender: function(date) {
    return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
  }
}).on('changeDate', function(ev) {
  checkout.hide();
}).data('datepicker');

// datatables
$('#example').dataTable({
 "sPaginationType": "full_numbers",
});

$('.datatable').dataTable({
 "sPaginationType": "full_numbers",
});

// Total Hours timer
//$("#stopwatch").set({ time : 1000, autostart : false });
var Example1 = new (function() {
    var $stopwatch, // Stopwatch element on the page
        incrementTime = 70, // Timer speed in milliseconds
        currentTime = 0, // Current time in hundredths of a second
        updateTimer = function() {
            $stopwatch.html(formatTime(currentTime));
            currentTime += incrementTime / 10;
        },
        init = function() {
            $stopwatch = $('#stopwatch');
            Example1.Timer = $.timer(updateTimer, incrementTime, true);
        };
    this.resetStopwatch = function() {
        currentTime = 0;
        this.Timer.stop().once();
    };
    $(init);
});

function pad(number, length) {
    var str = '' + number;
    while (str.length < length) {str = '0' + str;}
    return str;
}
function formatTime(time) {
    var min = parseInt(time / 6000),
        sec = parseInt(time / 100) - (min * 60),
        hundredths = pad(time - (sec * 100) - (min * 6000), 2);
    return (min > 0 ? pad(min, 2) : "00") + ":" + pad(sec, 2) + ":" + hundredths;
}
})

$("#my-collapse-nav > li > a[data-target]").parent('li').hover(
        function() { 
            target = $(this).children('a[data-target]').data('target');
            $(target).collapse('show') 
        },
        function() { 
            target = $(this).children('a[data-target]').data('target'); 
            $(target).collapse('hide');
        }
);

