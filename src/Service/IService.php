<?php

namespace App\Service;

interface IService{
    public function create(Array $data): object;
    public function edit(object $entity, Array $data): object;
}