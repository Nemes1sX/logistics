<?php

namespace App\Controller;

use App\DTOs\TrailersDTO;
use App\Entity\Trailer;
use App\Interface\ITrailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;

#[Route('/api/trailers', name: 'trailer_')]
class TrailerController extends AbstractController
{
    private readonly ITrailerService $trailerService;
 
    public function __construct(ITrailerService $trailerService)
    {
        $this->$trailerService = $trailerService;
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Returns all drivers',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: TrailersDTO::class, groups: ['full']))
        )
    )]
    #[OA\Parameter(
        name: 'per_page',
        in: 'query',
        description: 'The field used to show records per page',
        schema: new OA\Schema(type: 'int')
    )]
    #[OA\Parameter(
        name: 'page_number',
        in: 'query',
        description: 'The field used to show page of records',
        schema: new OA\Schema(type: 'int')
    )]
    #[OA\Parameter(
        name: 'name',
        in: 'query',
        description: 'The keyword is used to search trailer by name',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
        name: 'status',
        in: 'query',
        description: 'The keyword is used to search trailers by status',
        schema: new OA\Schema(type: 'string')
    )]
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->query->get('per_page', 10);
        $pageNumber = $request->query->get('page', 1);
        $name = $request->query->get('name', '');
        $status = $request->query->get('status', '');
        
        $trailers = $this->trailerService->getAllTrailers($pageNumber, $perPage, $name, $status); 
        $totalRecords = $this->trailerService->getTotalTrailers();
   
         
        return $this->json([
            'data' => array_map(function (Trailer $trailer) {
                return new TrailersDTO($trailer);
            }, $trailers),
            'pageNumber' => $pageNumber,
            'totalRecords' => $totalRecords,
            'totalPages' => ceil($totalRecords / $perPage)
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])] 
    #[OA\Response(
        response: 200,
        description: 'Returns single trailer',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: Trailer::class, groups: ['full']))
        )
    )]
    #[OA\Parameter(
        name: 'id',
        in: 'query',
        description: 'Id of the trailer',
        schema: new OA\Schema(type: 'int')
    )]
    public function show(int $id) : JsonResponse
    {
        $trailer = $this->trailerService->getTrailer($id);

        return $this->json($trailer, 200);
    }

}
