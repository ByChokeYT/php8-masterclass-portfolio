<?php
$db = new PDO('sqlite:' . __DIR__ . '/gastos.sqlite');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->exec(file_get_contents(__DIR__ . '/schema.sql'));
$db->exec(file_get_contents(__DIR__ . '/seed.sql'));
echo "Database initialized successfully.\n";
