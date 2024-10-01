<?php 

namespace App\Interface;

use App\Entity\Driver;

interface IDriverService
{
    function getAllDrivers(int $pageNumber = 1, int $perPage = 10, string $keyword = '') : array;
    function getDriver(int $id) : Driver;
}
