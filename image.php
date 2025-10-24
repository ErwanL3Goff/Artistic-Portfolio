<?php
// Au début de chaque fichier PHP, ajouter ceci pour la base URL
$base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
$image_path = $base_url . '/images/';
include 'data/images.php';

$category = $_GET['category'] ?? 'fanfiction';
$imageId = $_GET['id'] ?? 0;

// Vérifier si la catégorie et l'ID existent
if (!isset($images[$category]) || !isset($images[$category][$imageId])) {
    header('Location: index.php');
    exit;
}

$image = $images[$category][$imageId];
$categoryImages = $images[$category];
$totalImages = count($categoryImages);

// Calculer les IDs précédent et suivant
$prevId = ($imageId - 1 + $totalImages) % $totalImages;
$nextId = ($imageId + 1) % $totalImages;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $image['title'] ?><img src="<?= $image_path . $image['file'] ?>"  - Portfolio Artistique</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-900 text-white">
    <!-- En-tête -->
    <header class="bg-gray-800 py-4 sticky top-0 z-10 shadow-lg">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <a href="index.php?category=<?= $category ?>" class="text-purple-400 hover:text-purple-300 transition-colors duration-300">
                <i class="fas fa-arrow-left mr-2"></i> Retour au portfolio
            </a>
            <h1 class="text-xl font-bold"><?= ucfirst($category) ?></h1>
        </div>
    </header>

    <!-- Contenu principal -->
    <main class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Navigation entre images -->
            <div class="flex justify-between items-center mb-6">
                <a href="image.php?category=<?= $category ?>&id=<?= $prevId ?>" 
                   class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors duration-300">
                    <i class="fas fa-chevron-left mr-2"></i> Précédent
                </a>
                
                <span class="text-gray-400"><?= $imageId + 1 ?> / <?= $totalImages ?></span>
                
                <a href="image.php?category=<?= $category ?>&id=<?= $nextId ?>" 
                   class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors duration-300">
                    Suivant <i class="fas fa-chevron-right ml-2"></i>
                </a>
            </div>

            <!-- Image en grand -->
            <div class="bg-gray-800 rounded-lg overflow-hidden shadow-xl mb-6">
                <div class="flex justify-center items-center p-4">
                    <img src="images/<?= $image['file'] ?>" 
                         alt="<?= $image['title'] ?>" 
                         class="max-w-full max-h-[70vh] object-contain">
                </div>
            </div>

            <!-- Informations sur l'image -->
            <div class="bg-gray-800 rounded-lg p-6 shadow-xl">
                <h2 class="text-2xl font-bold mb-2"><?= $image['title'] ?></h2>
                <p class="text-gray-300"><?= $image['description'] ?></p>
                
                <div class="mt-6 flex justify-between items-center">
                    <span class="text-purple-400 font-semibold">Catégorie: <?= ucfirst($category) ?></span>
                    <a href="images/<?= $image['file'] ?>" 
                       download 
                       class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition-colors duration-300">
                        <i class="fas fa-download mr-2"></i> Télécharger
                    </a>
                </div>
            </div>
        </div>
    </main>

    <!-- Pied de page -->
    <footer class="bg-gray-800 py-6 mt-12">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; <?= date('Y') ?> Portfolio Artistique. Tous droits réservés.</p>
        </div>
    </footer>
</body>
</html>