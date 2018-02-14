<?php declare(strict_types=1);

namespace Newsletter;

use GeneralForm\IEvent;
use GeneralForm\IEventContainer;


/**
 * Class DibiEvent
 *
 * @author  geniv
 * @package Newsletter
 */
class DibiEvent implements IEvent
{

    /**
     * Update.
     *
     * @param IEventContainer $eventContainer
     * @param array           $values
     */
    public function update(IEventContainer $eventContainer, array $values)
    {
        // TODO: Implement update() method.
    }
}
