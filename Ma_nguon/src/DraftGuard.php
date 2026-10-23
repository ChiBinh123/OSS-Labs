<?php
declare(strict_types=1);

function canComplete(
    array $session,
    int $requestedEventId,
    int $now,
    int $ttl
): bool {
    // Kiem tra TTL hop le
    if ($ttl <= 0) {
        return false;
    }

    // Kiem tra ban nhap co ton tai
    if (!isset($session['draft']) || !is_array($session['draft'])) {
        return false;
    }

    $draft = $session['draft'];

    // Kiem tra thong tin ban nhap
    if (!isset($draft['data'], $draft['created_at'])) {
        return false;
    }

    if (!is_array($draft['data'])) {
        return false;
    }

    // Kiem tra dung su kien
    if (!isset($draft['data']['event_id'])) {
        return false;
    }

    if ($draft['data']['event_id'] !== $requestedEventId) {
        return false;
    }

    // Kiem tra thoi gian tao ban nhap
    $createdAt = $draft['created_at'];

    if (!is_int($createdAt)) {
        return false;
    }

    if ($createdAt > $now) {
        return false;
    }

    // Ban nhap phai chua het han
    if ($now - $createdAt >= $ttl) {
        return false;
    }

    return true;
}
