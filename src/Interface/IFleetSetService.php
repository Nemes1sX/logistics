<?php 

namespace App\Interface;

interface IFleetSetService
{
    function getAllFleetSets(int $pageNumber = 1, int $perPage = 10, string $manufacturer = '') : array;
    function getFleetSet(int $id) : array;
    function getTotalFleetSets(string $manufacturer = '') : int;
}
