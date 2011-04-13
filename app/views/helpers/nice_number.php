<?php
class NiceNumberHelper extends Helper{

        function getNiceTime($dstr)
        {
                $dest = $this->convert_datetime($dstr);

                $sour = (func_num_args() == 1) ? time() : func_get_arg(1);

                $tt = $dest - $sour;

                if ($tt / SECYEAR  < -1)        $nicetime = abs(round($tt / SECYEAR))    . 'years ago';
                elseif ($tt / SECMONTH < -1)        $nicetime = abs(round($tt / SECMONTH))   . 'months ago';
                elseif ($tt / SECWEEK  < -1)        $nicetime = abs(round($tt / SECWEEK))    . 'weeks ago';
                elseif ($tt / SECDAY   < -1)        $nicetime = abs(round($tt / SECDAY))     . 'days ago';
                elseif ($tt / SECHOUR  < -1)        $nicetime = abs(round($tt / SECHOUR))    . 'hours ago';
                elseif ($tt / SECMINUITE < -1)      $nicetime = abs(round($tt / SECMINUITE)) . 'minutes ago';
                elseif ($tt < 0)                    $nicetime = abs(round($tt)) . 'seconds ago';
                elseif ($tt / SECYEAR  > +1)        $nicetime = abs(round($tt / SECYEAR))    . 'years after';
                elseif ($tt / SECMONTH > +1)        $nicetime = abs(round($tt / SECMONTH))   . 'months after';
                elseif ($tt / SECWEEK  > +1)        $nicetime = abs(round($tt / SECWEEK))    . 'weeks after';
                elseif ($tt / SECDAY   > +1)        $nicetime = abs(round($tt / SECDAY))     . 'days after';
                elseif ($tt / SECHOUR  > +1)        $nicetime = abs(round($tt / SECHOUR))    . 'hours after';
                elseif ($tt / SECMINUITE > +1)      $nicetime = abs(round($tt / SECMINUITE)) . 'minutes after';
                elseif ($tt > 0)                    $nicetime = abs(round($tt)) . 'seconds after';
                else $nicetime = 'just now';

		return $this->output($nicetime);
        }

        function convert_datetime($str) {
                list($date, $time) = explode(' ', $str);
                list($year, $month, $day) = explode('-', $date);
                list($hour, $minute, $second) = explode(':', $time);
                $timestamp = mktime($hour, $minute, $second, $month, $day, $year);
                return $timestamp;
        }
}
?>
