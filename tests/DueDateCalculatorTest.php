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

    public static function isWorkingdayTestData()
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
     * @dataProvider isWorkingdayTestData 
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
    
    public function testIsWorkingHours_WhenDateIsWeekdayAndHourOutWorkinghours2_ShoulReturnFalse(){
        //prepare
        $dueDateCalculator = new DueDateCalculator();
        //act
        $isWorkingHours = $dueDateCalculator->isWorkingHours(new DateTime('2021-03-05 17:01:00'));
        //assert
        $this->assertEquals(false, $isWorkingHours);
    }


    public function testcalculateDueDate_WhenDateIsWeekday_ShoulReturnDateTime(){
        //prepare
        $dueDateCalculator = new DueDateCalculator();
        //act
        $resolvedDateTime = $dueDateCalculator->calculateDueDate(new DateTime('2021-03-05 13:00:00'), 3);

        //assert
        $this->assertEquals(new DateTime('2021-03-05 16:00:00'), $resolvedDateTime);
    }
    public static function calculateDueDateTestData_Workdays()
    {
        return array(
            array('2021-03-09 13:59:00', 3 , '2021-03-09 16:59:00'),
            array('2021-03-08 09:00:00', 2 , '2021-03-08 11:00:00')
        );
    }

    /**
     * @dataProvider calculateDueDateTestData_Workdays 
    */
    public function testCalculateDueDateWithParameters_WhenDateIsWeekday_ShoulReturnDateTime(string $submitDateTime, int $turnaruondTime, string $result){
        //prepare
        $dueDateCalculator = new DueDateCalculator();
        //act
        $resolvedDateTime = $dueDateCalculator->calculateDueDate(new DateTime($submitDateTime), $turnaruondTime);
        
        //assert
        $this->assertEquals(new DateTime($result), $resolvedDateTime);
    }
    
    public static function calculateDueDateTestData_Weekends()
    {
        return array(
            array('2021-03-09 18:01:00', 3 , '2021-03-09 17:00:00'),
            array('2021-03-06 09:00:00', 2 , '2021-03-06 11:00:00')
        );
    }

    /**
     * @dataProvider calculateDueDateTestData_Weekends 
    */
    public function testCalculateDueDateWithParameters_WhenDateIsWeekend_ShoulReturnFalse(string $submitDateTime, int $turnaruondTime, string $result){
        //prepare
        $dueDateCalculator = new DueDateCalculator();
        //act
        $resolvedDateTime = $dueDateCalculator->calculateDueDate(new DateTime($submitDateTime), $turnaruondTime);
        
        //assert
        $this->assertEquals(false, $resolvedDateTime);
    }


    public function testHowManyHoursLeft_WhenNoWorkingTime_ShouldReturnZero(){
        //prepare
        $dueDateCalculator = new DueDateCalculator();
        //act
        $howManyHoursLeft = $dueDateCalculator->howManyHoursLeft(new DateTime('2021-03-05 18:59:00'));
        
        //assert
        $this->assertEquals(0, $howManyHoursLeft);
    }
    
    public function testcalculateDueDate_WhenDateIsWeekday_ResolvedDateToday_ShoulReturnDateTime(){
        //prepare
        $dueDateCalculator = new DueDateCalculator();
        //act
        $resolvedDateTime = $dueDateCalculator->calculateDueDate(new DateTime('2021-03-05 09:00:00'), 5);
        //assert
        $this->assertEquals(new DateTime('2021-03-05 14:00:00'), $resolvedDateTime);
    }
    public function testcalculateDueDate_WhenDateIsWeekday_ResolvedDateTomorrow_ShoulReturnDateTime(){
        //prepare
        $dueDateCalculator = new DueDateCalculator();
        //act
        $resolvedDateTime = $dueDateCalculator->calculateDueDate(new DateTime('2021-03-05 15:10:00'), 5);
        //assert
        $this->assertEquals(new DateTime('2021-03-06 12:10:00'), $resolvedDateTime);
    }
    
    public function testcalculateDueDate_WhenDateIsWeekday_ResolvedDateTomorrow2_ShoulReturnDateTime(){
        //prepare
        $dueDateCalculator = new DueDateCalculator();
        //act
        $resolvedDateTime = $dueDateCalculator->calculateDueDate(new DateTime('2021-03-05 14:12:00'), 16);
        //assert
        $this->assertEquals(new DateTime('2021-03-07 14:12:00'), $resolvedDateTime);
    }

    public static function calculateDueDateTestData2_Workdays()
    {
        return array(
            array('2021-03-02 09:59:00', 10 , '2021-03-03 11:59:00'),
            array('2021-03-02 09:59:00', 18 , '2021-03-04 11:59:00'),
            array('2021-03-09 13:59:00', 3 , '2021-03-09 16:59:00'),
            array('2021-03-09 16:59:00', 3 , '2021-03-10 11:59:00'),
            array('2021-03-08 09:00:00', 2 , '2021-03-08 11:00:00')
        );
    }

    /**
     * @dataProvider calculateDueDateTestData2_Workdays 
    */
    public function testCalculateDueDateWithParameters_WhenDateIsWeekday_ResolvedDateTomorrow2_ShoulReturnDateTime(string $submitDateTime, int $turnaruondTime, string $result){
        //prepare
        $dueDateCalculator = new DueDateCalculator();
        //act
        $resolvedDateTime = $dueDateCalculator->calculateDueDate(new DateTime($submitDateTime), $turnaruondTime);
        
        //assert
        $this->assertEquals(new DateTime($result), $resolvedDateTime);
    }



    public function testHowManyHoursLeft_WhenTimeBetween917_ShouldReturnInt(){
        //prepare
        $dueDateCalculator = new DueDateCalculator();
        //act
        $howManyHoursLeft = $dueDateCalculator->howManyHoursLeft(new DateTime('2021-03-05 09:00:00'));
        //assert
        $this->assertEquals(7, $howManyHoursLeft);
    }
    public function testHowManyHoursLeft_WhenTimeGreaterThan16_ShouldReturnZero(){
        //prepare
        $dueDateCalculator = new DueDateCalculator();
        //act
        $howManyHoursLeft = $dueDateCalculator->howManyHoursLeft(new DateTime('2021-03-05 19:00:00'));
        //assert
        $this->assertEquals(0, $howManyHoursLeft);
    }
    public function testHowManyHoursLeft_WhenTimeLessThan9_ShouldReturnZero(){
        //prepare
        $dueDateCalculator = new DueDateCalculator();
        //act
        $howManyHoursLeft = $dueDateCalculator->howManyHoursLeft(new DateTime('2021-03-05 08:00:00'));
        //assert
        $this->assertEquals(0, $howManyHoursLeft);
    }
}
?>