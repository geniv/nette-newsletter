<?php declare(strict_types=1);

namespace Newsletter\Events;

use Dibi\Connection;
use GeneralForm\IEvent;
use GeneralForm\IEventContainer;
use Nette\SmartObject;


/**
 * Class DibiEvent
 *
 * @author  geniv
 * @package Newsletter\Events
 */
class DibiEvent implements IEvent
{
    use SmartObject;

    /** @var Connection */
    protected $connection;


    /**
     * DibiEvent constructor.
     *
     * @param Connection $connection
     */
    public function __construct(string $tablePrefix, Connection $connection)
    {
        $this->connection = $connection;
    }

//FIXME prepsat!!


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
