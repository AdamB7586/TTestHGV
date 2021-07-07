<?php

namespace TheoryTest\HGV;

class RandomTest extends TheoryTest
{

    protected $testNo = 11;
    protected $scriptVar = 'adirandom';
    
    /**
     * Sets the current test name
     * @param string $name The name of the test you wish to set, if left blank will be Theory Test plus test number
     */
    protected function setTestName($name = '')
    {
        if (!empty($name)) {
            $this->testName = $name;
        } else {
            $this->testName = 'HGV Random Test';
        }
    }
    
    /**
     * Creates the test report HTML if the test has been completed
     * @param int $theorytest The test number you wish to view the report for
     * @return string Returns the HTML for the test report for the given test ID
     */
    public function createTestReport($theorytest = 11)
    {
        return parent::createTestReport(11);
    }
    
    /**
     * Picks some random questions for the ADI test
     * @return boolean If the questions have been selected and added to the database will return true else returns false
     */
    protected function chooseQuestions($testNo = 11)
    {
        $this->db->delete($this->progressTable, ['user_id' => $this->getUserID(), 'test_id' => $this->testNo]);
        $questions = $this->db->query("SELECT * FROM ((SELECT `prim` FROM `".$this->questionsTable."` WHERE `dsacat` = '1' AND `alertcasestudy` IS NULL ORDER BY RAND() LIMIT 7)
    UNION (SELECT `prim` FROM `".$this->questionsTable."` WHERE `dsacat` = '2' AND `alertcasestudy` IS NULL ORDER BY RAND() LIMIT 7)
    UNION (SELECT `prim` FROM `".$this->questionsTable."` WHERE `dsacat` = '3' AND `alertcasestudy` IS NULL ORDER BY RAND() LIMIT 6)
    UNION (SELECT `prim` FROM `".$this->questionsTable."` WHERE `dsacat` = '4' AND `alertcasestudy` IS NULL ORDER BY RAND() LIMIT 10)
    UNION (SELECT `prim` FROM `".$this->questionsTable."` WHERE `dsacat` = '5' AND `alertcasestudy` IS NULL ORDER BY RAND() LIMIT 6)
    UNION (SELECT `prim` FROM `".$this->questionsTable."` WHERE `dsacat` = '6' AND `alertcasestudy` IS NULL ORDER BY RAND() LIMIT 11)
    UNION (SELECT `prim` FROM `".$this->questionsTable."` WHERE `dsacat` = '7' AND `alertcasestudy` IS NULL ORDER BY RAND() LIMIT 6)
    UNION (SELECT `prim` FROM `".$this->questionsTable."` WHERE `dsacat` = '8' AND `alertcasestudy` IS NULL ORDER BY RAND() LIMIT 10)
    UNION (SELECT `prim` FROM `".$this->questionsTable."` WHERE `dsacat` = '9' AND `alertcasestudy` IS NULL ORDER BY RAND() LIMIT 2)
    UNION (SELECT `prim` FROM `".$this->questionsTable."` WHERE `dsacat` = '10' AND `alertcasestudy` IS NULL ORDER BY RAND() LIMIT 7)
    UNION (SELECT `prim` FROM `".$this->questionsTable."` WHERE `dsacat` = '11' AND `alertcasestudy` IS NULL ORDER BY RAND() LIMIT 3)
    UNION (SELECT `prim` FROM `".$this->questionsTable."` WHERE `dsacat` = '12' AND `alertcasestudy` IS NULL ORDER BY RAND() LIMIT 3)
    UNION (SELECT `prim` FROM `".$this->questionsTable."` WHERE `dsacat` = '13' AND `alertcasestudy` IS NULL ORDER BY RAND() LIMIT 7)
    UNION (SELECT `prim` FROM `".$this->questionsTable."` WHERE `dsacat` = '14' AND `alertcasestudy` IS NULL ORDER BY RAND() LIMIT 7)
    UNION (SELECT `prim` FROM `".$this->questionsTable."` WHERE `dsacat` = '15' AND `alertcasestudy` IS NULL ORDER BY RAND() LIMIT 8) ORDER BY RAND()) as a;", [], false);
         
        unset($_SESSION['test'.$this->getTest()]);
        foreach ($questions as $q => $question) {
            $this->questions[($q + 1)] = $question['prim'];
        }
        return $this->db->insert($this->progressTable, ['user_id' => $this->getUserID(), 'questions' => serialize($this->questions), 'answers' => serialize([]), 'test_id' => $this->testNo, 'started' => date('Y-m-d H:i:s'), 'status' => 0]);
    }
}
