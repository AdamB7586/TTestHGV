<?php

namespace TheoryTest\HGV;

use DBAL\Database;
use Smarty;
use UserAuth\User;

class TheoryTest extends \TheoryTest\Car\TheoryTest
{
    protected $seconds = 6900;
    protected $section = 'aditheory';
    
    public $questionsTable = 'hgv_questions';
    public $progressTable = 'hgv_test_progress';
    public $dsaCategoriesTable = 'hgv_dsa_sections';
    
    /**
     * Connects to the database sets the current user and gets any user answers
     * @param Database $db This needs to be an instance of the database class
     * @param Config $config This needs to be an instance of the Configuration class
     * @param Smarty $layout This needs to be an instance of the Smarty Template class
     * @param object $user This should be the user class used
     * @param int|false $userID If you want to emulate a user set the user ID here
     * @param string|false $templateDir If you want to change the template location set this location here
     * @param string $theme This is the template folder to look at currently either 'bootstrap' or 'bootstrap4'
     */
    public function __construct(Database $db, Config $config, Smarty $layout, $user, $userID = false, $templateDir = false, $theme = 'bootstrap')
    {
        parent::__construct($db, $config, $layout, $user, $userID, $templateDir, $theme);
        $this->setImagePath(ROOT.DS.'images'.DS.'hgv'.DS);
    }
    
    /**
     * Sets the tables
     */
    protected function setTables()
    {
        $this->testsTable = $this->config->table_hgv_positions;
        $this->questionsTable = $this->config->table_hgv_questions;
        $this->learningProgressTable = $this->config->table_hgv_progress;
        $this->progressTable = $this->config->table_hgv_test_progress;
        $this->dvsaCatTable = $this->config->table_hgv_dvsa_sections;
    }
}
