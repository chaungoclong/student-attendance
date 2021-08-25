<?php 

use Carbon\Carbon;
/**
 * date time
 */
if (! function_exists('t_now')) {
	function t_now($dateString = '', $customFormat = 'dddd, HH:mm, DD/MM/YYYY'){
		// now
		$now = Carbon::now()->locale('vi');

		// other date: add hour, minute, second
		if ($dateString !== '') {
			$now = Carbon::parse($dateString)
				->locale('vi')
				->addHours($now->hour)
				->addMinutes($now->minute)
				->addSeconds($now->second);
		}

		return (object) [
			'day' => $now->dayOfWeekIso,
			'date' => $now->toDateString(),
			'time' => $now,
			'custom' => $now->isoFormat($customFormat)
		];
	}
}