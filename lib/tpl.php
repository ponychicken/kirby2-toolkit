<?php

/**
 * Tpl
 *
 * Super simple template engine
 *
 * @package   Kirby Toolkit
 * @author    Bastian Allgeier <bastian@getkirby.com>
 * @link      http://getkirby.com
 * @copyright Bastian Allgeier
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Support for multiple template engines based on:
 * https://github.com/lehni/kirbycms by Juerg Lehni <juerg@scratchdisk.com>
 * Ported to Kirby 2 by Leo Koppelkamm <hello@leo-koppelkamm.de>
 */
class Tpl extends Silo {

  static public $data = array();

  static public function load($file, $data = array(), $return = true) {
    if(!file_exists($file)) return false;
    $extension = pathinfo($file, PATHINFO_EXTENSION);
    $engines = c::get('tpl.engines');
    $engine = $engines[$extension];

    if ($engine) $file = $engine($file);

    return self::loadFile($file, $data, $return);
  }

  static public function loadFile($file, $data = array(), $return = true) {
    if(!file_exists($file)) return false;
    ob_start();
    extract(array_merge(static::$data, (array)$data));
    require($file);
    $content = ob_get_contents();
    ob_end_clean();
    if($return) return $content;
    echo $content;
  }

}