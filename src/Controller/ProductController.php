<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * 
 *@Route("/product")
 */
class ProductController extends AbstractController
{
   /**
   *@Route("/add", name="addProduct")
   */
   public function addProduct(Request $request, EntityManagerInterface $manager)
   {

    $product=new Product;

    $form=$this->createForm(ProductType::class, $product);
    $form->handleRequest($request);
   
   if ($form->isSubmitted() && $form->isValid())
   {
    $pictureFile=$form->get('picture')->getData();
    // dd($pictureFile);

    $picture_bdd=date("YmdHis").$pictureFile->getClientOriginalName();
    // dd($picture_bdd);

    try {

        $pictureFile->move($this->getParameter('upload_directory'), $picture_bdd);


    }catch (FileException $e){
        dd($e);
    }
    $product->setPicture($picture_bdd);
    // dd($product);
    $manager->persist($product);
    $manager->flush();

    return $this->redirectToRoute("home");

   }


    return $this->render('product/addProduct.html.twig', [ 
        'form'=>$form->createView()        

    ]);
     
   }

/**
*@Route("/list", name="listProduct")
*/
public function listProduct(ProductRepository $productRepository)
{
    
    $products=$productRepository->findAll();
    // dd($products);


    return $this->render('product/listProduct.html.twig', [ 
        'products'=>$products


 ]);

}

/**
*@Route("/edit/{id}", name="editProduct")
*/
public function editProduct ()
{

 return $this->render('product/editProduct.html.twig', [ 


 ]);

}

/**
*@Route("/delete/{id}", name="deleteProduct")
*/
public function deleteProduct ()
{

 return $this->redirectToRoute('listProduct');

}


















}
