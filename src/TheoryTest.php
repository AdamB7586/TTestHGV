<?php

namespace TheoryTest\HGV;

class TheoryTest extends \TheoryTest\Car\TheoryTest{
    protected $seconds = 5400;
    protected $section = 'aditheory';
    
    protected $audioLocation = '/audio/hgv';
    
    public $questionsTable = 'hgv_questions';
    public $progressTable = 'hgv_test_progress';
    public $dsaCategoriesTable = 'hgv_dsa_sections';
    
    protected static $testType = 'hgv';
    
    public function __construct(Database $db, Smarty $layout, User $user, $userID = false) {
        parent::__construct($db, $layout, $user, $userID);
        $this->setImagePath(ROOT.DS.'images'.DS.'hgv'.DS);
    }
}
