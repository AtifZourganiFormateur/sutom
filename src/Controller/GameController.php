<?php

namespace App\Controller;

use App\Entity\Game;
use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\SerializerInterface;

class GameController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/api/game/{id}', name: 'app_game')]
    public function game(Game $game): JsonResponse
    {
        dd($game);
        return new JsonResponse([]);
    }

    #[Route('/api/game/data', name: 'app_game_data')]
    public function dataGameByPlayer(): JsonResponse
    {
        return new JsonResponse([]);
    }

    #[Route('/api/game/ref', name: 'app_game', methods:['GET'])]
    public function gameRef(SerializerInterface $serializer, GameRepository $gameRepository): JsonResponse
    {
        $user = $this->security->getUser();
        if (!$user) {
            return new JsonResponse(['error' => 'Unrecognized user'], JsonResponse::HTTP_UNAUTHORIZED);
        }
        $game = $gameRepository->findOneBy(['player' => $user, 'finished' => false]);
        //dd($user);
        if ($game) {
            $jsonGame = $serializer->serialize($game, 'json', ['groups' => 'getData']);
        } else {
            $game = new Game();
            $game->setPlayer($user);
            $game->setFinished(false);
            $game->setCreatedDate(new \DateTime('now'));
            $game->setTry(0);
            //faire un service qui tape dans l'api externe pour recuperer le word aléatoire
            $game->setWord('motde9car');
            
            dd($game);
            $jsonGame = $serializer->serialize($game, 'json', ['groups' => 'getData']);
        }
        return new JsonResponse($jsonGame, response::HTTP_OK, [], true);
    }
}
