<?php

namespace App\Controller\Api;

use App\Repository\VolunteerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class VolunteerController extends AbstractController
{
    #[IsGranted('IS_AUTHENTICATED')]
    #[Route('/api/volunteers', name: 'app_api_volunteers')]
    public function getVolunteersApi(VolunteerRepository $repository): array
    {
        return $repository->findAll();
    }
}
