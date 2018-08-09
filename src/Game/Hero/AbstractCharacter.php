<?php

namespace App\Game\Hero;

abstract class AbstractCharacter
{
    protected $_characterStats;

    /**
     * AbstractCharacter constructor.
     * @param array $characterInfo
     */
    public function __construct(Array $characterInfo)
    {
        foreach ($characterInfo as $key => $value) {
            if (isset($characterInfo[$key])) {
                $this->_characterStats[$key] = $value;
            }
        }
    }

    /**
     * @return mixed
     */
    public function getCharacterStats()
    {
        return $this->_characterStats;
    }


    /**
     * @param $key
     * @param $val
     */
    public function setStat($key, $val)
    {
        $this->_characterStats[$key] = $val;
    }

    public function getStat($key)
    {
        return $this->_characterStats[$key] ?? 0;
    }

}
