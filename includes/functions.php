<?php
// includes/functions.php

function getBiografia($pdo) {
    if (!$pdo) return null;
    try {
        $stmt = $pdo->query("SELECT * FROM biografia LIMIT 1");
        return $stmt->fetch();
    } catch (Exception $e) {
        return null;
    }
}

function getHabilidades($pdo) {
    if (!$pdo) return null;
    try {
        $stmt = $pdo->query("SELECT * FROM habilidades ORDER BY orden ASC");
        return $stmt->fetchAll();
    } catch (Exception $e) {
        return null;
    }
}

function getTecnologias($pdo) {
    if (!$pdo) return null;
    try {
        $stmt = $pdo->query("SELECT * FROM tecnologias ORDER BY orden ASC");
        return $stmt->fetchAll();
    } catch (Exception $e) {
        return null;
    }
}

function getProyectos($pdo) {
    if (!$pdo) return null;
    try {
        $stmt = $pdo->query("SELECT * FROM proyectos ORDER BY created_at DESC");
        return $stmt->fetchAll();
    } catch (Exception $e) {
        return null;
    }
}

function sanitize($str) {
    return htmlspecialchars(strip_tags(trim($str)));
}

function isLoggedIn() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: ../login.php');
        exit;
    }
}
