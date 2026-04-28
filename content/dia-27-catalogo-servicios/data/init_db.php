<?php
$db = new PDO('sqlite:' . __DIR__ . '/catalogo.sqlite');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$schema = file_get_contents(__DIR__ . '/schema.sql');
$seed = file_get_contents(__DIR__ . '/seed.sql');
$db->exec($schema);
$db->exec($seed);
echo "Database initialized successfully.\n";
