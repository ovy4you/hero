<?php

namespace App\Controller;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Game\Hero\{
    Game, HtmlGenerator, Session, Bot, Player
};


class GameController extends Controller
{


    /**
     * @Route("/game", name="game")
     */
    public function index()
    {

        $limit = 20;

        $game = new Game(new Session, $limit);

        $game->initGame([new Bot(['name' => 'Beast']), new Player(['name' => 'Orderus'])]);

        try {
            $game->battle($game->getCharacters());
        } catch (Exception $e) {
            return new Response($e->getMessage());
        }

        return $this->render('game/index.html.twig', [
            'data' => ['game' => HtmlGenerator::createTable($game->getCharacters()), 'round' => $game->getRound() ?? 0]
        ]);
    }

}



