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

namespace CalendArt\Adapter\Google\Event;

use InvalidArgumentException;

use CalendArt\Adapter\Google\Calendar,
    CalendArt\Adapter\Google\AbstractEvent;

/**
 * Represents a cancelled recurring event if we did not fetch the deleted events from google
 *
 * the one that are not complete, yes. <3 Google :(
 *
 * @author Baptiste Clavie <baptiste@wisembly.com>
 */
class ShortCancelledRecurringEvent extends AbstractEvent
{
    /** @var BasicEvent */
    private $parent;

    public static function hydrate(Calendar $calendar, array $data)
    {
        if (!isset($data['recurringEventId'])) {
            throw new InvalidArgumentException(sprintf('Missing at least the following mandatory property "recurringEventId" ; got ["%s"]', implode('", "', array_keys($data))));
        }

        $event = parent::hydrate($calendar, $data);

        if (isset($data['originalStartTime'])) {
            $event->start = static::buildDate($data['originalStartTime']);
        }

        // todo : check if the event is a recurring event (when the object will be made)
        $parent = $calendar->getEvents()->filter(function (AbstractEvent $event) use ($data) { return $data['recurringEventId'] === $event->getId(); })->first();

        if (false === $parent) {
            throw new InvalidArgumentException('Original recurring event not found');
        }

        $event->parent = $parent;

        return $event;
    }
}

