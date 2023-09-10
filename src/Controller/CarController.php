<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Interface\CarRepositoryInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;


#[Route('/api', name: 'api_')]
class CarController extends AbstractController
{
    private $carRepository;

    public function __construct(CarRepositoryInterface $carRepository)
    {
        $this->carRepository = $carRepository;
    }

    #[Route('/cars')]
    public function index(Request $request): JsonResponse
    {
        $cars = $this->carRepository->index();
           
        return $this->json(['data' => $cars], 200);
    }

    #[Route('/car/{id}')]
    public function show(int $id): JsonResponse
    {
        $car = $this->carRepository->findById($id);

        if (empty($car)) {
            return $this->json('No car found for id ' . $id, 404);
        }
           
        return $this->json(['data' => $car], 200);
    }

    #[Route('/cars/filter', methods:['post'] )]
    public function filter(Request $request, ValidatorInterface $validator)
    {

        $constraints = new Assert\Collection([
            'year' => [new Assert\Type('digit')],
            'brand' => [new Assert\Type('digit')],
            'transmition' => [new Assert\Type('digit')],
            'color' => [new Assert\Type('digit')],
            'model' => [new Assert\Type('string')],
            'horsePower' => [new Assert\Type('digit')],
            'numberOfSeats' => [new Assert\Type('digit')],
        ]);

        $violations = $validator->validate($request->request->all(), $constraints);

        if (count($violations) > 0) {

            $accessor = PropertyAccess::createPropertyAccessor();

            $errorMessages = [];

            foreach ($violations as $violation) {

                $accessor->setValue($errorMessages,
                    $violation->getPropertyPath(),
                    $violation->getMessage());
            }

            return $this->json(['errors' => $errorMessages], 422);
        }

        $year = $request->request->get('year');
        $brand = $request->request->get('brand');
        $transmition = $request->request->get('transmition');
        $color = $request->request->get('color');
        $model = $request->request->get('model');
        $horsePower = $request->request->get('horsePower');
        $numberOfSeats = $request->request->get('numberOfSeats');

        $cars = $this->carRepository->filter($model,$horsePower,$numberOfSeats,$year,$brand,$transmition,$color);
           
        return $this->json(['data' => $cars], 200);
    }
 
}
