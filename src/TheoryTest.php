<?php

namespace TheoryTest\HGV;

use DBAL\Database;
use Configuration\Config;
use Smarty;

class TheoryTest extends \TheoryTest\ADI\TheoryTest
{
    protected $seconds = 6900;
    protected $scriptVar = 'hgv';
    
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
        $this->setImagePath(DS.'images'.DS.'hgv'.DS);
    }
    
    /**
     * Sets the tables
     */
    public function setTables()
    {
        $this->testsTable = $this->config->table_hgv_theory_tests;
        $this->questionsTable = $this->config->table_hgv_questions;
        $this->learningProgressTable = $this->config->table_hgv_progress;
        $this->progressTable = $this->config->table_hgv_test_progress;
        $this->dvsaCatTable = $this->config->table_hgv_dvsa_sections;
    }

    /**
     * Create a new ADI Theory Test for the test number given
     * @param int $theorytest Should be the test number
     * @return string Returns the HTML for a test
     */
    public function createNewTest($theorytest = 1)
    {
        $this->clearSettings();
        $this->setTest($theorytest);
        if (method_exists($this->user, 'checkUserAccess')) {
            $this->user->checkUserAccess($theorytest, 'hgv');
        }
        $this->setTestName();
        if ($this->anyExisting() === false) {
            $this->chooseQuestions($theorytest);
        }
        return $this->buildTest();
    }
    
    /**
     * Sets the current test name
     * @param string $name The name of the test you want to set it to, if left blank will be Theory Test plus test number
     */
    protected function setTestName($name = '')
    {
        if (!empty($name)) {
            $this->testName = $name;
        } else {
            $this->testName = 'HGV Test '.$this->getTest();
        }
    }
    
    /**
     * Marks the current test for the user
     * @param int|false $time The time to set as taken for the current test of false to not update
     * @return void Nothing is returned
     */
    protected function markTest($time = false)
    {
        $this->getQuestions();
        foreach ($this->questions as $prim) {
            if ($_SESSION['test'.$this->getTest()][$this->questionNo($prim)]['status'] == 4) {
                $type = 'correct';
            } else {
                $type = 'incorrect';
            }
             
            $dvsa = $this->getDSACat($prim);
            $this->testresults['dvsa'][$dvsa][$type] = (int)$this->testresults['dvsa'][$dvsa][$type] + 1;
        }
        
        $this->testresults['correct'] = $this->numCorrect();
        $this->testresults['incorrect'] = ($this->numQuestions() - $this->numCorrect());
        $this->testresults['incomplete'] = $this->numIncomplete();
        $this->testresults['flagged'] = $this->numFlagged();
        $this->testresults['numquestions'] = $this->numQuestions();
        $this->testresults['percent']['correct'] = round(($this->testresults['correct'] / $this->testresults['numquestions']) * 100);
        $this->testresults['percent']['incorrect'] = round(($this->testresults['incorrect'] / $this->testresults['numquestions']) * 100);
        $this->testresults['percent']['flagged'] = round(($this->testresults['flagged'] / $this->testresults['numquestions']) * 100);
        $this->testresults['percent']['incomplete'] = round(($this->testresults['incomplete'] / $this->testresults['numquestions']) * 100);
        if ($this->numCorrect() >= $this->passmark) {
            $this->testresults['status'] = 'pass';
            $status = 1;
        } else {
            $this->testresults['status'] = 'fail';
            $status = 2;
        }
        if ($time !== false) {
            list($hours, $mins, $secs) = explode(':', $time);
            $newtime = gmdate('H:i:s', ($this->seconds - (($hours * 60 * 60) + ($mins * 60) + $secs)));
            $this->userProgress['time_taken'] = $newtime;
        }
        $this->db->update($this->progressTable, array_merge(['status' => $status, 'results' => serialize($this->testresults), 'complete' => date('Y-m-d H:i:s'), 'totalscore' => $this->numCorrect()], ($time !== false ? ['time_taken' => $newtime] : [])), ['user_id' => $this->getUserID(), 'test_id' => $this->getTest(), 'status' => 0, 'current_test' => 1]);
    }
}
