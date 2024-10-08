<?php 

namespace App\Interface;

use App\Entity\Order;

interface IOrderService
{
    function getAllOrders(int $pageNumber = 1, int $perPage = 10, string $name = '', string $status = '') : array;
    function getOrder(int $id) : array;
    function getTotalOrders() : int;
}
