<?php
$pdo = new PDO('sqlite:/var/www/data/beefybill.db');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
