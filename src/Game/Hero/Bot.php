<?php

namespace App\Game\Hero;

class Bot extends AbstractCharacter
{

    public function __construct($info)
    {
        parent::__construct($info);

        $this->_characterStats['health'] = rand(60, 90);
        $this->_characterStats['strength'] = rand(60, 90);
        $this->_characterStats['defence'] = rand(40, 60);
        $this->_characterStats['speed'] = rand(40, 60);
        $this->_characterStats['luck'] = rand(1, 100) < rand(25, 45);

    }

    public function regenerateSkills()
    {
        $this->_characterStats['luck'] = rand(1, 100) < rand(25, 45);
        $this->_characterStats['attack'] = false;
    }

    public function resetSkills()
    {
        $this->_characterStats['luck'] = false;
        $this->_characterStats['attack'] = true;
    }


}
