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

// count day of month by name
function count_day_by_name($nameOfDay = '', $timeString = '') {
  $startMonth = $timeString ? Carbon::parse($timeString)->startOfMonth() 
                            : Carbon::today()->startOfMonth();
  
  $endMonth = $startMonth->copy()->endOfMonth();
  
  $nameOfDay = ucfirst(strtolower($nameOfDay));
  
  $nameMethod = '';
  
  switch($nameOfDay) {
    case 'Monday':
      $nameMethod = "isMonday";
      break;
    case 'Tuesday':
      $nameMethod = "isTuesday";
      break;
    case 'Wednesday':
      $nameMethod = "isWednesday";
      break;
    case 'Thursday':
      $nameMethod = "isThursday";
      break;
    case 'Friday':
      $nameMethod = "isFriday";
      break;
    case 'Saturday':
      $nameMethod = "isSaturday";
      break;
    case 'Sunday':
      $nameMethod = "isSunday";
      break;
    default:
      $nameMethod = "isMonday";
      break;
  }
  
  $count = $startMonth->diffInDaysFiltered(function($date) use($nameMethod) {
    return $date->$nameMethod();
  }, $endMonth);
  
  return $count;
}