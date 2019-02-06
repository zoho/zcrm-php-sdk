<?php
class PHPUnitTestUtil extends \PHPUnit\Framework\TestCase
{
	public function assertEqualsCheck($expectedValue,$actualValue)
	{
		$this->assertEquals($expectedValue,$actualValue);
	}
	
	public function assertNotEqualsCheck($expectedValue,$actualValue)
	{
		$this->assertNotEquals($expectedValue,$actualValue);
	}
	
	public function assertNullCheck($value)
	{
		$this->assertNull($value);
	}
	
	public function assertNotNullCheck($value)
	{
		$this->assertNotNull($value);
	}
	
}

?>
