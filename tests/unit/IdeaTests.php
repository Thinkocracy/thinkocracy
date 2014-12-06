<?php
require(ROOT.'core/ideas.php');
//use App\ideas; // Include the ideas namespace

class IdeaTests extends PHPUnit_Framework_TestCase{

	function testCreatingAnIdeaDoesntFail(){
		$idea = new Idea('hello world');
		$this->assertInstanceOf('Idea', $idea);
	}

	function testAnIdeaCastsToStringFine(){
		$idea = new Idea('hello world');
		$this->assertNotEmpty((string)$idea);
	}

	function testGetAndSetOfIdeaId(){
		$idea = new Idea('awesomenexxxx');
		$idea->setId(34);
		$this->assertEquals(34, $idea->id());
	}

	function testIdeaObjectHasStuffThatItDoes(){
		$idea = new Idea('give me stars');
		$idea->addStar();
		$idea->addStar();
		$idea->addStar();
		$stars = $idea->stars();
		$this->assertEquals(3, $stars);
	}

	function testNewIdeaAtLeastReturnsAnIDWhenSaved(){
		$idea = new Idea('this idea doesn\'t exist yet');
		$idea = IdeaFactory::saveIdea($idea);
		$this->assertGreaterThan(0, $idea->id()); // The idea should get an id!
	}

	function testNewIdeaActuallyGetsSavedToDatabaseWhenSaved(){
		$this->markTestIncomplete(); // True saving isn't implemented yet.
	}

	function testGettingAllIdeasFromIdeaCollection(){
		$ideas = IdeaFactory::all();
		$first_idea = reset($ideas); // Get the first element of array
		$last_idea = end($ideas);
		$this->assertInstanceOf('Idea', $first_idea);
		$this->assertInstanceOf('Idea', $last_idea);
		$this->assertGreaterThan(0, count($ideas));
		foreach($ideas as $idea){
			$this->assertInstanceOf('Idea', $idea);
		}
	}

	function testGetAFewIdeasById(){
		$idea = IdeaFactory::idea(1);
		$idea2 = IdeaFactory::idea(2);
		$idea3 = IdeaFactory::idea(3);
		$this->assertInstanceOf('Idea', $idea);
		$this->assertInstanceOf('Idea', $idea2);
		$this->assertInstanceOf('Idea', $idea3);
		$this->assertEquals(3, $idea3->id());
	}

	function testSearchThroughIdeasAndFindSpecificOnes(){
		$term = 'hello';
		$matched_ideas = IdeaFactory::search($term);
		$this->assertGreaterThan(0, count($matched_ideas));
	}

	function testSearchThroughIdeasAndFindAPreSetMatch(){
		$term = 'Ninja';
		$matched_ideas = IdeaFactory::search($term);
		$this->assertGreaterThan(0, count($matched_ideas));
	}





}
