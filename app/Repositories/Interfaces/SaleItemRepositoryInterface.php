<?php

namespace App\Repositories\Interfaces;


interface SaleItemRepositoryInterface
{
    public function findStockByNoteAndCode($note, $code);
    public function create(array $data);
    public function delete($note);
}
