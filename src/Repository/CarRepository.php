<?php

namespace App\Repository;

use App\Entity\Car;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Interface\CarRepositoryInterface;


class CarRepository extends ServiceEntityRepository implements CarRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Car::class);
    }

    public function index(): ?array
    {
        $cars = $this->findAll();

        $data = [];
        
        foreach ($cars as $car) {
            $data[] = [
                'id' => $car->getId(),
                'brand' => $car->getBrand()->getName(),
                'model' => $car->getModel(),
                'color' => $car->getColor()->getName(),
                'seats' => $car->getNumberOfSeats(),
                'horsepower' => $car->getHorsePower(),
                'transmation' => $car->getTransmition()->getType(),
                'year' => $car->getYear(),
            ];
         }

        return $data;
    }

    public function findById(int $id): ?array
    {
        $car = $this->find($id);
        if (!$car) {
            return [];
        }

        $data =  [
            'id' => $car->getId(),
            'brand' => $car->getBrand()->getName(),
            'model' => $car->getModel(),
            'color' => $car->getColor()->getName(),
            'seats' => $car->getNumberOfSeats(),
            'horsepower' => $car->getHorsePower(),
            'transmation' => $car->getTransmition()->getType(),
            'year' => $car->getYear(),
        ];

        return $data;
    }

    /**
     * @return Car[] Returns an array of Car objects
     */
   public function filter($model,$horsePower,$numberOfSeats,$year,$brand,$transmition,$color): array
   {
        $query = $this->createQueryBuilder('c')
                ->addSelect('b')
                ->leftJoin('c.brand', 'b')
                ->addSelect('t')
                ->leftJoin('c.transmition', 't')
                ->addSelect('color')
                ->leftJoin('c.color', 'color');

        if(!is_null($model) && !empty($model)){
            $query->andWhere('c.model = :model')->setParameter('model', $model);
        }

        if(!is_null($horsePower) && !empty($horsePower)){
            $query->andWhere('c.horsePower = :horsePower')->setParameter('horsePower', $horsePower);
        }

        if(!is_null($numberOfSeats) && !empty($numberOfSeats)){
            $query->andWhere('c.numberOfSeats = :numberOfSeats')->setParameter('numberOfSeats', $numberOfSeats);
        }
                
        if(!is_null($year) && !empty($year)){
            $query->andWhere('c.year = :year')->setParameter('year', $year);
        }

        if(!is_null($brand) && !empty($brand)){
            $query->andWhere('b.id = :brand')->setParameter('brand', $brand);
        }

        if(!is_null($transmition) && !empty($transmition)){
            $query->andWhere('t.id = :transmition')->setParameter('transmition', $transmition);
        }

        if(!is_null($color) && !empty($color)){
            $query->andWhere('color.id = :color')->setParameter('color', $color);
        }

        $query->orderBy('c.id', 'ASC');

        return $query->getQuery()->getArrayResult();
   }
}
