<?php
include 'data/images.php';
$categories = array_keys($images);
$activeCategory = $_GET['category'] ?? 'fanfiction';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio Artistique</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .slider-container {
            scroll-behavior: smooth;
        }
        .slider-item {
            flex: 0 0 auto;
            width: 800px;
            height: 450px;
        }
        .image-container {
            width: 800px;
            height: 450px;
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="bg-gray-900 text-white">
    <!-- En-tête -->
    <header class="bg-gray-800 py-6 sticky top-0 z-10 shadow-lg">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold text-center">Portfolio Artistique</h1>
            <p class="text-center text-gray-400 mt-2">Découvrez mes créations artistiques</p>
        </div>
    </header>

    <!-- Navigation par catégories -->
    <nav class="bg-gray-700 py-4 sticky top-16 z-10">
        <div class="container mx-auto px-4">
            <div class="flex justify-center space-x-6">
                <?php foreach ($categories as $category): ?>
                    <a href="?category=<?= $category ?>" 
                       class="px-4 py-2 rounded-lg transition-all duration-300 <?= $activeCategory === $category ? 'bg-purple-600 text-white' : 'bg-gray-600 text-gray-300 hover:bg-gray-500' ?>">
                        <?= ucfirst($category) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </nav>

    <!-- Contenu principal -->
    <main class="container mx-auto px-4 py-8">
        <!-- Slider pour la catégorie active -->
        <section class="mb-12">
            <h2 class="text-2xl font-bold mb-6 text-center"><?= ucfirst($activeCategory) ?></h2>
            
            <div class="relative">
                <div class="slider-container flex overflow-x-auto space-x-6 pb-4 scrollbar-hide" id="slider-<?= $activeCategory ?>">
                    <?php foreach ($images[$activeCategory] as $index => $image): ?>
                        <div class="slider-item bg-gray-800 rounded-lg overflow-hidden shadow-lg transition-transform duration-300 hover:scale-105">
                            <a href="image.php?category=<?= $activeCategory ?>&id=<?= $index ?>">
                                <div class="image-container" style="background-image: url('images/<?= $image['file'] ?>')"></div>
                                <div class="p-4">
                                    <h3 class="text-lg font-semibold"><?= $image['title'] ?></h3>
                                    <p class="text-gray-400 text-sm mt-2 truncate"><?= $image['description'] ?></p>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- Contrôles du slider -->
                <button class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-3 rounded-r-lg hover:bg-opacity-70 transition-all duration-300" 
                        onclick="scrollSlider('<?= $activeCategory ?>', -1)">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-3 rounded-l-lg hover:bg-opacity-70 transition-all duration-300" 
                        onclick="scrollSlider('<?= $activeCategory ?>', 1)">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </section>

        <!-- Miniatures pour les autres catégories -->
        <?php foreach ($categories as $category): ?>
            <?php if ($category !== $activeCategory): ?>
                <section class="mb-12">
                    <h2 class="text-2xl font-bold mb-6 text-center"><?= ucfirst($category) ?></h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <?php 
                        // Afficher seulement 4 images pour les catégories non actives
                        $displayImages = array_slice($images[$category], 0, 4);
                        foreach ($displayImages as $index => $image): ?>
                            <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg transition-transform duration-300 hover:scale-105">
                                <a href="image.php?category=<?= $category ?>&id=<?= $index ?>">
                                    <div class="h-48 bg-cover bg-center" style="background-image: url('images/<?= $image['file'] ?>')"></div>
                                    <div class="p-4">
                                        <h3 class="text-lg font-semibold"><?= $image['title'] ?></h3>
                                        <p class="text-gray-400 text-sm mt-2 truncate"><?= $image['description'] ?></p>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="text-center mt-6">
                        <a href="?category=<?= $category ?>" class="inline-block bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg transition-colors duration-300">
                            Voir plus de <?= ucfirst($category) ?>
                        </a>
                    </div>
                </section>
            <?php endif; ?>
        <?php endforeach; ?>
    </main>

    <!-- Pied de page -->
    <footer class="bg-gray-800 py-6 mt-12">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; <?= date('Y') ?> Le Goff Erwan. Tous droits réservés.</p>
        </div>
    </footer>

    <script>
        function scrollSlider(category, direction) {
            const slider = document.getElementById(`slider-${category}`);
            const scrollAmount = 824; // 800px + 24px de marge
            slider.scrollBy({
                left: direction * scrollAmount,
                behavior: 'smooth'
            });
        }
    </script>
</body>
</html>