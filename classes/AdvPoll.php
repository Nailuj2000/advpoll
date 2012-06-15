<?php
class AdvPoll extends ElggObject {

	protected function initializeAttributes() {
        parent::initializeAttributes();
        $this->attributes['subtype'] = 'advpoll';
    }

    /**
     * Returns all possible candidates for a poll in an array. Each candidate is an Elgg
     * entity.
     *
     * @param ElggEntity $poll  A poll entity.
     * @return array  An array of candidates.
     */
    private function getCandidates() {
    	$options = array(
    			'relationship' => 'poll_choice',
    			'relationship_guid' => $this->guid,
    			'inverse_relationship' => TRUE,
    			'order_by_metadata' => array('name'=>'display_order','direction'=>'ASC'),
    			'limit' => 0,
    	);
    	return elgg_get_entities_from_relationship($options);
    }
    
    /**
     *  Get an array of all poll choices guids.
     *
     *  @param $poll  The poll the choices of which we want.
     *  @return an array containing a relation between the choice text and
     *  the choice guid.
     */
    public function getCandidatesArray() {
    	$choices = $this->getCandidates();
    	$responses = array();
    	if ($choices) {
    		foreach($choices as $choice) {
    			$label = $choice->text;
    			// force numbers to be strings
    			$responses["$label" . ' '] = $choice->guid;
    		}
    	}
    	return $responses;
    }
    
    /**
     * Save a list of choices in a poll. For each choice, an ElggObject is created,
     * and related to the poll as an Elgg relationship.
     *
     * @param $poll  A poll entity.
     * @param $choices  A collections of strings.
     */
    public function addCandidates($choices) {
    	$i = 0;
    	if ($choices) {
    		foreach($choices as $choice) {
    			$poll_choice = new ElggObject();
    			$poll_choice->subtype = "poll_choice";
    			$poll_choice->text = $choice;
    			$poll_choice->display_order = $i*10;
    			$poll_choice->access_id = $this->access_id;
    			$poll_choice->save();
    			add_entity_relationship($poll_choice->guid, 'poll_choice', $this->guid);
    			$i += 1;
    		}
    	}
    }
    
    /**
     * Removes all choices associated with a poll.
     *
     * @param $poll  A poll entity.
     */
    public function deleteCandidates() {
    	$choices = $this->getCandidates();
    	if ($choices) {
    		foreach($choices as $choice) {
    			$choice->delete();
    		}
    	}
    }
    
    /**
     * Replaces the current set of polls choices for a new one.
     *
     * @param $poll  A poll entity.
     * @param $new_choices  A collection of strings.
     */
    public function replaceCandidates($new_choices) {
    	$this->deleteCandidates();
    	$this->addCandidates($new_choices);
    }
}
?>
