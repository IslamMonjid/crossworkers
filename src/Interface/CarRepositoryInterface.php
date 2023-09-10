<?php
namespace App\Interface;

interface CarRepositoryInterface {
    public function index():?array;
    public function findById(int $id):?array;
    public function filter($model,$horsePower,$numberOfSeats,$year,$brand,$transmition,$color): array;
}