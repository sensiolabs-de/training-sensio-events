<?php

namespace App\Controller\Api;

use App\Repository\VolunteerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

class VolunteerController extends AbstractController
{
    #[IsGranted('IS_AUTHENTICATED')]
    #[Route('/api/volunteers', name: 'app_api_volunteers')]
    public function getVolunteersApi(Request $request, VolunteerRepository $repository, SerializerInterface $serializer): Response
    {
        $limit = 20;
        $page = $request->query->getInt('page', 1);
        $volunteers = $repository->findBy([], [], $limit, ($page - 1) * $limit);

        $data =  $serializer->serialize($volunteers, 'json');

        return new JsonResponse($data, Response::HTTP_OK, json: true);
    }
}
