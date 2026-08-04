<?php
/**
 * Photo gallery for one event: photos.php?event=picnic-2026
 * With no event, or one we don't have, show the list of galleries instead.
 */
require_once __DIR__ . '/includes/event-data.php';

$event = $_GET['event'] ?? '';
if (!is_string($event)) {
    $event = '';
}

if ($event === '' || sara_event_meta($event) === null) {
    header('Location: events.php');
    exit;
}

require __DIR__ . '/includes/gallery.php';
