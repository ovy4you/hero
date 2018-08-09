<?php

namespace App\Game\Hero;


use Symfony\Component\Config\Definition\Exception\Exception;

class Game
{

    public $status;
    protected $_storage;
    protected $_round;
    private $_limit;

    /**
     * Game constructor.
     * @param $session
     * @param $limit
     */
    public function __construct($session,$limit)
    {
        $this->_storage = $session;
        $this->_limit = $limit;
    }

    /**
     * @param $character
     * @param $info
     * @return mixed
     * @throws \Exception
     */
    public function createCharacter($character, $info)
    {

        if (!$character) {
            throw new \Exception('Invalid Option');
        }


        return  new $character($info);

    }

    /**
     * @param $character
     */
    public function saveCharacter($character)
    {
        $this->_storage->saveCharacter($character->getCharacterStats()['name'], serialize($character));
    }

    public function getCharacter($key)
    {
        return unserialize($this->_storage->getCharacter($key));
    }

    public function getCharacters()
    {
        foreach ($this->_storage->getCharacters() as $characterSaved) {
            $characters[] = unserialize($characterSaved);
        }
        return $characters;
    }

    /**
     * @param $characters
     */
    public function setFirstAttacker($characters)
    {
        if ($characters[0]->getCharacterStats()['speed'] > $characters[1]->getCharacterStats()['speed']) {
            $characters[0]->setStat('attack', true);
        } elseif ($characters[1]->getCharacterStats()['speed'] > $characters[0]->getCharacterStats()['speed']) {
            $characters[1]->setStat('attack', true);
        } else {
            if ($characters[1]->getCharacterStats()['luck'] > $characters[1]->getCharacterStats()['luck']) {
                $characters[0]->setStat('attack', true);
            } else {
                $characters[1]->setStat('attack', true);

            }
        }

        if (!empty($characters[1]->getStat('attack'))) {
            $this->saveCharacter($characters[1]);
        } else {
            $this->saveCharacter($characters[0]);
        }
    }

    /**
     * @param $characters
     * @param $stats
     * @throws \Exception
     */
    public function battle($characters)
    {
        $round = $this->_storage->get('round') ?: 0;
        $this->_storage->set('round', ++$round);
        if ($this->_storage->get('round') > $this->_limit) {
            throw new \Exception('Game over - limit reached');
        }
        $this->attack($characters);
    }

    /**
     * @return mixed
     */
    public function getRound()
    {
        return $this->_storage->get('round');
    }


    /**
     * @param $characters
     * @param $stats
     */
    public function attack($characters)
    {

        if (!empty($characters[0]->getCharacterStats()['attack'])) {

            $characters[0]->regenerateSkills();

            $damage = $characters[1]->getStat('luck') ? 0 : $characters[0]->getCharacterStats()['strength'] - $characters[1]->getCharacterStats()['defence'];

            $defenderDamage = $characters[1]->getCharacterStats()['health'] - $damage;


            if ($defenderDamage > 0) {
                $characters[1]->setStat('health', $defenderDamage);
                $characters[1]->resetSkills();
                if ($characters[0]->getStat('rapidStrike')) {
                    $characters[1]->setStat('attack', false);
                    $characters[0]->setStat('attack', true);
                } else {
                    $characters[0]->setStat('attack', false);
                }
            } else {
                throw  new Exception('Game over ' . $characters[0]->getCharacterStats()['name'] . ' won!');
            }
        } else {
            $damage = $characters[0]->getStat('luck') ? 0 : $characters[1]->getCharacterStats()['strength'] - $characters[0]->getCharacterStats()['defence'];

            $characters[1]->regenerateSkills();

            if ($characters[0]->getStat('magicShield')) {
                $damage /= 2;
            }
            $defenderDamage = $characters[0]->getCharacterStats()['health'] - $damage;

            if ($defenderDamage > 0) {
                $characters[0]->setStat('health', $defenderDamage);
                $characters[0]->resetSkills();
            } else {
                throw  new Exception('Game over ' . $characters[1]->getCharacterStats()['name'] . ' won!');
            }
        }

        foreach ($characters as $character) {
            $this->saveCharacter($character);
        }

    }


    public function resetGame()
    {
        $this->_storage->clearStorage();
    }

    /**
     * @param $characters
     */
    public function initGame( Array $characters)
    {

        if (!$this->_storage->get('startGame')) {


            foreach ($characters as $character) {
                $this->saveCharacter($character);
            }

            $this->setFirstAttacker($this->getCharacters());

        };
        $this->_storage->set('startGame', 1);
    }

}
