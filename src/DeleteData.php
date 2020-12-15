<?php
namespace TheoryTest\ADI;

class DeleteData extends \TheoryTest\Car\DeleteData
{
    /**
     * Sets the tables
     */
    protected function setTables()
    {
        $this->learningProgressTable = $this->config->table_hgv_progress;
        $this->progressTable = $this->config->table_hgv_test_progress;
    }
}
