<?php
namespace App\Game\Hero;

class HtmlGenerator
{

    public static function createTable($characters)
    {
        $table = '<table class="table">';
        foreach ($characters as $character) {
            $table .= ' <thead><tr><th>Name</th><th>' . $character->getCharacterStats()['name'] . '</th></tr></thead>';

            $objProp = $character->getCharacterStats();
            foreach ($objProp as $key => $prop) {
                if (in_array($key, ['attack', 'luck', 'rapidStrike', 'magicShield'])) {
                    if ($prop) {
                        $class = 'attack';
                        $prop = 'YES';
                    } else {
                        $class = 'defend';
                        $prop = 'NO';
                    }

                    $table .= '<tr><td>' . $key . '</td><td class="' . $class . '">' . $prop . '</td></tr>';
                }

            }
        }
        $table .= "</table>";

        return $table;
    }

}

?>
