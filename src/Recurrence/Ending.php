<?php
/**
 * This file is part of the CalendArt package
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 *
 * @copyright Wisembly
 * @license   http://www.opensource.org/licenses/MIT-License MIT License
 */

namespace CalendArt\Recurrence;

/**
 * Value object that represents when a recurring event should end
 *
 * @author Baptiste Clavie <baptiste@wisembly.com>
 */
class Ending
{
    /** @var string count or until */
    private $type;

    /** @var integer|Datetime */
    private $value;

    public function __construct($type, $value)
    {
        $this->type  = $type;
        $this->value = $value;
    }

    /** @return integer|Datetime */
    public function getValue()
    {
        return $this->value;
    }

    /** @return string */
    public function getType()
    {
        return $this->type;
    }
}

