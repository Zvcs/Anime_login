<?php

namespace App\Controller;

use App\DTO\AnimeCreateFromInput;
use App\Entity\Anime;
use App\Form\AnimeType;
use App\Repository\AnimeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnimeController extends AbstractController
{

    public function __construct(private AnimeRepository $animeRepository, private EntityManagerInterface $entityInterface)
    {
    }

    #[Route('/', name: 'app_index', methods: ['GET'])]
    public function index(): Response
    {

        return $this->render('anime/index.html.twig', [
        ]);
    }

    #[Route('/anime', name: 'app_anime', methods: ['GET'])]
    public function animeList(Request $request): Response
    {
        $animeList = $this->animeRepository->findAll();

        return $this->render('anime/index.html.twig', [
            'animeList' => $animeList,
        ]);
    }

    #[Route('/anime/cadastrar', name: 'app_anime_form', methods: ['GET']) ]
    public function addAnimeForm(): Response
    {
        $animeForm = $this->createForm(AnimeType::class, new AnimeCreateFromInput());
        return $this->render('anime/form.html.twig', compact('animeForm'));
    }

    #[ROUTE('/anime/cadastrar', name: 'app_add_anime', methods: ['POST'])]
    public function addAnime(Request $request): Response
    {
        $input = new AnimeCreateFromInput();
        $animeForm = $this->createForm(AnimeType::class, $input)
            ->handleRequest($request);

        if (!$animeForm->isValid()) {
            return $this->render('anime/form.html.twig', compact('animeForm'));
        }

        $anime = new Anime(
        $input->Nome,
        $input->Temporadas,
        $input->quantidadeeps
        );

        $this->animeRepository->save($anime, true);
        return new RedirectResponse('/anime');
    }

     #[Route(
        '/anime/delete/{id}',
        name: 'app_delete_anime',
        methods: ['DELETE'],
        requirements: ['id' => '[0-9]+']
    )]
    public function deleteAnime(int $id): Response
    {
        $this->animeRepository->removeById($id);

        return new RedirectResponse('/anime');
    }

    #[ROUTE('/anime/edit/{anime}' , name: 'app_edit_anime_form', methods: ['GET'])]
    public function editAnimeForm(Anime $anime): Response
    {
        $animeForm = $this->createForm(AnimeType::class, $anime, ['is_edit' => true]);
        return $this->render('anime/form.html.twig', compact('animeForm' , 'anime'));
    }

    #[ROUTE('/anime/edit/{anime}', name:'app_store_aninme_changes', methods: ['PATCH'])]
    public function storeAninmeChanges(Anime $anime, Request $request)
    {
        $animeForm = $this->createForm(AnimeType::class, $anime, ['is_edit' => true]);
        $animeForm->handleRequest($request);

        if (!$animeForm->isValid()) {
            return $this->render('anime/form.html.twig', compact('animeForm', 'anime'));
        }

        $this->entityInterface->flush();

        return new RedirectResponse('/anime');
    }
}
