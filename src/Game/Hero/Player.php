<?php

namespace App\Game\Hero;

class Player extends AbstractCharacter
{

    public function __construct($info)
    {
        parent::__construct($info);

        $this->_characterStats['health'] = rand(70, 100);
        $this->_characterStats['strength'] = rand(70, 80);
        $this->_characterStats['defence'] = rand(45, 55);
        $this->_characterStats['speed'] = rand(40, 50);
        $this->_characterStats['rapidStrike'] = rand(1, 100) < 10;
        $this->_characterStats['luck'] = rand(1, 100) < rand(10, 30);
        $this->_characterStats['magicShield'] = rand(1, 100) <= 20;

    }

    /**
     * @param $character
     */
    public function regenerateSkills()
    {

        $this->_characterStats['luck'] = rand(1, 100) < rand(10, 30);
        $this->_characterStats['rapidStrike'] = rand(1, 100) < 10;
        $this->_characterStats['magicShield'] = rand(1, 100) <= 20;

        if ($this->_characterStats['rapidStrike']) {
            $this->_characterStats['attack'] = true;
        } else {
            $this->_characterStats['attack'] = false;
        }
    }


    public function resetSkills()
    {
        $this->_characterStats['luck'] = false;
        $this->_characterStats['rapidStrike'] = false;
        $this->_characterStats['magicShield'] = false;
        $this->_characterStats['attack'] = true;
    }


}
