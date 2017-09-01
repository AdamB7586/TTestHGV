<?php

namespace TheoryTest\HGV;

class LearnTest extends \TheoryTest\Car\LearnTest{
    protected $testType = 'hgv';
    
    public $questionsTable = 'hgv_questions';
    public $progressTable = 'hgv_progress';
    public $dsaCategoriesTable = 'hgv_sections';
    
}
