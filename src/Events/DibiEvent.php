<?php declare(strict_types=1);

namespace Newsletter\Events;

use Dibi\Connection;
use GeneralForm\IEvent;
use GeneralForm\IEventContainer;
use Locale\ILocale;
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

    // define constant table names
    const
        TABLE_NAME = 'newsletter';

    /** @var string */
    private $tableNewsletter;
    /** @var Connection */
    protected $connection;
    /** @var int */
    private $idLocale;


    /**
     * DibiEvent constructor.
     *
     * @param string     $tablePrefix
     * @param Connection $connection
     * @param ILocale    $locale
     */
    public function __construct(string $tablePrefix, Connection $connection, ILocale $locale)
    {
        // define table names
        $this->tableNewsletter = $tablePrefix . self::TABLE_NAME;
        $this->connection = $connection;
        $this->idLocale = $locale->getId();
    }

//FIXME prepsat!!


    /**
     * Update.
     *
     * @param IEventContainer $eventContainer
     * @param array           $values
     * @throws \Dibi\Exception
     */
    public function update(IEventContainer $eventContainer, array $values)
    {
        $arr = [
            'id_locale' => $this->idLocale,
            'email'     => $values['email'],
            'added%sql' => 'NOW()',
            'ip'        => $_SERVER['REMOTE_ADDR'],
        ];

        $ret = $this->connection->insert($this->tableNewsletter, $arr)->execute();
        if ($ret > 0) {
            $this->onSuccess($values);
        }
    }
}
