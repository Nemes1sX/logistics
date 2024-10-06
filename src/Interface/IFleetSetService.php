<?php 

namespace App\Interface;

use App\Entity\FleetSet;

interface IFleetSetSerivce
{
    function getAllFleetSets(int $pageNumber = 1, int $perPage = 10, string $name = '', string $status = '') : array;
    function getFleetSet(int $id) : FleetSet;
    function getTotalFleetSets() : int;
}
