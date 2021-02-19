<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartController extends AbstractController
{
    private $client, $session;

    private $apiURL = "http://127.0.0.1:8001";

    public function __construct(HttpClientInterface $client, SessionInterface $session)
    {
        $this->client = $client;
        $this->session = $session;
    }

    public function getBooks() {
            $response = $this->client->request('GET', $this->apiURL.'/book');

            $books = [];

            if($response->getStatusCode(false) === 200)
            {
                foreach($response->toArray(false) as $r)
                {
                    $stock = 0;
                    foreach($r['stock'] as $s) { $stock += $s['count']; }
                    $books[] = ['id' => $r['id'], 'name' => $r['name'], 'price' => $r['price'], 'author' => $r['author'], 'stock' => $stock];
                }
            }

        return [$response->getStatusCode(false), $books];
    }

    /**
     * 
     * @Route("/", name="cart")
     */
    public function index(): Response
    {
        $cart = $this->session->get('cart', []);

        $total = 0.00;
        foreach($cart as $c){$total += $c['price'];}

        $api = $this->getBooks();

       return $this->render('books.html.twig', ['books' => $api[1], 'api' => $api[0], 'cart' => $cart, 'total' => $total]);
    }

    /**
     * 
     * @Route("/cart/add/{id}", name="add_book_to_cart")
     */
    public function addCart($id) {
        $response = $this->client->request('GET', $this->apiURL.'/book/'.$id);
        $response->getContent(false);

        if($response->getStatusCode(false) === 200)
        {
            $cart = $this->session->get('cart', []);
        
            array_push($cart, $response->toArray());
    
            $this->session->set('cart', $cart);
            return $this->redirectToRoute('cart');
        }
    }

    /**
     * 
     * @Route("/cart/remove/{book}", name="remove_book_to_cart")
     */
    public function removeCart($book) {
        $cart = $this->session->get('cart', []);
        $key = array_search($book, array_column($cart, 'id'));
        array_splice($cart, $key, 1);
        $this->session->set('cart', $cart);
        return $this->redirectToRoute('cart');
    }

    /**
     * 
     * @Route("/cart/validate", name="validate_cart")
     */
    public function validateCart() {
        $cart = $this->session->get('cart', []);

        foreach($cart as $c) {
            $r = $this->client->request('POST', $this->apiURL.'/book/'.$c['id'].'/buy');
            $r->getContent(false);
        }

        $this->session->set('cart', []);

        return $this->redirectToRoute('cart');
    }
}
