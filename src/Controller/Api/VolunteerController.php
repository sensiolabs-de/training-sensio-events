<?php

namespace App\Controller\Api;

use App\Repository\VolunteerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VolunteerController extends AbstractController
{
    #[Route('/api/volunteers', name: 'app_api_volunteers')]
    public function getVolunteersApi(VolunteerRepository $repository): array
    {
        return $repository->findAll();
    }
}
