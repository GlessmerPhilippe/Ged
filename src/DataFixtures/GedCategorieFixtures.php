<?php

namespace App\DataFixtures;

use App\Entity\GedCategorie;
use App\Entity\GedCategorieItem;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GedCategorieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categories = [
            'Santé' => [
                'Ordonnances',
                'Comptes rendus médicaux',
                'Examens',
                'Carnets de santé',
                'Protocoles diabète',
                'Handicap',
                'Rendez-vous',
                'Mutuelle',
            ],
            'Maison' => [
                'Factures électricité / eau / gaz',
                'Assurances habitation',
                'Travaux',
                'Devis',
                'Garanties matériel',
                'Plans / Permis',
                'Notaire',
                'Crédit immobilier',
                'Entretien chaudière / alarme',
            ],
            'Véhicules' => [
                'Assurance auto',
                'Contrats leasing',
                'Carte grise',
                'Contrôle technique',
                'Entretien / réparations',
                'Amendes',
                'Prêt ou location',
            ],
            'Animaux' => [
                'Vaccinations',
                'Identification',
                'Adoptions',
                'Consultations véto',
                'Médicaments',
                'Assurance animale',
                'Nourriture / BARF',
            ],
            'Vie professionnelle' => [
                'Fiches de paie',
                'Contrats de travail',
                'Attestations employeur',
                'Arrêts maladie / IJ',
                'Notes de frais',
                'Mutuelle entreprise',
                'Pôle emploi',
                'Factures activité',
                'Relevés retraite',
            ],
            'Vie administrative' => [
                'Livret de famille',
                'Carte d’identité / passeport',
                'Extraits de naissance',
                'CAF',
                'Sécurité sociale',
                'Avis d’imposition',
                'Déclarations impôts',
                'Justificatifs domicile',
                'Dossier logement',
                'Notaire / successions',
            ],
            'Vacances / déplacements' => [
                'Réservations',
                'Contrats de location',
                'Itinéraires',
                'Assurances voyage',
                'Listes de bagages',
            ],
            'Scolarité / Études' => [
                'Inscriptions',
                'Attestations de scolarité',
                'Dossiers bourses',
                'Notes & bulletins',
                'Projets scolaires',
                'Orientation / stages',
                'Examens',
            ],
            'Comptabilité familiale' => [
                'Factures',
                'Budgets prévisionnels',
                'Tableaux Excel',
                'Relevés bancaires',
                'RIB',
                'Crédit conso',
                'Remboursements sécu / mutuelle',
            ],
            'Dossiers divers' => [
                'Aides sociales',
                'Dossiers juridiques',
                'Mandats / procurations',
                'Autorisations scolaires',
                'Adoption / agréments',
            ],
        ];

        foreach ($categories as $catLabel => $items) {
            $categorie = new GedCategorie();
            $categorie->setLibelle($catLabel);
            $manager->persist($categorie);

            foreach ($items as $itemLabel) {
                $item = new GedCategorieItem();
                $item->setLibelle($itemLabel);
                $item->setCat($categorie);
                $manager->persist($item);
            }
        }

        $manager->flush();
    }
}
