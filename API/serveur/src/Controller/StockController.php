<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\StockRepository;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class StockController extends AbstractController
{
    private $stockRepository;
    private $bookRepository;

    public function __construct(StockRepository $stockRepository, BookRepository $bookRepository)
    {
        $this->stockRepository = $stockRepository;
        $this->bookRepository = $bookRepository;
    }

    /**
     * @Route("/stock", name="add_stock", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $book = $data['book_id'];
        $library = $data['library'];
        $adress = $data['adress'];
        $city = $data['city'];
        $count = $data['count'];
        $zipCode = $data['zip_code'];

        if (empty($book) || empty($library) || empty($adress) || empty($city) || empty($count) || empty($zipCode)) {
            return new JsonResponse('book_id, library, adress, city or count is missing.', Response::HTTP_BAD_REQUEST);
        }

        $book = $this->bookRepository->findOneBy(['id' => $book]);

        if (empty($book)) {
            return new JsonResponse('Book not found.', Response::HTTP_NOT_FOUND);
        }

        $this->stockRepository->saveStock($book, $count, $library, $adress, $city, $zipCode);

        return new JsonResponse(['status' => 'Stock added !'], Response::HTTP_CREATED);
    }
}
