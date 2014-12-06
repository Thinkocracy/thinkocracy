// The full Thinkocracy core js!

// Get all the ideas in the system, and then do some stuff with them
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

// Pull an idea from the api via id
function pullIdeaById(id, callback){
	$.getJSON('api/ideas/'+id, function(data){
		callback(data); // Execute whatever callback on the data, once the api finally returns it.
	});
}

// Create an idea via the api
function createIdea(idea){
	// TODO: This will hit api/ideas/ with a post call to create an idea using the data, eventually.
}