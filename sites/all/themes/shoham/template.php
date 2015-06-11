<?php

/**
* Returns array of hebrew dat parts
*
* @param integer $year
* @param integer $month
* @param integer $day
* @return array (year, month, day)
*
function get_hebrew_date_parts ($year, $month, $day) {

    $jdDate = gregoriantojd($month,$day,$year);

    $hebrewMonthName = jdmonthname($jdDate,4);

    $hebrewDate = jdtojewish($jdDate);

    list($hebrewMonth, $hebrewDay, $hebrewYear) = split('/',$hebrewDate);

    return array('year' => $hebrewYear, 'month' => $hebrewMonth, 'day' => $hebrewDay, 'monthname' => $hebrewMonthName);
}
*/



/**
 * Theme the calendar title
 */
function shoham_date_nav_title($params) {
  $granularity = $params['granularity'];
  $view = $params['view'];
  $date_info = $view->date_info;
  $link = !empty($params['link']) ? $params['link'] : FALSE;
  $format = !empty($params['format']) ? $params['format'] : NULL;
  switch ($granularity) {
    case 'year':
      $title = $date_info->year;
      $date_arg = $date_info->year;
      break;
    case 'month':
      $format = !empty($format) ? $format : (empty($date_info->mini) ? 'F Y' : 'F');
      $title = date_format_date($date_info->min_date, 'custom', $format);
      $date_arg = $date_info->year . '-' . date_pad($date_info->month);
      break;
    case 'day':
      $format = !empty($format) ? $format : (empty($date_info->mini) ? 'l, F j, Y' : 'l, F j');
      $title = date_format_date($date_info->min_date, 'custom', $format);
      $date_arg = $date_info->year . '-' . date_pad($date_info->month) . '-' . date_pad($date_info->day);
      break;
    case 'week':
      $format = !empty($format) ? $format : (empty($date_info->mini) ? 'F j, Y' : 'F j');
      $title = t('Week of @date', array('@date' => date_format_date($date_info->min_date, 'custom', $format)));
      $date_arg = $date_info->year . '-W' . date_pad($date_info->week);
      break;
  }

 /**********************************************************************/
 /* Add hebrew months to the title                                     */
 /**********************************************************************/
  if ($granularity == 'month') {  
    global $language; 
    //require_once($base_path.path_to_theme()."/JewishCalendar.php");
    $jcal = NativeCalendar::factory('Jewish');
    $jcal->settings(array(   
      'language' => ($language->language == 'he' ? CAL_LANG_NATIVE : CAL_LANG_FOREIGN),
      'diaspora' => FALSE,           // We don't live abroad.
      'eves'     => FALSE,            // Give us 'Erev Rosh HaShana' too.
    ));

    $j_min_date = $jcal->convertToNative($date_info->min_date); 
    $j_max_date = $jcal->convertToNative($date_info->max_date);
    $title = $jcal->getMonthName($j_min_date['year'], $j_min_date['mon']);
    $title .= "-".$jcal->getMonthName($j_max_date['year'], $j_max_date['mon']); 
  }
  /**********************************************************************/

  if (!empty($date_info->mini) || $link) {
    // Month navigation titles are used as links in the mini view.
    $attributes = array('title' => t('View full page month'));
    $url = date_pager_url($view, $granularity, $date_arg, TRUE);
    return l($title, $url, array('attributes' => $attributes));
  }
  else {
    return $title;
  }
}

/**********************************************************************/
 /* Dispaly date field as hebrew date                                 */
 /**********************************************************************/
function shoham_preprocess_field(&$vars, $hook) {
  $element = $vars['element']; 
  if ($element['#field_name'] == 'field_date') {    
    
    $odate = $vars['element']['#items'][0]['value'];
    
    global $language; 
    //  needed for hebrew dates
    require_once("templates/JewishCalendar.php");
 
    $jcal = NativeCalendar::factory('Jewish');
    $jcal->settings(array(   
      'language' => ($language->language == 'he' ? CAL_LANG_NATIVE : CAL_LANG_FOREIGN),
      'diaspora' => FALSE,           // We don't live abroad.
      'eves'     => FALSE,            // Give us 'Erev Rosh HaShana' too.
    ));    
    
    $vars['items'][0]['#markup']=$jcal->getLongDate($odate);
      
  }
}


