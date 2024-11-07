<?php

namespace App\Controller;

use App\Entity\Euromillions;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class EuromillionsController extends AbstractController
{
    #[Route('/selection', name: 'app_selection')]
    public function result(EntityManagerInterface $entityManager): Response
    {
        // Récupérer tous les tirages Euromillions depuis la base de données
        $tirages = $entityManager->getRepository(Euromillions::class)->findAll();

        // Variables pour stocker les données
        $diffBoules = [];
        $moyenneBoules = [0, 0, 0, 0, 0]; // Moyenne des boules 1 à 5
        $moyenneEtoiles = [0, 0]; // Moyenne des étoiles 1 et 2
        $totalTirages = count($tirages);

        // Calcul des différences et des moyennes
        foreach ($tirages as $tirage) {
            // Récupérer les boules et les étoiles du tirage
            $boules = [
                $tirage->getBoule1(),
                $tirage->getBoule2(),
                $tirage->getBoule3(),
                $tirage->getBoule4(),
                $tirage->getBoule5()
            ];
            $etoiles = [
                $tirage->getEtoile1(),
                $tirage->getEtoile2()
            ];

            // Calcul des différences entre boules
            if (count($boules) > 1) {
                $differences = [];
                for ($i = 1; $i < count($boules); $i++) {
                    $differences[] = abs($boules[$i] - $boules[$i - 1]);
                }
            }

            // Calcul des différences entre étoiles
            $diffEtoiles = abs($etoiles[0] - $etoiles[1]);

            // Ajouter les moyennes des boules
            foreach ($boules as $index => $boule) {
                $moyenneBoules[$index] += $boule;
            }

            // Ajouter les moyennes des étoiles
            foreach ($etoiles as $index => $etoile) {
                $moyenneEtoiles[$index] += $etoile;
            }

            // Enregistrer les boules et leurs différences
            $diffBoules[] = [
                'boules' => $boules,
                'differences' => $differences ?? [],
                'diffEtoiles' => $diffEtoiles
            ];
        }

        // Calcul des moyennes finales
        $moyenneBoules = array_map(fn($total) => $total / $totalTirages, $moyenneBoules);
        $moyenneEtoiles = array_map(fn($total) => $total / $totalTirages, $moyenneEtoiles);

        // Analyse des fréquences des boules
        $bouleFrequency = [];
        foreach ($tirages as $tirage) {
            for ($i = 1; $i <= 5; $i++) {
                $boule = $tirage->{'getBoule' . $i}();
                if (!isset($bouleFrequency[$boule])) {
                    $bouleFrequency[$boule] = 0;
                }
                $bouleFrequency[$boule]++;
            }
        }

        // Tri des fréquences par ordre décroissant
        arsort($bouleFrequency);

        // Analyse des séquences récurrentes basées sur les numéros des boules
        $bouleSequences = [];
        foreach ($diffBoules as $diffs) {
            $boules = $diffs['boules'];

            // Rechercher des séquences de numéros de boules récurrentes
            for ($i = 0; $i < count($boules); $i++) {
                for ($length = 2; $length <= 5; $length++) {
                    if ($i + $length <= count($boules)) {
                        $sequence = array_slice($boules, $i, $length);
                        $sequenceKey = implode('-', $sequence);

                        if (!isset($bouleSequences[$sequenceKey])) {
                            $bouleSequences[$sequenceKey] = 0;
                        }
                        $bouleSequences[$sequenceKey]++;
                    }
                }
            }
        }

        // Filtrer les séquences récurrentes
        $recurrentSequences = array_filter($bouleSequences, fn($count) => $count > 1);

        // Détection des sous-séquences répétées dans plusieurs tirages
        $repeatedPatterns = [];
        $windowSize = 3; // Longueur des sous-séquences à comparer

        for ($i = 0; $i < count($diffBoules) - $windowSize; $i++) {
            $currentPattern = array_slice($diffBoules[$i]['boules'], 0, $windowSize);
            $patternKey = implode('-', $currentPattern);

            if (!isset($repeatedPatterns[$patternKey])) {
                $repeatedPatterns[$patternKey] = ['count' => 0, 'positions' => []];
            }
            $repeatedPatterns[$patternKey]['count']++;
            $repeatedPatterns[$patternKey]['positions'][] = $i + 1;
        }

        // Filtrer pour ne garder que les sous-séquences qui apparaissent plusieurs fois
        $repeatedPatterns = array_filter($repeatedPatterns, fn($pattern) => $pattern['count'] > 1);

        // Renvoyer les résultats dans le template
        return $this->render('euromillions/result.html.twig', [
            'diffBoules' => $diffBoules,
            'moyenneBoules' => $moyenneBoules,
            'moyenneEtoiles' => $moyenneEtoiles,
            'recurrentSequences' => $recurrentSequences,
            'repeatedPatterns' => $repeatedPatterns,
            'bouleFrequency' => $bouleFrequency,
            'totalTirages' => $totalTirages,
        ]);
    }

}
