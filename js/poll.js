var votedID;
var cpoll = 'P001';

$(document).ready(function() {
  $('#poll_wrap').show();
  
  $("#poll").submit(formProcess); // setup the submit handler
  
  if ($("#poll-results").length > 0 ) {
	animateResults();
  }
  
  if ($.cookie(cpoll + '_vote_id')) {
    $("#poll-container").empty();
    votedID = $.cookie(cpoll + '_vote_id');
    $.getJSON("poll/poll.php?vote=none",loadResults);
  }
});

function formProcess(event) {
	event.preventDefault();
  
	var id = $("input[@name='poll']:checked").attr("value");

	if (parseInt(id) != id) {
		return false;
	}

	$("#poll-container").fadeOut("slow", function() {
		$(this).empty();
		votedID = id;
		$.getJSON("poll/poll.php?vote=" + id, loadResults);
		
		$.cookie(cpoll + '_vote_id', id, {expires: 365});
	 });
}

function animateResults() {
  $("#poll-results div").each(function() {
      var percentage = $(this).next().text();
      $(this).css({width: "0%"}).animate({width: percentage}, 'slow');
  });
}

function loadResults(data) {
  var total_votes = 0;
  var percent;
  for (id in data['tt']) {
    total_votes = total_votes + parseInt(data['tt'][id]);
  }

  var results_html = "<div id='poll-results'><h3>Poll Results</h3>\n<dl class='graph'>\n";

  for (id in data['tt']) {
    percent = Math.round((parseInt(data['tt'][id]) / parseInt(total_votes)) * 100);
	
    if (id !== votedID) {
      results_html = results_html+"<dt class='bar-title'>"+data['title'][id]+"</dt><dd class='bar-container'><div id='bar"+id+"'style='width:0%;'>&nbsp;</div><strong>"+percent+"%</strong></dd>\n";
    } else {
      results_html = results_html+"<dt class='bar-title'>"+data['title'][id]+"</dt><dd class='bar-container'><div id='bar"+id+"'style='width:0%;background-color:#0066cc;'>&nbsp;</div><strong>"+percent+"%</strong></dd>\n";
    }
  }
  
  results_html = results_html+"</dl><p id='total_vote'>Total Votes: "+total_votes+"</p></div>\n";
  
  $("#poll-container")
  	.append(results_html)
	.fadeIn("slow", function() { animateResults(); });
}