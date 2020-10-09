<?php

namespace TheoryTest\HGV\Tests;

class TheoryTestTest extends SetUp
{
    protected $hgv;
    
    public function setUp(): void
    {
        parent::setUp();
        self::$user->login($GLOBALS['LOGIN_EMAIL'], $GLOBALS['LOGIN_PASSWORD']);
        $this->hgv = new TheoryTest(self::$db, self::$config, self::$template, self::$user);
    }
    
    public function testExample()
    {
        $this->markTestIncomplete();
    }
}
