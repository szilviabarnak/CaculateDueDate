<?php
final class DueDateCalculator{
    private function dateToSec(DateTime $datetime){
        $biz = array_map('intval', explode(":", $datetime->format("H:i:s")));
        return $biz[0]*60*60 + $biz[1]*60 + $biz[2];
    }
    private function isWorkingDay(DateTime $datetime){
        $julian_date = unixtojd($datetime->getTimestamp());
        $julian_dayofweek = jddayofweek($julian_date, 0);
        return ($julian_dayofweek > 0 && $julian_dayofweek < 6);
    }

    private function isWorkingHours(DateTime $datetime){
        if(!$this->isWorkingDay($datetime)){
            return false;
        }
        $dateToSec = $this->dateToSec($datetime);
        return ($dateToSec >= 9*60*60 && $dateToSec <= 17*60*60);
        
    }
    private function howManyTimeLeft(DateTime $datetime){
        if($this->isWorkingHours($datetime)){
            return 17*60*60 - $this->dateToSec($datetime);
        }
        return 0;
    }
    public function calculateDueDate(DateTime $submitDateTime, int $turnaruondTime){
        if(!$this->isWorkingHours($submitDateTime)){
            throw new Exception("Nem munkaido");
        }
        $howManyTimeLeft = $this->howManyTimeLeft($submitDateTime);
        
        $turnaruondTimeInSec = $turnaruondTime*60*60;
        

        $backToMorning = $turnaruondTimeInSec + 8*60*60 - $howManyTimeLeft;
        $days = floor($backToMorning/(8*60*60));
        
        $remainingTime = $backToMorning%(8*60*60);
        $remainingTimeF = $backToMorning%(8*60*60) + $days*24*60*60;
        
        $resolvedDateTime = new DateTime($submitDateTime->format('Y-m-d 09:00:00'));
      
        
        $turnaruondTime_DateInterval = new DateInterval('P0Y0M0DT0H0M'.$remainingTimeF.'S');
        $resolvedDateTime->add($turnaruondTime_DateInterval);
        
        if(!$this->isWorkingDay($resolvedDateTime)){
            $resolvedDateTime->add(new DateInterval('P0Y0M1DT0H0M0S'));
            if(!$this->isWorkingDay($resolvedDateTime)){
                $resolvedDateTime->add(new DateInterval('P0Y0M1DT0H0M0S'));
            }
        }
        return $resolvedDateTime;
    }
}
?>