<?php

namespace TheoryTest\HGV;

class LearnTest extends \TheoryTest\Car\LearnTest
{
    /**
     * Sets the tables
     */
    public function setTables()
    {
        $this->questionsTable = $this->config->table_hgv_questions;
        $this->learningProgressTable = $this->config->table_hgv_progress;
        $this->progressTable = $this->config->table_hgv_test_progress;
        $this->dvsaCatTable = $this->config->table_hgv_dvsa_sections;
    }
}
