<?php
/**
 * Medicine controller.
 */

namespace App\Controller;

use App\Entity\Medicine;
use App\Form\MedicineType;
use App\Repository\MedicineRepository;
use App\Service\PersisterService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;



/**
 * @Route("/medicine")
 */
class MedicineController extends AbstractController
{
    /**
     * @Route("/public", name="medicine_index", methods={"GET"})
     *
     * @param Request            $request
     * @param MedicineRepository $medicineRepository
     * @param PaginatorInterface $paginator
     *
     * @return Response
     */
    public function index(Request $request, MedicineRepository $medicineRepository, PaginatorInterface $paginator): Response
    {
        $medicines = $paginator->paginate(
            $medicineRepository->search($request) ?? [],
            $request->query->getInt('page', 1),
            Medicine::LIMIT,
        );

        return $this->render('medicine/index.html.twig', [
            'medicines' => $medicines, 'name' => $request->query->getAlnum('name')
        ]);
    }

    /**
     * @Route("/new", name="medicine_new", methods={"GET","POST"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function new(Request $request, PersisterService $persisterService): Response
    {
        $medicine = new Medicine();
        $form = $this->createForm(MedicineType::class, $medicine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                /** @var UploadedFile $brochureFile */
                $brochureFile = $form->get('brochure')->getData();

                // this condition is needed because the 'brochure' field is not required
                // so the PDF file must be processed only when a file is uploaded
                if ($brochureFile) {
                    $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                    // this is needed to safely include the file name as part of the URL
                    $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();
    
                    // Move the file to the directory where brochures are stored
                    try {
                        $brochureFile->move(
                            $this->getParameter('brochures_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                    }
    
                    // updates the 'brochureFilename' property to store the PDF file name
                    // instead of its contents
                    $medicine->setBrochureFilename($newFilename);
                }
            $persisterService->save($medicine);
            $this->addFlash('success', 'medicine_successfully_added');


            return $this->redirectToRoute('medicine_index');
        }

        return $this->render('medicine/new.html.twig', [
            'medicine' => $medicine,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/public/{id}", name="medicine_show", methods={"GET"})
     *
     * @param Medicine $medicine
     *
     * @return Response
     */
    public function show(Medicine $medicine, Request $request): Response
    {
        $name = $request->query->getAlnum('name');
        if($name){
            return $this->redirectToRoute('medicine_index', ['name'=>$name]);
        }

        return $this->render('medicine/show.html.twig', [
            'medicine' => $medicine,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="medicine_edit", methods={"GET","POST"})
     *
     * @param Request  $request
     * @param Medicine $medicine
     *
     * @return Response
     */
    public function edit(Request $request, Medicine $medicine, PersisterService $persisterService): Response
    {
        $form = $this->createForm(MedicineType::class, $medicine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $persisterService->save($medicine);
            $this->addFlash('success', 'medicine_successfully_edited');

            return $this->redirectToRoute('medicine_index');
        }

        return $this->render('medicine/edit.html.twig', [
            'medicine' => $medicine,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="medicine_delete", methods={"DELETE"})
     *
     * @param Request  $request
     * @param Medicine $medicine
     *
     * @return Response
     */
    public function delete(Request $request, Medicine $medicine, PersisterService $persisterService): Response
    {
        if ($this->isCsrfTokenValid('delete'.$medicine->getId(), $request->request->get('_token'))) {
            $persisterService->remove($medicine);
            $this->addFlash('danger', 'medicine_removed');
        }

        return $this->redirectToRoute('medicine_index');
    }
}
