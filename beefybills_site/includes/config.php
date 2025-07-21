<?php
$pdo = new PDO('sqlite:../data/beefybill.db');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
