<?php 

namespace App\Interface;

use App\Entity\Trailer;

interface ITrailerService
{
    function getAllTrailers(int $pageNumber = 1, int $perPage = 10, string $name = '', string $status = '') : array;
    function getTrailer(int $id) : array;
    function getTotalTrailers(string $name = '', string $status = '') : int;
}
