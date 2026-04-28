<?php
/**
 * MAIN VIEW AGGREGATOR
 * Estructura modular dividida por las 5 fases oficiales del curso.
 */
?>

<!-- Hero Section -->
<?php include __DIR__ . '/sections/hero.php'; ?>

<!-- Methodology Pillars -->
<?php include __DIR__ . '/sections/pillars.php'; ?>

<!-- Methodology Deep Dive -->
<?php include __DIR__ . '/sections/methodology.php'; ?>

<!-- Target Audience / Prerequisites -->
<?php include __DIR__ . '/sections/prerequisites.php'; ?>

<!-- Meet the Mentor -->
<?php include __DIR__ . '/sections/mentor.php'; ?>

<!-- Learning Path: 5 Phases -->
<div id="learning-path" class="max-w-7xl mx-auto px-6 space-y-20 py-20">
    
    <?php include __DIR__ . '/sections/fase-01.php'; ?>
    
    <?php include __DIR__ . '/sections/fase-02.php'; ?>
    
    <?php include __DIR__ . '/sections/fase-03.php'; ?>
    
    <?php include __DIR__ . '/sections/fase-04.php'; ?>
    
    <?php include __DIR__ . '/sections/fase-05.php'; ?>

</div>

<!-- Tech Toolkit -->
<?php include __DIR__ . '/sections/stack.php'; ?>

<!-- Social Proof / Testimonials -->
<?php include __DIR__ . '/sections/testimonials.php'; ?>

<!-- FAQ -->
<?php include __DIR__ . '/sections/faq.php'; ?>

<!-- Community Section -->
<?php include __DIR__ . '/sections/community.php'; ?>

<!-- Lead Magnet / Newsletter -->
<?php include __DIR__ . '/sections/newsletter.php'; ?>

<!-- Final Footer -->
<?php include __DIR__ . '/sections/footer.php'; ?>
