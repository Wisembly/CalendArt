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

use InvalidArgumentException;

/**
 * Represents a recurrence rule, based on RFC 2445
 *
 * Example rules :
 *
 * @link http://www.ietf.org/rfc/rfc2445 RFC 2445
 * @author Baptiste Clavie <baptiste@wisembly.com>
 */
class Rule
{
    private $frequency;

    /** @var AbstractEnding Rule of ending for this rule (count, until, none) */
    private $ending;

    /** @var integer */
    private $interval = 1;

    /** @var [] conditions */
    private $conditions = [];

    /** @return integer */
    public function getInterval()
    {
        return $this->interval;
    }

    /** @return AbstractEnding */
    public function getEnding()
    {
        return $this->ending;
    }

    public function __toString()
    {
        return $this->frequency;
    }

    /**
     * Parse a rule to fetch the correct one, and let this sub-rule parse itself
     *
     * @param string $ruleStr RRULE to parse
     * @return AbstractRule the correct rule
     */
    public static function parse($ruleStr)
    {
        if ('RRULE:' !== substr($ruleStr, 0, 6)) {
            throw new InvalidArgumentException('Expected a RRULE');
        }

        $tokens = [];

        $rule   = new static;
        $ending = null;

        foreach (explode(';', substr($ruleStr, 6)) as $token) {
            list($name, $value) = explode('=', $token, 2);

            /** tokens extracted from {@link http://www.kanzaki.com/docs/ical/recur.html} */
            switch($name) {
                // frequency
                case 'FREQ':
                    $rule->frequency = self::getRuleFromFrequency($value);
                    break;

                // ending
                case 'COUNT':
                case 'UNTIL':

                // interval
                case 'INTERVAL':

                // matching rules
                case 'BYSECOND':
                case 'BYMINUTE':
                case 'BYHOUR':
                case 'BYDAY':
                case 'BYMONTHDAY':
                case 'BYYEARDAY':
                case 'BYWEEKNO':
                case 'BYMONTH':
                case 'BYSETPOS':

                // week start
                case 'WKST':

                    break;

                default:
                    throw new InvalidArgumentException(sprintf('Invalid token found ("%s", "%s")', $name, $value));
            }
        }
    }

    private static function getRuleFromFrequency($frequency)
    {
        switch ($frequency) {
            default:
                throw new InvalidArgumentException('The frequency is not supported yet');
        }
    }
}

