<?php 

namespace App\Interface;

use App\Entity\Truck;

interface ITruckService
{
    function getAllTrucks(int $pageNumber = 1, int $perPage = 10, string $manufacturer = '', string $status = '') : array;
    function getTruck(int $id) : array;
    function getTotalTrucks(string $manufacturer = '', string $status = '') : int;
}
