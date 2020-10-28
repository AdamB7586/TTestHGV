<?php

namespace TheoryTest\HGV;

use DBAL\Database;
use Smarty;
use UserAuth\User;

class TheoryTest extends \TheoryTest\Car\TheoryTest
{
    protected $seconds = 5400;
    protected $section = 'aditheory';
    
    public $questionsTable = 'hgv_questions';
    public $progressTable = 'hgv_test_progress';
    public $dsaCategoriesTable = 'hgv_dsa_sections';
    
    protected $testType = 'hgv';
    
    public function __construct(Database $db, Config $config, Smarty $layout, $user, $userID = false, $templateDir = false, $theme = 'bootstrap')
    {
        parent::__construct($db, $config, $layout, $user, $userID, $templateDir, $theme);
        $this->setImagePath(ROOT.DS.'images'.DS.'hgv'.DS);
    }
}
