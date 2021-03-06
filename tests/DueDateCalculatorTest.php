<?php
use PHPUnit\Framework\TestCase;

final class DueDateCalculatorTest extends TestCase
{
    public function testIsWorkingDay_WhenDateIsWeekday_ShoulReturnTrue(){
        //prepare
        $dueDateCalculator = new DueDateCalculator();
        //act
        $isWorkingDay = $dueDateCalculator->isWorkingDay(new DateTime('2021-03-05'));
        //assert
        $this->assertEquals(true, $isWorkingDay);
    }
    public function testIsWorkingDay_WhenDateIsWeekend_ShoulReturnFalse(){
        //prepare
        $dueDateCalculator = new DueDateCalculator();
        //act
        $isWorkingDay = $dueDateCalculator->isWorkingDay(new DateTime('2021-03-06'));
        //assert
        $this->assertEquals(false, $isWorkingDay);
    }
    public function testIsWorkingDay_WhenDateTimeIsWeekday_ShoulReturnTrue(){
        //prepare
        $dueDateCalculator = new DueDateCalculator();
        //act
        $isWorkingDay = $dueDateCalculator->isWorkingDay(new DateTime('2021-03-05 14:00:00'));
        //assert
        $this->assertEquals(true, $isWorkingDay);
    }
    public function testIsWorkingDay_WhenDateTimeIsWeekday_ShoulReturnFalse(){
        //prepare
        $dueDateCalculator = new DueDateCalculator();
        //act
        $isWorkingDay = $dueDateCalculator->isWorkingDay(new DateTime('2021-03-06 10:00:00'));
        //assert
        $this->assertEquals(false, $isWorkingDay);
    }

    public function testIsWorkingDays(){

        $dueDateCalculator = new DueDateCalculator();

        $isWorkingDay = $dueDateCalculator->isWorkingDay(new DateTime('2021-03-01 14:00:00'));
        $this->assertEquals(true, $isWorkingDay);

        $isWorkingDay = $dueDateCalculator->isWorkingDay(new DateTime('2021-03-02 14:00:00'));
        $this->assertEquals(true, $isWorkingDay);
        
        $isWorkingDay = $dueDateCalculator->isWorkingDay(new DateTime('2021-03-03 14:00:00'));
        $this->assertEquals(true, $isWorkingDay);
        
        $isWorkingDay = $dueDateCalculator->isWorkingDay(new DateTime('2021-03-04 14:00:00'));
        $this->assertEquals(true, $isWorkingDay);
        
        $isWorkingDay = $dueDateCalculator->isWorkingDay(new DateTime('2021-03-05 14:00:00'));
        $this->assertEquals(true, $isWorkingDay);
        
        $isWorkingDay = $dueDateCalculator->isWorkingDay(new DateTime('2021-03-06 14:00:00'));
        $this->assertEquals(false, $isWorkingDay);
        
        $isWorkingDay = $dueDateCalculator->isWorkingDay(new DateTime('2021-03-07 14:00:00'));
        $this->assertEquals(false, $isWorkingDay);
        
        $isWorkingDay = $dueDateCalculator->isWorkingDay(new DateTime('2021-03-08 14:00:00'));
        $this->assertEquals(true, $isWorkingDay);

    }

    public static function IsWorkingdayTestData()
    {
        return array(
            array(true, '2021-03-01 14:00:00'),
            array(true, '2021-03-02 14:00:00'),
            array(true, '2021-03-03 14:00:00'),
            array(true, '2021-03-04 14:00:00'),
            array(true, '2021-03-05 14:00:00'),
            array(false, '2021-03-06 14:00:00'),
            array(false, '2021-03-07 14:00:00'),
            array(true, '2021-03-08 14:00:00'),
            array(true, '2021-03-09 14:00:00')
        );
    }

    /**
     * @dataProvider IsWorkingdayTestData 
    */
    public function testIsWorkingDays_withParameters($result, $datetime){
        
        $dueDateCalculator = new DueDateCalculator();

        $isWorkingDay = $dueDateCalculator->isWorkingDay(new DateTime($datetime));
        $this->assertEquals($result, $isWorkingDay);
    }


    public function testIsWorkingHours_WhenDateIsWeekday_ShoulReturnTrue(){
        //prepare
        $dueDateCalculator = new DueDateCalculator();
        //act
        $isWorkingHours = $dueDateCalculator->isWorkingHours(new DateTime('2021-03-05 14:00:00'));
        //assert
        $this->assertEquals(true, $isWorkingHours);
    }
    public function testIsWorkingHours_WhenDateIsWeekday_ShoulReturnFalse(){
        //prepare
        $dueDateCalculator = new DueDateCalculator();
        //act
        $isWorkingHours = $dueDateCalculator->isWorkingHours(new DateTime('2021-03-06 14:00:00'));
        //assert
        $this->assertEquals(false, $isWorkingHours);
    }
    public function testIsWorkingHours_WhenDateIsWeekdayAndHourInWorkinghours_ShoulReturnTrue(){
        //prepare
        $dueDateCalculator = new DueDateCalculator();
        //act
        $isWorkingHours = $dueDateCalculator->isWorkingHours(new DateTime('2021-03-05 14:00:00'));
        //assert
        $this->assertEquals(true, $isWorkingHours);
    }
    public function testIsWorkingHours_WhenDateIsWeekdayAndHourOutWorkinghours_ShoulReturnFalse(){
        //prepare
        $dueDateCalculator = new DueDateCalculator();
        //act
        $isWorkingHours = $dueDateCalculator->isWorkingHours(new DateTime('2021-03-05 08:59:00'));
        //assert
        $this->assertEquals(false, $isWorkingHours);
    }
}
?>