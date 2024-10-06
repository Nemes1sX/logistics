<?php

namespace App\Service;

use App\Entity\Trailer;
use App\Interface\ITrailerService;
use App\Repository\TrailerRepository;

class TrailerService implements ITrailerService
{
    private readonly TrailerRepository $trailerRepository;

    public function __construct(TrailerRepository $trailerRepository)
    {
        $this->trailerRepository = $trailerRepository;
    }

    public function getAllTrailers(int $pageNumber = 1, int $perPage = 10, string $name = '', string $status = '') : array
    {
        return $this->trailerRepository->findByNameOrStatus($pageNumber, $perPage, $name, $status);
    }

    public function getTotalTrailers(): int
    {
        return $this->trailerRepository->count();
    }

    public function getTrailer(int $id) : Trailer
    {
        return $this->trailerRepository->find($id);
    }
}