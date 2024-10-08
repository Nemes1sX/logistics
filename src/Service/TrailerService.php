<?php

namespace App\Service;

use App\Entity\Trailer;
use App\Interface\ITrailerService;
use App\Repository\TrailerRepository;
use Symfony\Component\Serializer\SerializerInterface;

class TrailerService extends BaseService implements ITrailerService
{
    private readonly TrailerRepository $trailerRepository;

    public function __construct(SerializerInterface $serializer, TrailerRepository $trailerRepository)
    {
        parent::__construct($serializer);
        $this->trailerRepository = $trailerRepository;
    }

    public function getAllTrailers(int $pageNumber = 1, int $perPage = 10, string $name = '', string $status = '') : array
    {
        $context = [
            'groups' => ['list_trailer'], 
        ];

        $trailers = $this->trailerRepository->findByNameOrStatus($pageNumber, $perPage, $name, $status);

        return json_decode($this->serializer->serialize($trailers, 'json', $context), true);
    }

    public function getTotalTrailers(string $name = '', string $status = ''): int
    {
        return $this->trailerRepository->totalTrailers($name, $status);
    }

    public function getTrailer(int $id) : array
    {
        $context = [
            'groups' => ['show_trailer'], 
        ];

        $trailer = $this->trailerRepository->find($id);

        return json_decode($this->serializer->serialize($trailer, 'json', $context), true);
    }
}