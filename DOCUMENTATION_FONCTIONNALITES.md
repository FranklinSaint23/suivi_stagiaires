# 📋 RAPPORT D'ANALYSE DÉTAILLÉE DU PROJET : STAGETRACK (SUIVI DES STAGIAIRES)

---

## 1. 🌟 Présentation Générale du Projet

**StageTrack** est une plateforme web moderne et complète conçue pour digitaliser, automatiser et superviser l'intégralité du cycle de vie des stages académiques et professionnels. 

Le système centralise l'interaction entre **trois profils d'utilisateurs clés** :
1. **Les Administrateurs (RH / Direction)** : Gestion globale de la sécurité, des comptes utilisateurs, des encadrants et du paramétrage.
2. **Les Encadrants / Tuteurs de stage** : Suivi pédagogique, pointage des présences, assignation des objectifs, évaluation des rapports périodiques, génération de documents officiels et analyse assistée par Intelligence Artificielle.
3. **Les Stagiaires** : Consultation de leur progression en temps réel, pointage d'assiduité, transmission de leur position GPS, dépôt des rapports de stage et assistance 24/7 via un chatbot IA dédié.
4. **Le Public / Candidats externes** : Dépôt de candidatures spontanées ou académiques en ligne sans nécessiter de compte préalable.

---

## 2. 🛠️ Stack Technologique & Architecture Technique

