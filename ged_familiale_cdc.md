# Cahier des charges - GED Familiale

## 1. Contexte et objectifs

Le projet vise à développer une solution de **gestion électronique des documents (GED)** pour une famille. Cette solution doit permettre de centraliser, classer, retrouver et partager les documents administratifs, médicaux, scolaires, etc. Le stockage est déporté sur Google Cloud Storage (GCS) pour des raisons de fiabilité et de durabilité.

L’accès aux documents doit être possible depuis :
- Une interface web Symfony (v1)
- Une API REST (v2)
- Une application mobile Ionic (v3)

---

## 2. Utilisateurs et rôles

### Utilisateurs
- Membres de la famille
- Administrateurs techniques (optionnel)

### Rôles
- **Admin** : gestion complète, utilisateurs, documents
- **Parent** : upload, consultation tous documents
- **Enfant** : consultation restreinte (docs propres)

---

## 3. Fonctionnalités principales

### Phase 1 : Interface Symfony (Web)
- Authentification (session ou JWT)
- Upload de documents via formulaire
- Association de métadonnées :
  - Titre
  - Date
  - Type (santé, scolaire, facture, etc.)
  - Personne concernée
  - Tags
- Stockage du fichier dans GCS (bucket privé)
- Génération d'URL signées (expirables) pour accès aux fichiers
- Listing, recherche, filtres, tri

### Phase 2 : API REST
- Authentification JWT
- Endpoints pour :
  - Login/logout
  - Upload document
  - Listing des documents (avec filtres)
  - Accès à l'URL signée d'un fichier
- Retour des données au format JSON

### Phase 3 : Application mobile Ionic
- Connexion avec identifiants (JWT)
- Accès à la liste des documents (via API)
- Scan de documents avec appareil photo
- Saisie rapide des métadonnées
- Upload vers API (et stockage GCS)
- Consultation et téléchargement de documents (via URL signée)

---

## 4. Architecture technique

| Composant       | Technologie                           |
|-----------------|----------------------------------------|
| Backend         | Symfony 6/7 (PHP, Doctrine, Twig, API Platform)
| Base de données | MySQL / PostgreSQL                    |
| Stockage        | Google Cloud Storage (bucket privé)   |
| Authentification| Session (web) / JWT (API/mobile)       |
| Front Web       | Twig (v1) → Angular (v2)               |
| Application     | Ionic (Capacitor) + plugins natifs     |

---

## 5. Sécurité
- Accès aux documents uniquement via URL signées (valables X minutes)
- Bucket GCS privé, jamais exposé publiquement
- Authentification JWT pour l’API et l’app mobile
- Rôles utilisateurs avec accès filtré
- Logs d’accès (optionnel)

---

## 6. Planification par phase

### Phase 1 (Symfony Web)
- Authentification + rôles
- Entités et base de données
- Upload + stockage GCS
- CRUD des documents
- Affichage + filtres
- URL signées expirables

### Phase 2 (API REST)
- Endpoints CRUD + auth JWT
- Upload API → GCS
- Tests unitaires et Postman

### Phase 3 (Ionic Mobile)
- Connexion JWT
- Appareil photo / scanner
- Envoi via API
- Listing + téléchargement

---

## 7. Évolutions possibles
- OCR automatique
- Notifications de renouvellement (ex : carte identité)
- Export ZIP par catégorie ou date
- Mode hors-ligne (mobile)
- Partage restreint par email/token

