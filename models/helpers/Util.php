<?php
/**
 * Created by PhpStorm.
 * User: gurikin
 * Date: 27.03.19
 * Time: 0:47
 */

namespace app\models\helpers;

class Util
{
    /**
     * @param mixed ...$segments
     * @return string
     */
    public static function file_build_path(...$segments) {
        return join(DIRECTORY_SEPARATOR, $segments);
    }
}