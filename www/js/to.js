// The full Thinkocracy standard js!

function pullIdeas(){
	// Pull all the ideas and do some stuff with them, appending them to the current page, in this case.
	$.getJSON( "api/ideas", function( data ) {
	  var items = [];
	  $.each( data, function( key, val ) {
	  	console.log(val);
	    items.push( "<li id='" + key + "'>" + val.phrase + " :stars: " + val.stars +"</li>" );
	  });
	 
	 // Stick the ul at the end of the body.
	  $( "<ul/>", {
	    "class": "idea-list",
	    html: items.join( "" )
	  }).appendTo( "body" );
	});
}