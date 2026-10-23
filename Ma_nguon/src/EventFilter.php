<?php
declare(strict_types=1);

function filterEvents(
    array $events,
    string $query,
    string $category = '',
    bool $availableOnly = false
): array {
    $result = [];

    foreach ($events as $event) {
        // Loc theo ten su kien
        $matchQuery = $query === ''
            || stripos($event['title'], $query) !== false;

        // Loc theo loai su kien
        $matchCategory = $category === ''
            || $event['category'] === $category;

        // Loc theo so cho con lai
        $matchAvailable = !$availableOnly
            || $event['registered'] < $event['capacity'];

        // Phai thoa man tat ca dieu kien
        if ($matchQuery && $matchCategory && $matchAvailable) {
            $result[] = $event;
        }
    }

    return $result;
}
