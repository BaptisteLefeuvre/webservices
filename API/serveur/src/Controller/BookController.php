<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BookRepository;
use App\Repository\StockRepository;
use App\Entity\Stock;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BookController extends AbstractController
{
    private $bookRepository;
    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    /**
     * @Route("/book", name="add_book", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (empty($data['name']) || empty($data['author']) || empty($data['price'])) {
            return new JsonResponse('Name, author or price is missing.', Response::HTTP_BAD_REQUEST);
        }

        $this->bookRepository->saveBook($data['name'], $data['author'], $data['price']);

        return new JsonResponse(['status' => 'Book created !'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/book/{id}", name="get_one_book", methods={"GET"})
     */
    public function get($id): JsonResponse
    {
        $book = $this->bookRepository->findOneBy(['id' => $id]);

        if (empty($book)) {
            return new JsonResponse('Book not found.', Response::HTTP_NOT_FOUND);
        }

        $data = [
            'id' => $book->getId(),
            'name' => $book->getName(),
            'author' => $book->getAuthor(),
            'price' => $book->getPrice(),
            'date_publication' => $book->getDatePublication(),
            'stock' => $book->showStock()
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/book/{id}/buy/{stock}", name="buy_book", methods={"POST"})
     */
    public function buyBook($id, $stock = null): JsonResponse
    {
        $stockRepository = $this->getDoctrine()->getRepository(Stock::class);
        $book = $this->bookRepository->findOneBy(['id' => $id]);

        if (empty($book)) {
            return new JsonResponse('Book not found.', Response::HTTP_NOT_FOUND);
        }
        
        if($stock != null)
        {
            $bookStock = $stockRepository->findStock($id, $stock);
        }else $bookStock = $book->getStock()->first();

        if(empty($bookStock)) {
            return new JsonResponse('No stock found for this book.', Response::HTTP_BAD_REQUEST);
        }

        $stockRepository->updateStockCount($bookStock);

        return new JsonResponse("OK", Response::HTTP_OK);
    }

    /**
     * @Route("/book", name="get_all_books", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $books = $this->bookRepository->findAll();
        $data = [];

        foreach ($books as $book) {
            $data[] = [
                'id' => $book->getId(),
                'name' => $book->getName(),
                'author' => $book->getAuthor(),
                'price' => $book->getPrice(),
                'date_publication' => $book->getDatePublication(),
                'stock' => $book->showStock()
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/book/{id}", name="update_book", methods={"PUT"})
     */
    public function update($id, Request $request): JsonResponse
    {
        $book = $this->bookRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);

        empty($data['name']) ? true : $book->setName($data['name']);
        empty($data['author']) ? true : $book->setAuthor($data['author']);
        empty($data['price']) ? true : $book->setPrice($data['price']);

        $updatedBook = $this->bookRepository->updateBook($book);

        return new JsonResponse($updatedCostumer->toArray(), Response::HTTP_OK);
    }

    /**
     * @Route("/book/{id}", name="delete_book", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $book = $this->bookRepository->findOneBy(['id' => $id]);

        $this->bookRepository->removeBook($book);

        return new JsonResponse(['status' => 'Book deleted'], Response::HTTP_NO_CONTENT);
    }
}
