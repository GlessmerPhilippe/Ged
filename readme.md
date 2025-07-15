# GED Famille

Application de Gestion Électronique de Documents (GED) pour une famille moderne, construite avec **Symfony 7**, **PostgreSQL**, **Docker** et **Google Cloud Storage (GCS)**.

## 🚀 Objectif

Centraliser, classer et accéder facilement à tous les documents de la famille :

- Médicaux
- Administratifs
- Animaux
- Scolaires
- Professionnels
- Travaux, voiture, logement...

Avec prise en compte de cas spécifiques :

- Enfant diabétique
- Enfant polyhandicapé
- Famille recomposée

---

## 🏒 Stack technique

- Symfony 7
- Doctrine ORM
- PostgreSQL 15 (Docker)
- Google Cloud Storage (stockage de fichiers)
- Twig + Bootstrap 5 (UI)
- Fixtures pour démarrage rapide

---

## ⚙️ Installation

### 1. Cloner le projet

```bash
git clone https://github.com/ton-compte/ged-famille.git
cd ged-famille
```

### 2. Lancer l'environnement Docker (mode dev)

```bash
make dev
```

Ou manuellement :

```bash
docker-compose -f docker-compose.yml -f docker-compose.override.dev.yml up -d --build
```

### 3. Installer Symfony dans le conteneur

```bash
docker exec -it symfony_app bash
composer install
```

### 4. Configuration locale

Créer un fichier `.env.local` :

```dotenv
DATABASE_URL=
GCS_BUCKET_NAME=
GCS_KEY_FILE=
```

### 5. Migration + fixtures

```bash
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
```
---

## 🔗 Fonctionnalités

### 🔄 Ajout de documents

- Formulaire complet : titre, date, personne concernée, catégorie, fichier
- Upload direct vers Google Cloud Storage
- Génération de lien signé temporaire (lecture sécurisée)

### 🔍 Recherche et filtrage (en cours)

- Par tag, personne, catégorie, date, etc.

### 👁️ Vue détaillée

- Aperçu des métadonnées
- Lien vers le fichier stocké sur GCS (signé)

### ❌ Suppression

- Sécurisée avec token CSRF
- Supprime également le fichier distant GCS

### 💼 Utilisateurs

- Champs personnalisés : civilité, prénom, nom, date de naissance, avatar
- Rôles : `ROLE_USER`, `ROLE_ADMIN`

---

## 🎓 Structure des données

### Entités principales :

- `GedDocument` : document GED
- `GedCategorie` / `GedCategorieItem` : classification hiérarchique
- `User` : personnes de la famille

---

## 🌐 Accès

- Web : `http://localhost:8000`
- Route d'ajout : `/document/new`
- Liste : `/document/list`

---

## 📊 Roadmap

-

---

## 🌟 Auteur

Philippe Glessmer

