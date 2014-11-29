<?php
//namespace App\ideas;

// Functions/classes for dealing with ideas



// Simple idea/phrase/keyword object that holds 
class Idea{
	function __construct($phrase){
		$this->phrase = $phrase;
		$this->stars = 0; // Initially zero.
	}

	function __toString(){
		return $this->phrase;
	}

	// Set the new id of a newly saved idea.
	function setId($id){
		if(isset($this->id) && $this->id){ // Don't set an idea on an idea that already exists!
			return false;
		} else {
			$this->id = $id;
		}
		return true;
	}

	// The idea phrase/title.
	function phrase(){
		return $this->phrase();
	}

	function id(){
		return isset($this->id)? $this->id : null;
	}

	// Add a single star to an idea.
	function addStar(){
		$this->stars = $this->stars++;
	}

	function stars(){
		return $this->stars();
	}
}

// Class to get, destroy, save, and collect Ideas.
class IdeaFactory{

	// Get all the ideas currently in the system
	static public function all(){
		// MOCK ideas for now, just to test the system!
		$idea = new Idea('Hello World');
		$idea2 = new Idea('Ping Pong');
		$idea3 = new Idea('Ducks');
		$idea4 = new Idea('Zip Zing');
		$idea5 = new Idea('Formulate');
		$idea6 = new Idea('Ninja');
		$ideas = array('1'=>$idea, '2'=>$idea2, '3'=>$idea3, '4'=>$idea4, '5'=>$idea5, '7'=>$idea6); // Array of ideas.
		return $ideas;
	}

	// Get a certain idea by id.
	static public function idea($id){
		$all = IdeaFactory::all();
		foreach($all as $idea){ // TODO: Make this not pull all ideas just to find one, eventually.
			if($idea->id() === $id){
				return $idea;
			}
		}
		return null; // No match found.
	}

	// Save an idea to the database and give the object the id.
	static public function saveIdea(Idea $idea){
		if(!($idea instanceof Idea)){ // Only save idea objects.
			return null;
		}
		$id = $idea->id();
		if(!$id){
			$id = rand(4, 9999999); // TODO: Replace this temporary hack with actual idea saving.
			$idea->setId($id);
			$id = $idea->id();
		}
		return $idea;
	}

	// Search for ideas by a term
	static public function search($term){
		$all_ideas = IdeaFactory::all();
		// TODO: Replace this horrible hack with better search matching!
		array_filter($all_ideas, function($el) use ($term) {
        	return ( strpos($el->phrase(), $term) !== false );
    	});
    	return $all_ideas; // Filtered now.
	}

	// Convert the full collection to a string.  Maybe should convert to json eventually.
	function __toString(){
		$all_ideas = IdeaFactory::all();
		$out = '';
		if(count($all_ideas) > 0){
			$out = implode(':', $all_ideas); // e.g. hello world:james adams:twitter trending
		}
		return $out;
	}
}