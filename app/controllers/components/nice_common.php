<?php
class NiceCommonComponent extends Object{

	function getNiceTime($dest)
	{
		$sour = (func_num_args() == 1) ? time() : func_get_arg(1);

		$tt = $dest - $sour;

		if ($tt / SECYEAR  < -1)	return abs(round($tt / SECYEAR))    . '年前';
		if ($tt / SECMONTH < -1)	return abs(round($tt / SECMONTH))   . 'ヶ月前';
		if ($tt / SECWEEK  < -1)	return abs(round($tt / SECWEEK))    . '週間前';
		if ($tt / SECDAY   < -1)	return abs(round($tt / SECDAY))     . '日前';
		if ($tt / SECHOUR  < -1)	return abs(round($tt / SECHOUR))    . '時間前';
		if ($tt / SECMINUITE < -1)	return abs(round($tt / SECMINUITE)) . '分前';
		if ($tt < 0)				return abs(round($tt)) . '秒前';
		if ($tt / SECYEAR  > +1)	return abs(round($tt / SECYEAR))    . '年後';
		if ($tt / SECMONTH > +1)	return abs(round($tt / SECMONTH))   . 'ヶ月後';
		if ($tt / SECWEEK  > +1)	return abs(round($tt / SECWEEK))    . '週間後';
		if ($tt / SECDAY   > +1)	return abs(round($tt / SECDAY))     . '日後';
		if ($tt / SECHOUR  > +1)	return abs(round($tt / SECHOUR))    . '時間後';
		if ($tt / SECMINUITE > +1)	return abs(round($tt / SECMINUITE)) . '分後';
		if ($tt > 0)				return abs(round($tt)) . '秒後';
		return '現在';
	}
}
?>
