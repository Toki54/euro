<?php

namespace App\Controller;

use App\Entity\Euromillions;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EuromillionsController extends AbstractController
{
    #[Route('/selection', name: 'euromillions')]
    public function selection(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Récupérer tous les résultats des tirages
        $tirages = $entityManager->getRepository(Euromillions::class)->findAll();

        // Créer un tableau pour les résultats
        $resultats = [
            'boules' => array_fill(1, 5, 0), // Compte pour boule_1 à boule_5
            'etoiles' => array_fill(1, 2, 0) // Compte pour etoile_1 et etoile_2
        ];

        // Traiter le formulaire si une soumission a eu lieu
        if ($request->isMethod('POST')) {
            // Récupérer les valeurs soumises
            $boules = [
                $request->request->get('boule_1'),
                $request->request->get('boule_2'),
                $request->request->get('boule_3'),
                $request->request->get('boule_4'),
                $request->request->get('boule_5'),
            ];
            $etoiles = [
                $request->request->get('etoile_1'),
                $request->request->get('etoile_2'),
            ];

            // Calculer le nombre de fois chaque nombre a été tiré
            foreach ($tirages as $tirage) {
                for ($i = 1; $i <= 5; $i++) {
                    if ($tirage->{'getBoule' . $i}() === (int)$boules[$i - 1]) {
                        $resultats['boules'][$i]++;
                    }
                }
                for ($j = 1; $j <= 2; $j++) {
                    if ($tirage->{'getEtoile' . $j}() === (int)$etoiles[$j - 1]) {
                        $resultats['etoiles'][$j]++;
                    }
                }
            }

            // Calculer le pourcentage
            $totalTirages = count($tirages);
            $pourcentages = [
                'boules' => array_map(fn($count) => ($count / $totalTirages) * 100, $resultats['boules']),
                'etoiles' => array_map(fn($count) => ($count / $totalTirages) * 100, $resultats['etoiles']),
            ];

            return $this->render('euromillions/result.html.twig', [
                'resultats' => $resultats,
                'pourcentages' => $pourcentages,
                'totalTirages' => $totalTirages,
            ]);
        }

        return $this->render('euromillions/selection.html.twig', [
            'tirages' => $tirages,
        ]);
    }
}