### 2.1 Backend
- **Framework** : [Laravel](https://laravel.com/) (dernière génération, PHP 8.4+).
- **ORM** : Eloquent ORM avec relations strictes, suppressions en cascade et accessors dynamiques.
- **Sécurité & Contrôle d'accès** : Middleware personnalisé [RoleMiddleware](file:///d:/DEV/Suivi%20stagiaires/app/Http/Middleware/RoleMiddleware.php) (`role:admin`, `role:encadrant`, `role:stagiaire`), hashage Bcrypt/Argon2id des mots de passe, protection CSRF systématique.
- **Routage & Serveur de fichiers dynamique** : Route personnalisée `/fichier/{path}` capable de résoudre les assets sur des environnements conteneurisés ou Windows sans dépendre de liens symboliques (symlinks) fragiles.

### 2.2 Frontend & Ergonomie
- **Moteur de template** : Blade avec architecture par composants et layouts hérités (`layouts.app`, `layouts.guest`).
- **Styling** : Tailwind CSS avec design system sur mesure (Glassmorphism, dégradés vibrants, ombres projetées subtiles, cartes vitrées).
- **Thème dynamique** : Prise en charge native du **Mode Sombre (Dark Mode)** et du **Mode Clair (Light Mode)** avec persistance instantanée via `localStorage`.
- **Typographie & Icônes** : Police Google Fonts *Plus Jakarta Sans* et suite vectorielle complète *FontAwesome 6.5.1*.
- **Interactivité** : JavaScript Vanilla et Alpine.js pour la réactivité sans surcharge de dépendances.

### 2.3 Moteur d'Intelligence Artificielle (IA)
- **Fournisseur LLM** : [Groq API](https://groq.com/) propulsé par le modèle de pointe **LLaMA 3.3 70B Versatile** (`llama-3.3-70b-versatile`).
- **Extraction & Traitement PDF** : Bibliothèque [`smalot/pdfparser`](https://github.com/smalot/pdfparser) permettant le parsing et l'extraction de texte brut directement depuis les fichiers PDF téléversés.
- **Service IA Dédié** : [GroqService](file:///d:/DEV/Suivi%20stagiaires/app/Services/GroqService.php) encapsulant 5 prompts d'ingénierie avancés et spécialisés.

### 2.4 Cartographie & Géolocalisation
- **Moteur cartographique** : [Leaflet.js](https://leafletjs.com/) (v1.9.4) interfacé avec les tuiles libres de droits [OpenStreetMap](https://www.openstreetmap.org/).
- **Capture de position** : API HTML5 Geolocation native (`navigator.geolocation`) pour l'enregistrement instantané des coordonnées GPS des stagiaires sur le terrain.

### 2.5 Génération de Documents PDF
- **Moteur PDF** : [`barryvdh/laravel-dompdf`](https://github.com/barryvdh/laravel-dompdf) (moteur DomPDF) pour le rendu vectoriel de maquettes HTML/CSS vers PDF haute fidélité.
- **Traitement d'images** : Conversion dynamique et encodage Base64 des photographies d'identité pour garantir l'inclusion parfaite des photos dans les cartes de stagiaires.

### 2.6 Intégration Messagerie Externe
- **Passerelle WhatsApp** : [WhatsAppHelper](file:///d:/DEV/Suivi%20stagiaires/app/Helpers/WhatsAppHelper.php) automatisant la génération de liens directs `https://wa.me/` avec normalisation des numéros de téléphone et messages pré-formatés (transmission d'identifiants, réponses aux messages, notifications d'assistance).

---

## 3. 👥 Matrice des Rôles & Droits d'Accès (RBAC)

| Fonctionnalité / Module | Public / Candidat | Stagiaire | Encadrant | Administrateur |
| :--- | :---: | :---: | :---: | :---: |
| **Consulter la Landing Page** | ✅ | ✅ | ✅ | ✅ |
| **Soumettre une demande de stage en ligne** | ✅ | ❌ | ❌ | ❌ |
| **Connexion (Email ou Matricule)** | ❌ | ✅ | ✅ | ✅ |
| **Demande de réinitialisation de mot de passe** | ❌ | ✅ | ✅ | ✅ |
| **Tableau de bord personnalisé avec KPI** | ❌ | ✅ | ✅ | ✅ |
| **Calcul automatique de progression globale** | ❌ | ✅ (Le sien) | ✅ (Tous) | ✅ (Vue globale) |
| **Pointage et suivi des présences** | ❌ | ✅ (Consultation) | ✅ (Pointage & Vue globale) | ✅ (Statistiques) |
| **Export PDF du registre des présences** | ❌ | ✅ (Le sien) | ✅ (Tous les stagiaires) | ❌ |
| **Gestion des stages (création, modification)** | ❌ | ❌ | ✅ | ❌ |
| **Attribution et validation d'objectifs** | ❌ | ✅ (Mise à jour état) | ✅ (Création & Suppression) | ❌ |
| **Soumission de rapports périodiques** | ❌ | ✅ | ❌ | ❌ |
| **Évaluation & Analyse IA des rapports** | ❌ | ❌ | ✅ | ❌ |
| **Génération Attestation & Carte de Stagiaire PDF** | ❌ | ❌ | ✅ | ❌ |
| **Carte interactive & Enregistrement GPS** | ❌ | ✅ (Envoi de position) | ✅ (Visualisation globale) | ❌ |
| **Chatbot IA d'assistance 24/7** | ❌ | ✅ | ❌ | ❌ |
| **Analyse IA des CV reçus** | ❌ | ❌ | ✅ | ❌ |
| **Détection IA des risques d'absentéisme** | ❌ | ❌ | ✅ | ❌ |
| **Rapport formel de performance rédigé par IA** | ❌ | ❌ | ✅ | ❌ |
| **Messagerie interne intégrée** | ❌ | ✅ (Vers encadrant) | ✅ (Réponse vers stagiaire) | ❌ |
| **Alertes & Envois automatisés WhatsApp** | ❌ | ✅ (Réception) | ✅ (Déclenchement) | ✅ (Déclenchement) |
| **Gestion des Encadrants (CRUD)** | ❌ | ❌ | ❌ | ✅ |
| **Gestion des Stagiaires (CRUD)** | ❌ | ❌ | ❌ | ✅ |
| **Gestion globale de tous les comptes utilisateurs** | ❌ | ❌ | ❌ | ✅ |
| **Réinitialisation manuelle des mots de passe** | ❌ | ❌ | ❌ | ✅ |

---

## 4. 🔍 Analyse Scrupuleuse et Détaillée des Fonctionnalités

### 4.1. 🌐 Module Espace Public & Candidature en Ligne

#### A. Landing Page Vitrine (`/`)
- Page d'accueil interactive présentant les caractéristiques majeures de l'application : encadrement assisté par IA, suivi géographique, automatisation administrative.
- Sélecteur de mode sombre/clair accessible dès le header.
- Liens de navigation directe vers le formulaire de candidature publique et vers la page de connexion.
- Statistiques de confiance et témoignages de réussite.

#### B. Formulaire Public de Demande de Stage (`/demande-stage`)
- **Accès libre** : Accessible sans authentification pour tout étudiant ou chercheur de stage.
- **Collecte des données d'identité** :
  - Nom, Prénom, Sexe (`M` ou `F`).
  - Téléphone portable normalisé.
  - Adresse email unique.
  - Photo d'identité (format JPG, JPEG, PNG, max 2 Mo).
  - Établissement/Lieu d'origine et Filière d'études.
- **Période de stage souhaitée** :
  - Date de début et Date de fin avec validation automatique empêchant une date de fin antérieure au début.
- **Gestion des pièces jointes obligatoires** :
  - Curriculum Vitae (PDF, max 5 Mo).
  - Lettre de motivation (PDF, max 5 Mo).
  - Certificat de scolarité / recommandation académique (PDF, max 5 Mo).
- **Processus de stockage** : Stockage sécurisé des documents dans le disque public de l'application et enregistrement avec l'état initial `"En attente"`.

---

### 4.2. 🔐 Module Authentification, Sécurité & Gestion des Accès

#### A. Connexion Hybride Multi-Identifiants (`/login`)
- Le formulaire d'authentification accepte au choix :
  - **L'adresse email** de l'utilisateur (ex: `admin@suivi.cm`, `stagiaire@example.com`).
  - **Le matricule officiel** généré automatiquement par la plateforme (ex: `ADMIN001`, `ENC001`, `STG20260001`).
- Détection automatique par filtre regex/email et vérification du mot de passe hashé.
- Case à cocher "Se souvenir de moi" (Remember Me).
- **Redirection intelligente conditionnelle** :
  - Redirige automatiquement un `admin` vers `/admin/dashboard`.
  - Redirige automatiquement un `encadrant` vers `/encadrant/dashboard`.
  - Redirige automatiquement un `stagiaire` vers `/stagiaire/dashboard`.

#### B. Workflow de Mot de Passe Oublié (`/forgot-password`)
- Permet à l'utilisateur de soumettre son matricule ou son email.
- Vérifie la présence du compte en base de données.
- **Alerte immédiate en base** : Génère une entrée `AppNotification` prioritaire pour l'administrateur avec le type `"warning"`.
- **Bouton WhatsApp direct d'assistance** : Propose un lien immédiat WhatsApp pré-rempli vers le service informatique/RH (`+237 692 739 565`) contenant le nom, le matricule et l'email du demandeur pour un déblocage urgent.

#### C. Réinitialisation Sécurisée par l'Administrateur
- L'administrateur peut générer un nouveau mot de passe temporaire aléatoire (8 caractères).
- **Synchronisation automatique** : Si l'utilisateur est un stagiaire, la mise à jour s'effectue simultanément dans la table `users` et la table `stagiaires` pour éviter toute désynchronisation.
- Marque automatiquement la notification de demande de réinitialisation comme lue.
- Propose un bouton WhatsApp permettant à l'administrateur de renvoyer en 1 clic les nouveaux identifiants sur le WhatsApp du stagiaire ou de l'encadrant.

---

### 4.3. 👑 Module Espace Administrateur (`/admin/*`)

#### A. Tableau de Bord Décisionnel Admin (`/admin/dashboard`)
- **Indicateurs KPI globaux** :
  - Nombre total d'utilisateurs inscrits.
  - Nombre total de stagiaires actifs.
  - Nombre total de candidatures reçues avec décomposition (Validées, Refusées, En attente).
  - Taux global d'assiduité du centre (calculé sur l'ensemble des pointages).
- **Widget d'alertes prioritaires** : Bannière interactive signalant le nombre de demandes de réinitialisation de mot de passe en cours avec accès direct à leur résolution.
- **Graphique comparatif des présences** : Vue synthétique du taux de présence individuel de tous les stagiaires.

#### B. Gestion Globale des Utilisateurs (`/admin/utilisateurs`)
- Annuaire exhaustif des comptes (Admin, Encadrants, Stagiaires).
- Visualisation des rôles, adresses email, matricules et dates de création.
- Réinitialisation instantanée du mot de passe de n'importe quel compte.

#### C. Gestion des Encadrants (`/admin/encadrants`)
- **CRUD complet** :
  - **Création** : Formulaire de création d'un encadrant avec génération automatique du matricule au format `ENC{ANNEE}{NUMERO_INCREMENTE}` (ex: `ENC20260001`).
  - **Consultation & Recherche** : Moteur de recherche filtrant par nom, email ou matricule.
  - **Modification** : Mise à jour des coordonnées et modification facultative du mot de passe.
  - **Suppression** : Révocation du compte encadrant.
  - **Réinitialisation de mot de passe** : Génération de passe temporaire et lien WhatsApp.

#### D. Gestion des Stagiaires côté Admin (`/admin/stagiaires`)
- CRUD synchronisé en transaction de base de données :
  - Lors de la création d'un stagiaire par l'admin, le système crée à la fois l'enregistrement dans la table `stagiaires` et le compte dans la table `users` avec le rôle `stagiaire` et le matricule `STG{ANNEE}{ID}`.
  - Lors de la suppression, le compte `users`, le profil `stagiaires` et la photo stockée sur le disque sont purgés de concert.
  - Lors de la mise à jour, toute modification d'email ou de mot de passe est répercutée sur les deux entités.

---

### 4.4. 👨‍🏫 Module Espace Encadrant (`/encadrant/*`)

#### A. Tableau de Bord Opérationnel de l'Encadrant (`/encadrant/dashboard`)
- **4 Cartes métriques majeures** :
  1. *Stagiaires actifs* : Nombre de stagiaires actuellement supervisés.
  2. *Rapports à valider* : Nombre de comptes-rendus périodiques déposés par les stagiaires en attente d'évaluation.
  3. *Demandes en attente* : Nouvelles candidatures en attente de décision.
  4. *Objectifs en retard* : Nombre d'objectifs non terminés dont la date limite est échue.
- **Section "Suivi Continu & Progression des Stagiaires"** :
  - Visualisation des cartes individuelles de chaque stagiaire avec calcul en direct de la **Progression Globale** (%).
  - Barres de progression colorées dynamiques (Vert si $\ge 75\%$, Jaune si $\ge 50\%$, Rouge si $< 50\%$).
  - Affichage instantané du taux d'assiduité et du ratio d'objectifs terminés.
- **Section "Demandes de stage récentes"** :
  - Tableau récapitulatif des dernières candidatures avec badge de statut et bouton d'examen rapide.

#### B. Gestion des Dossiers Candidats (`/encadrant/demandes`)
- **Liste des candidatures** : Vue tabulaire avec filtrage visuel par statut (`En attente`, `Validée`, `Refusée`).
- **Fiche détaillée de la candidature (`/encadrant/demandes/{demande}`)** :
  - Consultation des informations complètes du candidat.
  - Liens directs pour visualiser et télécharger les pièces justificatives : CV, Lettre de motivation, Certificat de scolarité.
  - **Bouton d'analyse IA du CV** : Déclenche l'évaluation automatisée du document PDF (voir section IA).
  - **Bouton d'acceptation de la candidature** :
    - Ouvre un modal invitant l'encadrant à définir un mot de passe initial pour le futur stagiaire.
    - Transforme automatiquement le candidat en `Stagiaire` et crée son compte `User` avec matricule officiel.
    - Met à jour le statut de la demande à `Validée`.
    - Génère automatiquement un **lien WhatsApp de bienvenue** pré-rempli avec le nom, le matricule et le mot de passe pour expédition immédiate au stagiaire.
  - **Bouton de refus** : Bascule le statut de la demande à `Refusée`.

#### C. Annuaire & Profils Stagiaires (`/encadrant/stagiaires`)
- Annuaire avec barre de recherche en temps réel (nom, prénom).
- Ajout manuel d'un nouveau stagiaire avec photo, filière, lieu et génération automatique de son compte.
- **Profil Stagiaire 360° (`/encadrant/stagiaires/{stagiaire}`)** :
  - Affichage de la photo de profil ou de l'avatar initialisé.
  - Coordonnées personnelles, date et lieu de naissance, téléphone, filière.
  - Historique complet de ses stages avec détail de l'établissement, du thème et dates.
  - **Barre d'actions intégrée** :
    - Téléchargement immédiat de l'**Attestation de fin de stage PDF**.
    - Téléchargement immédiat de la **Carte de stagiaire PDF**.
    - Déclenchement de la **Génération du Rapport de Performance par IA**.
    - Modification ou suppression du stagiaire.

#### D. Gestion des Stages Académiques (`/encadrant/stages`)
- Formulaire d'association d'un stage à un stagiaire.
- Enregistrement des dates contractuelles, de l'établissement de provenance et du thème de recherche.
- Upload et archivage numérique de la **Convention de stage** (PDF) et du **Rapport de stage final** (PDF).
- Filtres de recherche multi-critères : par thème, par stagiaire et par date active.

#### E. Gestion des Objectifs Pédagogiques (`/encadrant/objectifs`)
- Permet à l'encadrant d'assigner des tâches, missions ou jalons d'apprentissage à un stagiaire.
- Champs : Titre de l'objectif, description détaillée, date limite d'exécution.
- Association automatique au dernier stage actif du stagiaire.
- **Notification automatique** : L'enregistrement déclenche une notification in-app dans l'espace du stagiaire concerné.
- Tableau de suivi de l'avancement avec possibilité de suppression ou modification.

#### F. Évaluation des Rapports Périodiques (`/encadrant/rapports`)
- Centralisation des rapports hebdomadaires, bimensuels ou mensuels transmis par les stagiaires.
- Filtrage par statut (`Soumis`, `Validé`, `Correction demandée`) et par stagiaire.
- **Page d'examen individuel du rapport (`/encadrant/rapports/{rapport}`)** :
  - Lecture du texte rédigé par le stagiaire et téléchargement de la pièce justificative (PDF/Word).
  - **Bouton d'analyse IA** : Analyse automatique de la cohérence du rapport par Groq (points forts, difficultés, conseils pour le tuteur).
  - **Formulaire de décision** :
    - Choix du statut : *Validé* ou *Correction demandée*.
    - Saisie d'un commentaire pédagogique constructif.
    - Enregistrement déclenchant une **notification in-app instantanée** au stagiaire l'informant du résultat.

#### G. Pointage et Suivi de l'Assiduité (`/encadrant/presences`)
- **Pointage journalier (`/encadrant/presences/pointer`)** : Interface ergonomique permettant de marquer rapidement la présence ou l'absence d'un stagiaire pour une date donnée.
- **Matrice mensuelle des présences (`/encadrant/presences`)** :
  - Tableau croisé mensuel dynamique (stagiaires en lignes, jours du mois en colonnes).
  - Sélecteur de mois et d'année.
  - Calcul automatique du nombre de jours ouvrés du mois.
  - **Détecteur d'anomalies par IA** : Analyse globale de la cohorte pour repérer les risques de décrochage (voir section IA).
  - Bouton d'exportation vers un registre officiel PDF paysage.

#### H. Messagerie Interne (`/encadrant/messages`)
- Réception des messages et interrogations adressés par les stagiaires.
- Affichage des conversations avec distinction visuelle des statuts (lu / non lu).
- Formulaire de réponse directe.
- L'envoi d'une réponse génère automatiquement un **lien WhatsApp direct** permettant à l'encadrant de prévenir le stagiaire sur son smartphone en un clic.

---

### 4.5. 🤖 Module Intelligence Artificielle (Groq & LLaMA 3.3 70B)

L'application intègre 5 fonctionnalités avancées d'IA générative et analytique via [GroqService](file:///d:/DEV/Suivi%20stagiaires/app/Services/GroqService.php) :

#### 1. 📄 Analyse Intelligente de CV (`encadrant.ai.analyse_cv`)
- **Fonctionnement** : Lorsqu'un encadrant clique sur "Analyser IA" dans une demande de stage, le système extrait le contenu textuel du document PDF via `smalot/pdfparser`.
- **Rôle IA** : Expert RH spécialisé dans le recrutement de stagiaires.
- **Sortie structurée générée** :
  1. *Formation académique* : Synthèse du cursus et diplômes préparés.
  2. *Compétences techniques* : Outils, langages, méthodologies maîtrisées.
  3. *Expériences préalables* : Projets académiques ou stages passés.
  4. *Points forts du profil*.
  5. *Adéquation pour le stage* : Note sur 10 argumentée et objective.

#### 2. ⚠️ Détection Prédictive des Anomalies d'Assiduité (`encadrant.ai.anomalies`)
- **Fonctionnement** : L'encadrant clique sur "Détecter anomalies IA" depuis la matrice des présences.
- **Données analysées** : Agrégation en temps réel des taux de présence et du volume total des absences de tous les stagiaires.
- **Rôle IA** : Assistant encadrant spécialisé dans la remédiation pédagogique.
- **Sortie structurée générée** :
  - Détection automatique de tout stagiaire passant sous le seuil critique des **75% d'assiduité**.
  - Classification du niveau d'alerte (*Critique* ou *Avertissement*).
  - Identification des risques d'échec du stage.
  - Formulation de recommandations d'action concrètes (entretien de cadrage, convocation, aménagement).

#### 3. 📝 Synthèse et Analyse Pédagogique des Rapports (`encadrant.rapports.analyse_ia`)
- **Fonctionnement** : Depuis la vue d'examen d'un rapport périodique, l'encadrant déclenche l'analyse du compte-rendu.
- **Rôle IA** : Tuteur pédagogique et responsable académique senior.
- **Sortie structurée générée** :
  1. *Résumé des activités* (synthèse en 2-3 phrases clés).
  2. *Points d'attention et difficultés identifiées* (blocages techniques ou relationnels mentionnés par le stagiaire).
  3. *Recommandations pour l'encadrant* (questions à poser au stagiaire lors du prochain point d'étape, pistes d'orientation).
  4. Sauvegarde automatique du résultat en base dans la colonne `analyse_ia` de la table `rapports_periodiques`.

#### 4. 🏆 Génération de Rapport Formel de Performance (`encadrant.ai.rapport`)
- **Fonctionnement** : Accessible directement sur le profil d'un stagiaire.
- **Données transmises** : Nom complet, filière, taux d'assiduité calculé, nombre d'absences, historique des thèmes et entreprises de stage.
- **Rôle IA** : Responsable RH officiel.
- **Sortie générée** : Document formel de 3 à 4 paragraphes administratifs :
  - Appréciation générale du profil.
  - Bilan d'assiduité et de rigueur.
  - Recommandations d'orientation professionnelle.
  - Conclusion officielle prête à l'impression ou à la signature.

#### 5. 💬 Chatbot Tuteur Virtuel Interactif (`stagiaire.ai.chat`)
- **Fonctionnement** : Bulle flottante interactive accessible en bas à droite sur l'espace du stagiaire.
- **Personnalisation contextuelle dynamique** : L'IA reçoit systématiquement en contexte système le prénom, le nom, la filière et le taux de présence exact du stagiaire connecté.
- **Capacités** : Répond avec bienveillance, concision et pertinence à toute question sur les horaires, les conseils de rédaction de rapport, l'organisation du travail et les démarches administratives.
- **Historique de conversation** : Gestion de la mémoire des 10 derniers échanges pour assurer la continuité du dialogue.

---

### 4.6. 🗺️ Module Géolocalisation & Cartographie Interactive

#### A. Enregistrement GPS par le Stagiaire (`/stagiaire/geolocaliser`)
- Interface mobile-friendly dédiée au stagiaire.
- Bouton interactif exploitant l'API `navigator.geolocation` du navigateur.
- Récupère avec précision la **latitude** et la **longitude** actuelles et les transmet via une requête AJAX sécurisée par token CSRF (`/stagiaire/position`).
- Affiche la confirmation et le dernier point géographique enregistré avec horodatage.

#### B. Carte Interactive de Supervision (`/encadrant/carte-interactive`)
- Carte plein écran intégrée via **Leaflet.js** et **OpenStreetMap**, centrée sur la zone d'activité (Cameroun / Yaoundé par défaut).
- Positionnement automatique de marqueurs personnalisés pour chaque stagiaire disposant de coordonnées GPS valides.
- **Infobulles enrichies (Popups)** : Clic sur un marqueur affichant le nom, le prénom, la filière et le lieu de rattachement du stagiaire.
- **Moteur de recherche & filtre** : Filtrage des marqueurs par nom/prénom.
- **Positionnement manuel interactif** : L'encadrant peut cliquer directement sur la carte pour affecter ou corriger manuellement les coordonnées d'un stagiaire via une boîte de dialogue interactive.

---

### 4.7. 📄 Module Génération de Documents PDF Officiels

L'application produit 3 documents administratifs normalisés conformes aux standards professionnels :

#### 1. 🎓 L'Attestation de Fin de Stage (`/encadrant/pdf/attestation/{stagiaire}`)
- Format **A4 Portrait** encadré par une double bordure esthétique aux teintes institutionnelles.
- En-tête officiel de l'établissement / Centre.
- Corps de texte juridique attestant que le stagiaire (nom, prénom, filière) a effectué l'ensemble de sa période pratique avec assiduité, engagement et ponctualité.
- Date de délivrance dynamique formatée en français (`D MMMM YYYY`).
- Bloc formel de signature et cachet réservé à l'encadrant.

#### 2. 🪪 La Carte de Stagiaire Professionnelle (`/encadrant/pdf/carte/{stagiaire}`)
- Format normalisé **A6 Paysage** (badge plastique / plastification).
- En-tête coloré avec identité de la plateforme.
- **Intégration d'image sécurisée** : La photo d'identité du stagiaire est lue sur le système de fichiers, convertie et injectée en **Base64 inline** (`data:image/...;base64`) pour éliminer tout bug de chargement cross-origin ou symlink dans DomPDF.
- Données imprimées : Nom complet, Filière, Numéro de téléphone, Dates de validité du stage, Matricule officiel, QR Code / code visuel et encadré de validation.

#### 3. 📊 Le Registre Mensuel des Présences (`/encadrant/pdf/presences`)
- Format **A4 Paysage** haute densité.
- Titre indiquant le mois et l'année en français (ex: *Octobre 2026*).
- Grille matricielle affichant le nom de chaque stagiaire et l'état de chaque jour du mois :
  - `P` sur fond vert clair pour Présent.
  - `A` sur fond rouge/rose pour Absent.
- Colonne de synthèse avec décompte total des présences, des absences et pourcentage d'assiduité du mois.

---

### 4.8. 🎓 Module Espace Stagiaire (`/stagiaire/*`)

#### A. Tableau de Bord Intégré Stagiaire (`/stagiaire/dashboard`)
- **Indicateur de Progression Globale Algorithmique** :
  L'application calcule une métrique pondérée sur 100% reflétant fidèlement le travail du stagiaire selon la formule mathématique suivante :
  $$\text{Progression Globale} = (0.35 \times \text{Assiduité}) + (0.35 \times \text{Objectifs Réalisés}) + (0.30 \times \text{Rapports Validés})$$
  - **Assiduité (35%)** : Ratio entre les séances où le stagiaire a été marqué présent et le total des pointages.
  - **Objectifs (35%)** : Ratio entre les objectifs au statut `"Terminé"` et le total des objectifs assignés.
  - **Rapports (30%)** : Ratio entre les rapports périodiques au statut `"Validé"` et le total des rapports soumis.
- **Widget interactif des Objectifs** :
  - Consultation de la liste des objectifs assignés par l'encadrant avec leurs dates d'échéance.
  - Sélecteur direct permettant au stagiaire de mettre à jour son état : *À faire*, *En cours*, *Terminé*.
- **Widget des Rapports Périodiques** :
  - Consultation des derniers rapports soumis.
  - Badge de statut avec code couleur explicite (*Soumis*, *Validé*, *Correction demandée*).
  - Lecture des remarques et conseils laissés par l'encadrant.
  - Bouton direct pour soumettre un nouveau rapport.
- **Widget du Calendrier des Présences** :
  - Historique mois par mois des pointages effectués par l'encadrant.
  - Bouton direct de téléchargement de son relevé personnel de présences en PDF.
- **Widget Messagerie** :
  - Formulaire d'envoi de messages écrits à l'attention de l'encadrant.
  - Historique chronologique des questions posées et des réponses apportées par le tuteur.

#### B. Soumission de Rapports Périodiques (`/stagiaire/rapports`)
- Formulaire dédié de dépôt de compte-rendu d'activités.
- Sélection de la périodicité : *Hebdomadaire*, *Bimensuel*, *Mensuel*.
- Saisie du compte-rendu textuel détaillé (minimum 20 caractères pour garantir la consistance).
- Téléversement d'une pièce justificative (PDF, Word DOC/DOCX jusqu'à 10 Mo) avec gestion robuste des erreurs PHP de téléversement (`UPLOAD_ERR_INI_SIZE`, formats non supportés, etc.).
- La validation notifie immédiatement l'ensemble des encadrants via le système d'alertes in-app.

---

### 4.9. 📱 Module Communication & Passerelle WhatsApp

Pour surmonter les limitations des notifications par email souvent ignorées ou bloquées par les filtres antispam, l'application intègre un pont WhatsApp intelligent :
- **Classe d'aide** : [WhatsAppHelper](file:///d:/DEV/Suivi%20stagiaires/app/Helpers/WhatsAppHelper.php).
- **Nettoyage & Formatage international** : Détecte les numéros locaux (commençant par `0` ou `6`) et leur applique automatiquement l'indicatif international du Cameroun (`+237`) ou le standard E.164.
- **Génération automatique de liens profonds (`wa.me`)** :
  - **Création de compte** : `credentialsLink(...)` génère le texte officiel contenant le matricule et le mot de passe provisoire.
  - **Réponse à un message** : `messageLink(...)` informe instantanément le stagiaire qu'une réponse de son tuteur est disponible.
  - **Assistance mot de passe oublié** : Lien prêt à l'envoi vers l'administrateur avec le matricule et l'email du compte bloqué.

---

### 4.10. 🔔 Module Centre de Notifications In-App

- Modèle dédié [AppNotification](file:///d:/DEV/Suivi%20stagiaires/app/Models/AppNotification.php) relié à chaque utilisateur.
- **Badge dans le Header** : Compteur dynamique affichant en rouge le nombre de notifications non lues avec effet d'impulsion visuelle.
- **Gestionnaire centralisé (`/notifications`)** :
  - Liste chronologique des notifications avec typologie visuelle (*Info*, *Success*, *Warning*, *Danger*).
  - Clic sur une notification : marquer comme lu et redirection automatique vers la ressource ciblée (fiche de rapport, dossier de candidature, tableau des utilisateurs).
  - Action globale : bouton "Tout marquer comme lu".

---

### 4.11. 🛡️ Module Serveur de Médias Résilient (`/fichier/{path}`)

Pour pallier les dysfonctionnements classiques des liens symboliques `php artisan storage:link` sur les machines locales Windows ou lors des redéploiements éphémères sur plateformes PaaS (Render, Docker) :
- La route `/fichier/{path}` inspecte une cascade ordonnée de répertoires physiques :
  1. `storage/app/public/{path}`
  2. `storage/app/public/uploads/{filename}`
  3. `storage/app/{path}`
  4. `storage/app/uploads/{filename}`
  5. `public/storage/{path}`
  6. `public/storage/uploads/{filename}`
  7. `public/uploads/{filename}`
  8. `public/{path}`
- Si le fichier physique existe, il est servi avec le bon type MIME (`mime_content_type`) et les en-têtes de prévisualisation en ligne (`Content-Disposition: inline`).
- Si une image de profil n'est pas trouvée, la route génère à la volée un **avatar vectoriel SVG dynamique** dégradé avec silhouette pour éviter toute rupture visuelle dans l'interface utilisateur.

---

## 5. 🗄️ Dictionnaire des Données & Schéma Relationnel

### 5.1 Table `users` (Comptes d'authentification)
| Colonne | Type | Description / Contraintes |
| :--- | :--- | :--- |
| `id` | BIGINT UNSIGNED | Clé primaire auto-incrémentée |
| `nom` | VARCHAR(255) | Nom complet de l'utilisateur |
| `matricule` | VARCHAR(255) | Identifiant unique (ex: `ADMIN001`, `ENC20260001`, `STG20260001`) |
| `email` | VARCHAR(255) | Adresse email unique (nullable) |
| `password` | VARCHAR(255) | Hash sécurisé du mot de passe |
| `role` | ENUM | `'admin'`, `'encadrant'`, `'stagiaire'` |
| `remember_token`| VARCHAR(100) | Jeton de persistance de session |
| `timestamps` | TIMESTAMP | `created_at` et `updated_at` |

### 5.2 Table `stagiaires` (Fiches signalétiques des stagiaires)
| Colonne | Type | Description / Contraintes |
| :--- | :--- | :--- |
| `id` | BIGINT UNSIGNED | Clé primaire auto-incrémentée |
| `sexe` | ENUM('M', 'F') | Sexe du stagiaire |
| `nom` | VARCHAR(255) | Nom de famille |
| `prenom` | VARCHAR(255) | Prénom(s) |
| `naissance` | DATE | Date de naissance (nullable) |
| `lieu_naissance`| VARCHAR(255) | Lieu de naissance (nullable) |
| `telephone` | VARCHAR(20) | Numéro de téléphone pour WhatsApp/appels |
| `email` | VARCHAR(255) | Email unique de contact |
| `password` | VARCHAR(255) | Hash du mot de passe |
| `photo` | VARCHAR(255) | Chemin relatif de la photo d'identité stockée |
| `lieu` | VARCHAR(255) | Lieu / Ville de résidence |
| `filiere` | VARCHAR(100) | Filière académique (ex: Génie Logiciel, Réseaux, RH) |
| `latitude` | DECIMAL(10,8) | Coordonnée GPS de latitude (nullable) |
| `longitude` | DECIMAL(11,8) | Coordonnée GPS de longitude (nullable) |
| `timestamps` | TIMESTAMP | `created_at` et `updated_at` |

### 5.3 Table `demandes_stage` (Candidatures externes)
| Colonne | Type | Description / Contraintes |
| :--- | :--- | :--- |
| `id` | BIGINT UNSIGNED | Clé primaire auto-incrémentée |
| `nom` | VARCHAR(255) | Nom du candidat |
| `prenom` | VARCHAR(255) | Prénom du candidat |
| `email` | VARCHAR(255) | Email du candidat |
| `sexe` | ENUM('M', 'F') | Sexe |
| `photo` | VARCHAR(255) | Photo d'identité téléversée |
| `lieu` | VARCHAR(255) | Établissement ou ville d'origine |
| `filiere` | VARCHAR(100) | Filière de formation |
| `telephone` | VARCHAR(20) | Téléphone |
| `date_debut` | DATE | Date souhaitée de début de stage |
| `date_fin` | DATE | Date souhaitée de fin de stage |
| `cv` | VARCHAR(255) | Chemin du CV (PDF) |
| `lettre` | VARCHAR(255) | Chemin de la lettre de motivation (PDF) |
| `certificat` | VARCHAR(255) | Chemin du certificat de scolarité (PDF) |
| `etat` | ENUM | `'En attente'`, `'Validée'`, `'Refusée'` |
| `mot_de_passe`| VARCHAR(255) | Mot de passe hashé défini lors de la validation |
| `timestamps` | TIMESTAMP | `created_at` et `updated_at` |

### 5.4 Table `stages` (Affectations et contrats de stage)
| Colonne | Type | Description / Contraintes |
| :--- | :--- | :--- |
| `id` | BIGINT UNSIGNED | Clé primaire |
| `stagiaire_id` | BIGINT UNSIGNED | Clé étrangère -> `stagiaires.id` (ON DELETE CASCADE) |
| `date_debut` | DATE | Début effectif du stage |
| `date_fin` | DATE | Fin effective du stage |
| `etablissement` | VARCHAR(255) | Établissement universitaire de provenance |
| `theme` | VARCHAR(255) | Sujet / Projet de recherche et de travail |
| `rapport` | VARCHAR(255) | Rapport de stage final (PDF) |
| `convention` | VARCHAR(255) | Convention de stage officielle signée (PDF) |
| `timestamps` | TIMESTAMP | `created_at` et `updated_at` |

### 5.5 Table `presences` (Feuille d'émargement quotidienne)
| Colonne | Type | Description / Contraintes |
| :--- | :--- | :--- |
| `id` | BIGINT UNSIGNED | Clé primaire |
| `stagiaire_id` | BIGINT UNSIGNED | Clé étrangère -> `stagiaires.id` (ON DELETE CASCADE) |
| `date` | DATE | Date du pointage (unique par stagiaire et par jour) |
| `present` | BOOLEAN | `true` = Présent, `false` = Absent |
| `statut` | VARCHAR(255) | Statut textuel (`Présent` ou `Absent`) |
| `timestamps` | TIMESTAMP | `created_at` et `updated_at` |

### 5.6 Table `objectifs` (Missions et jalons pédagogiques)
| Colonne | Type | Description / Contraintes |
| :--- | :--- | :--- |
| `id` | BIGINT UNSIGNED | Clé primaire |
| `stagiaire_id` | BIGINT UNSIGNED | Clé étrangère -> `stagiaires.id` (ON DELETE CASCADE) |
| `stage_id` | BIGINT UNSIGNED | Clé étrangère -> `stages.id` (nullable, ON DELETE CASCADE) |
| `titre` | VARCHAR(255) | Libellé de l'objectif |
| `description` | TEXT | Détail et consignes d'exécution (nullable) |
| `date_limite` | DATE | Échéance fixée par l'encadrant (nullable) |
| `statut` | ENUM | `'À faire'`, `'En cours'`, `'Terminé'` |
| `timestamps` | TIMESTAMP | `created_at` et `updated_at` |

### 5.7 Table `rapports_periodiques` (Comptes-rendus d'activités)
| Colonne | Type | Description / Contraintes |
| :--- | :--- | :--- |
| `id` | BIGINT UNSIGNED | Clé primaire |
| `stagiaire_id` | BIGINT UNSIGNED | Clé étrangère -> `stagiaires.id` (ON DELETE CASCADE) |
| `stage_id` | BIGINT UNSIGNED | Clé étrangère -> `stages.id` (nullable, ON DELETE SET NULL) |
| `titre` | VARCHAR(255) | Titre synthétique du rapport |
| `periode` | VARCHAR(255) | Période couverte (`Hebdomadaire`, `Bimensuel`, `Mensuel`) |
| `contenu` | TEXT | Description des activités et difficultés rencontrées |
| `fichier` | VARCHAR(255) | Pièce justificative attachée (PDF / Word) |
| `statut` | ENUM | `'Soumis'`, `'Validé'`, `'Correction demandée'` |
| `commentaire_encadrant` | TEXT | Feedback et annotations de l'encadrant |
| `analyse_ia` | TEXT | Synthèse et conseils générés par l'IA Groq |
| `date_soumission` | TIMESTAMP | Date et heure de soumission |
| `timestamps` | TIMESTAMP | `created_at` et `updated_at` |

### 5.8 Table `messages` & `reponses` (Messagerie bidirectionnelle)
| Table | Colonnes Clés | Description |
| :--- | :--- | :--- |
| **`messages`** | `id`, `stagiaire_id`, `encadrant_id`, `message`, `expediteur`, `lu`, `timestamps` | Message initial déposé par le stagiaire |
| **`reponses`** | `id`, `message_id`, `reponse`, `timestamps` | Réponses apportées par le tuteur |

### 5.9 Table `app_notifications` (Notifications système in-app)
| Colonne | Type | Description / Contraintes |
| :--- | :--- | :--- |
| `id` | BIGINT UNSIGNED | Clé primaire |
| `user_id` | BIGINT UNSIGNED | Clé étrangère -> `users.id` (ON DELETE CASCADE) |
| `titre` | VARCHAR(255) | Intitulé court de la notification |
| `message` | TEXT | Texte explicatif |
| `type` | VARCHAR(50) | Niveau visuel : `'info'`, `'success'`, `'warning'`, `'danger'` |
| `lien` | VARCHAR(255) | URL de redirection automatique (nullable) |
| `lu` | BOOLEAN | Indicateur de lecture (`false` par défaut) |
| `timestamps` | TIMESTAMP | `created_at` et `updated_at` |

---

## 6. 💎 Points Forts & Valeur Ajoutée du Projet

1. **Intégration d'IA de dernière génération (Groq / LLaMA 3.3 70B)** :
   Contrairement aux systèmes de gestion classiques limités à de l'enregistrement de données passif, StageTrack fournit une véritable valeur ajoutée cognitive : parsing de CV, notation d'adéquation, détection d'absentéisme et rédaction automatisée de rapports RH.
2. **Formule de progression continue multi-factorielle** :
   Le suivi de l'avancement ne repose pas sur une simple impression subjective mais sur un algorithme pondéré combinant présence physique (35%), réalisation d'objectifs (35%) et validation de rapports périodiques (30%).
3. **Cartographie en direct sur le terrain** :
   Capacité pour les stagiaires de transmettre leur géolocalisation GPS en un clic et pour les encadrants de suivre la dispersion des stagiaires sur une carte OpenStreetMap interactive.
4. **Zéro friction avec WhatsApp** :
   L'utilisation de liens profonds WhatsApp permet de communiquer instantanément identifiants, alertes de mot de passe et notifications sans configuration de serveur SMS coûteux.
5. **Autonomie administrative avec génération PDF instantanée** :
   Production en 1 clic d'attestations certifiées avec cachet, de cartes de stagiaires badge A6 avec photo encodée et de feuilles d'émargement mensuelles.
6. **Design moderne et ergonomie soignée** :
   Interface en verre dépoli (Glassmorphism), animations CSS fluides, responsive design mobile/desktop et bascule Dark/Light mode persistante.
