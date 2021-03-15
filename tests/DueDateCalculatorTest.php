<?php
use PHPUnit\Framework\TestCase;

final class DueDateCalculatorTest extends TestCase
{
    public function testcalculateDueDate_WhenDateIsWeekday_ShouldReturnDateTime(){
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
    public function testCalculateDueDateWithParameters_WhenDateIsWeekday_ShouldReturnDateTime(string $submitDateTime, int $turnaruondTime, string $result){
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
   public function testCalculateDueDateWithParameters_WhenDateIsWeekend_ShouldThrowException(string $submitDateTime, int $turnaruondTime, string $result){
        //prepare
        $dueDateCalculator = new DueDateCalculator();
        //act
        
        $emess = null;
        try {
            $resolvedDateTime = $dueDateCalculator->calculateDueDate(new DateTime($submitDateTime), $turnaruondTime);
        } catch (Exception $e) { 
            $emess = $e->getMessage();
        }
        $this->assertEquals($emess, 'Nem munkaido');
    }
    
    public function testcalculateDueDate_WhenDateIsWeekday_ResolvedDateToday_ShouldReturnDateTime(){
        //prepare
        $dueDateCalculator = new DueDateCalculator();
        //act
        $resolvedDateTime = $dueDateCalculator->calculateDueDate(new DateTime('2021-03-05 09:00:00'), 5);
        //assert
        $this->assertEquals(new DateTime('2021-03-05 14:00:00'), $resolvedDateTime);
    }
///
   public function testcalculateDueDate_WhenDateIsWeekday_ResolvedDateTomorrow_ShouldReturnDateTime(){
        //prepare
        $dueDateCalculator = new DueDateCalculator();
        //act
        $resolvedDateTime = $dueDateCalculator->calculateDueDate(new DateTime('2021-03-04 15:10:00'), 5);
        //assert
        $this->assertEquals(new DateTime('2021-03-05 12:10:00'), $resolvedDateTime);
    }
 
    public function testcalculateDueDate_WhenDateIsWeekday_ResolvedDateTomorrow2_ShouldReturnDateTime(){
        //prepare
        $dueDateCalculator = new DueDateCalculator();
        //act
        $resolvedDateTime = $dueDateCalculator->calculateDueDate(new DateTime('2021-03-03 14:12:00'), 16);
        //assert
        $this->assertEquals(new DateTime('2021-03-05 14:12:00'), $resolvedDateTime);
    }

    public static function calculateDueDateTestData2_Workdays()
    {
        return array(
            array('2021-03-02 09:59:00', 10 , '2021-03-03 11:59:00'),
            array('2021-03-02 09:59:00', 18 , '2021-03-04 11:59:00'),
            array('2021-03-09 13:59:00', 3 , '2021-03-09 16:59:00'),
          
          array('2021-03-09 16:58:00', 3 , '2021-03-10 11:58:00'),
            array('2021-03-09 16:59:00', 3 , '2021-03-10 11:59:00'),
            array('2021-03-08 09:00:00', 2 , '2021-03-08 11:00:00')
        );
    }

    /**
     * @dataProvider calculateDueDateTestData2_Workdays 
    */
    public function testCalculateDueDateWithParameters_WhenDateIsWeekday_ResolvedDateTomorrow2_ShouldReturnDateTime(string $submitDateTime, int $turnaruondTime, string $result){
        //prepare
        $dueDateCalculator = new DueDateCalculator();
        //act
        $resolvedDateTime = $dueDateCalculator->calculateDueDate(new DateTime($submitDateTime), $turnaruondTime);
        //assert
        $this->assertEquals(new DateTime($result), $resolvedDateTime);
    }

    public static function calculateDueDateTestData2_WorkdaysAfterWeekends()
    {
        return array(
            array('2021-03-04 09:00:00', 16 , '2021-03-08 09:00:00'),
            array('2021-03-05 10:00:00', 8 , '2021-03-08 10:00:00')
        );
    }

    /**
     * @dataProvider calculateDueDateTestData2_WorkdaysAfterWeekends 
    */
    public function testCalculateDueDateWithParameters_WhenDateIsWeekday_ShouldReturnWorkdaysAfterWeekends(string $submitDateTime, int $turnaruondTime, string $result){
        //prepare
        $dueDateCalculator = new DueDateCalculator();
        //act
        $resolvedDateTime = $dueDateCalculator->calculateDueDate(new DateTime($submitDateTime), $turnaruondTime);
        //assert
        $this->assertEquals(new DateTime($result), $resolvedDateTime);
    }

}
?>