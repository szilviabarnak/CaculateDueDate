<?php
final class DueDateCalculator{
    function isWorkingDay(DateTime $datetime){
        $julian_date = unixtojd($datetime->getTimestamp());
        $julian_dayofweek = jddayofweek($julian_date, 0);

        if($julian_dayofweek > 0 && $julian_dayofweek < 6){
            return true;
        }else{
            return false;
        }
    }

    function isWorkingHours(DateTime $datetime){
        if($this->isWorkingDay($datetime)){    
            $hour = $datetime->format('G');
            if($hour >= 9 && $hour <= 16){
                return true;
            }else{
                return false;
            }
        }

    }
    function howManyHoursLeft(DateTime $submitDateTime){
        if($this->isWorkingHours($submitDateTime)){
            $hour = (int)$submitDateTime->format('G');
            return 16 - $hour;
        }else{
            return 0;
        }
    }
    function calculateDueDate(DateTime $submitDateTime, int $turnaruondTime){
        if($this->isWorkingHours($submitDateTime)){
            $resolvedDateTime = new DateTime();
            $howManyHoursLeft = $this->howManyHoursLeft($submitDateTime);
            print_r($howManyHoursLeft);
            if($turnaruondTime <= $howManyHoursLeft){
                $turnaruondTime_DateInterval = new DateInterval('P0Y0M0DT'.$turnaruondTime.'H0M0S');
                $resolvedDateTime = $submitDateTime->add($turnaruondTime_DateInterval);
                return $resolvedDateTime;
            }else{
                $days = floor($turnaruondTime/8);
                if($days == 0){
                    //át kell billeneteni a napot
                    $days++;
                }
                if($turnaruondTime%8 == 0){
                    $turnaruondTime_DateInterval = new DateInterval('P0Y0M'.$days.'DT0H0M0S');
                    $submitDateTime_Ymd = $submitDateTime;
                }else{
                    $remaining = ($turnaruondTime-$howManyHoursLeft)%8;
                    $remaining--;
                    $turnaruondTime_DateInterval = new DateInterval('P0Y0M'.$days.'DT'.$remaining.'H0M0S');
                    $submitDateTime_Ymd = new DateTime($submitDateTime->format('Y-m-d 09:i:s'));
                }
                
                
                
                $submitDateTime_Ymd = $submitDateTime_Ymd->add($turnaruondTime_DateInterval);
                if(!$this->isWorkingDay($submitDateTime_Ymd)){
                    $submitDateTime_Ymd->add(new DateInterval('P0Y0M1DT0H0M0S'));
                    if(!$this->isWorkingDay($submitDateTime_Ymd)){
                        $submitDateTime_Ymd->add(new DateInterval('P0Y0M1DT0H0M0S'));
                    }
                }
                return $submitDateTime_Ymd;
                
                
            }
            
        }else{
            return false;
        }
        
    }
}
?>