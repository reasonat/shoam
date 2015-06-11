<?php
// $Id: calendar-datebox.tpl.php,v 1.2.2.3 2010/11/21 14:15:32 karens Exp $
/**
 * @file 
 * Template to display the date box in a calendar.
 *
 * - $view: The view.
 * - $granularity: The type of calendar this box is in -- year, month, day, or week.
 * - $mini: Whether or not this is a mini calendar.
 * - $class: The class for this box -- mini-on, mini-off, or day.
 * - $day:  The day of the month.
 * - $date: The current date, in the form YYYY-MM-DD.
 * - $link: A formatted link to the calendar day view for this day.
 * - $url:  The url to the calendar day view for this day.
 * - $selected: Whether or not this day has any items.
 * - $items: An array of items for this day.
 */
?>
<div class="<?php print $granularity ?> <?php print $class; ?>"> <?php print $selected ? $link : $day; ?> </div>
<?php if ($granularity == "month") {

	global $language; 
	//  needed for hebrew dates
	require_once('JewishCalendar.php');
	 
	$jcal = NativeCalendar::factory('Jewish');
	$jcal->settings(array(   
		'language' => ($language->language == 'he' ? CAL_LANG_NATIVE : CAL_LANG_FOREIGN),
		'diaspora' => FALSE,           // We don't live abroad.
		'eves'     => FALSE,            // Give us 'Erev Rosh HaShana' too.
	));

	echo $jcal->getShortDate($date);
	
	if (!$mini) {			
		$holiday = $jcal->getHolidays($date);
		$first_key = array_shift($holiday);			
		print "<b> $first_key[name] </b>";
		
	}
	}
?>
