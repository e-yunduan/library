<?php
namespace common\traits;

/**
 * Trait ClassTrait
 *
 */
trait ClassTrait
{
    /**
     * Returns the fully qualified name of this class.
     * @return string the fully qualified name of this class.
     */
    public static function className()
    {
        return get_called_class();
    }
}