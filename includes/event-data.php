<?php
/**
 * Event photo galleries.
 *
 * To add an event: make a directory under images/events/ and drop photos in it.
 * That's all that's required -- the gallery page, the events index, and the
 * links on the home page all pick it up on the next page load.
 *
 * Optionally add an event.json in the directory to override the defaults:
 *
 *   {
 *     "title":  "2025 SARA Christmas Party",
 *     "date":   "2025-12-09",
 *     "blurb":  "Dino's Pizza & Italian Restaurant, Chicago.",
 *     "kind":   "holiday-party",
 *     "cover":  "group-photo.jpeg",
 *     "hidden": false
 *   }
 *
 * Every field is optional. Without it the title is made from the directory name
 * ("holiday-party-2025" becomes "2025 Holiday Party"), the date comes from the
 * year in the name, and the cover is the first photo.
 */

const SARA_EVENTS_SUBDIR = 'images/events';

/** File extensions treated as photos. */
const SARA_PHOTO_EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif'];

/** Absolute path of the directory holding the event directories. */
function sara_event_dir_root(): string
{
    return dirname(__DIR__) . '/' . SARA_EVENTS_SUBDIR;
}

/**
 * Absolute path of one event's directory, or null if the slug is unusable.
 *
 * Slugs arrive from the query string, so this is the gate: no separators, no
 * dot-dot, and the resolved path has to still be inside images/events.
 */
function sara_event_dir(string $slug): ?string
{
    if (!preg_match('/^[A-Za-z0-9._-]+$/', $slug) || str_contains($slug, '..')) {
        return null;
    }

    $root = realpath(sara_event_dir_root());
    $dir  = realpath(sara_event_dir_root() . '/' . $slug);
    if ($root === false || $dir === false || !is_dir($dir)) {
        return null;
    }
    // Guards against a symlink inside images/events pointing elsewhere.
    return str_starts_with($dir, $root . DIRECTORY_SEPARATOR) ? $dir : null;
}

/**
 * Metadata for one event, event.json merged over the derived defaults.
 * Returns null for an unknown or unusable slug.
 *
 * Keys: slug, title, date, kind, blurb, cover, hidden, count.
 */
function sara_event_meta(string $slug): ?array
{
    static $cache = [];
    if (array_key_exists($slug, $cache)) {
        return $cache[$slug];
    }

    $dir = sara_event_dir($slug);
    if ($dir === null) {
        return $cache[$slug] = null;
    }

    $json = [];
    $file = $dir . '/event.json';
    if (is_file($file)) {
        $decoded = json_decode((string)file_get_contents($file), true);
        if (is_array($decoded)) {
            $json = $decoded;
        }
        // A malformed event.json falls through to the defaults rather than
        // breaking the page.
    }

    $images = sara_event_images($slug);
    $year   = preg_match('/(\d{4})/', $slug, $m) ? $m[1] : null;

    $meta = [
        'slug'   => $slug,
        'title'  => isset($json['title']) && $json['title'] !== ''
            ? (string)$json['title']
            : sara_humanize_slug($slug),
        // An unparseable date in event.json falls back to the derived one.
        'date'   => sara_normalize_date($json['date'] ?? null)
            ?? ($year !== null ? $year . '-01-01' : date('Y-m-d', (int)filemtime($dir))),
        'kind'   => isset($json['kind']) && $json['kind'] !== ''
            ? (string)$json['kind']
            : sara_slug_kind($slug),
        'blurb'  => isset($json['blurb']) ? (string)$json['blurb'] : '',
        'hidden' => !empty($json['hidden']),
        'count'  => count($images),
    ];

    // A cover named in event.json only wins if the file is really there.
    $cover = null;
    if (isset($json['cover']) && $json['cover'] !== '') {
        $named = (string)$json['cover'];
        if (basename($named) === $named && is_file($dir . '/' . $named)) {
            $cover = sara_event_photo_url($slug, $named);
        }
    }
    $meta['cover'] = $cover ?? ($images[0]['url'] ?? null);

    return $cache[$slug] = $meta;
}

/**
 * Slugs of all events that have photos, newest first.
 * Pass a $kind ('picnic', 'holiday-party', ...) to get just that type.
 */
function sara_event_slugs(?string $kind = null): array
{
    $events = [];
    foreach (glob(sara_event_dir_root() . '/*', GLOB_ONLYDIR) ?: [] as $path) {
        $meta = sara_event_meta(basename($path));
        if ($meta === null || $meta['hidden'] || $meta['count'] === 0) {
            continue;
        }
        if ($kind !== null && $meta['kind'] !== $kind) {
            continue;
        }
        $events[] = $meta;
    }

    // Newest first; slug breaks ties so the order is stable.
    usort($events, fn(array $a, array $b) => [$b['date'], $b['slug']] <=> [$a['date'], $a['slug']]);

    return array_column($events, 'slug');
}

/** Metadata of the newest event, or of the newest of one kind. Null if none. */
function sara_latest_event(?string $kind = null): ?array
{
    $slugs = sara_event_slugs($kind);
    return $slugs === [] ? null : sara_event_meta($slugs[0]);
}

/** URL of an event's gallery page. */
function sara_event_url(string $slug): string
{
    return 'photos.php?event=' . rawurlencode($slug);
}

/**
 * A ready-made link to the newest gallery of a kind, or '' when there isn't one
 * yet. Lets a hand-written table row carry a photo link that shows up on its own
 * once the photos are added.
 *
 * $label may contain "%s", replaced by the event's year.
 */
function sara_photo_link(?string $kind = null, string $label = '%s Photos'): string
{
    $event = sara_latest_event($kind);
    if ($event === null) {
        return '';
    }

    $text = str_contains($label, '%s')
        ? sprintf($label, substr($event['date'], 0, 4))
        : $label;

    return '<a href="' . htmlspecialchars(sara_event_url($event['slug']), ENT_QUOTES) . '">'
        . htmlspecialchars($text, ENT_QUOTES) . '</a>';
}

/**
 * Photos in an event directory, sorted naturally so names like 1, 2, 10 come out
 * in that order. Each entry is ['file' => ..., 'url' => ..., 'caption' => ...].
 *
 * If a directory ever holds enough full-size photos to make the grid slow, this
 * is the place to add a GD-generated thumbnail cache and a 'thumb' key.
 */
function sara_event_images(string $slug): array
{
    static $cache = [];
    if (array_key_exists($slug, $cache)) {
        return $cache[$slug];
    }

    $dir = sara_event_dir($slug);
    if ($dir === null) {
        return $cache[$slug] = [];
    }

    $files = [];
    foreach (scandir($dir) ?: [] as $file) {
        if ($file === '.' || $file === '..' || !is_file($dir . '/' . $file)) {
            continue;
        }
        if (in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), SARA_PHOTO_EXTENSIONS, true)) {
            $files[] = $file;
        }
    }
    natcasesort($files);

    $images = [];
    foreach ($files as $file) {
        $images[] = [
            'file'    => $file,
            'url'     => sara_event_photo_url($slug, $file),
            'caption' => sara_photo_caption($file),
        ];
    }

    return $cache[$slug] = $images;
}

/**
 * Web path of one photo. Encoded per segment, because the photo names have
 * spaces, commas and ampersands in them.
 */
function sara_event_photo_url(string $slug, string $file): string
{
    return SARA_EVENTS_SUBDIR . '/' . rawurlencode($slug) . '/' . rawurlencode($file);
}

/**
 * A caption from the file name: "Stan & Udo.jpeg" becomes "Stan & Udo".
 * Returns '' for camera file names, so a folder straight off a camera doesn't
 * end up captioned "Img 1234".
 */
function sara_photo_caption(string $file): string
{
    $name = pathinfo($file, PATHINFO_FILENAME);

    if (preg_match('/^(img|dsc|dscn|dscf|pxl|photo|image|screenshot|p|gopr|mvimg)?[\s_-]*\d+([\s_-]*\d+)*$/i', $name)) {
        return '';
    }

    return trim(ucwords(str_replace(['-', '_'], ' ', $name)));
}

/** "6 photos", or "1 photo". */
function sara_photo_count_label(int $count): string
{
    return $count . ($count === 1 ? ' photo' : ' photos');
}

/** A date from event.json as YYYY-MM-DD, or null if it isn't a date we can read. */
function sara_normalize_date(mixed $date): ?string
{
    if (!is_string($date) || trim($date) === '') {
        return null;
    }

    $time = strtotime($date);

    return $time === false ? null : date('Y-m-d', $time);
}

/** "holiday-party-2025" -> "2025 Holiday Party". Year first, the way we title events. */
function sara_humanize_slug(string $slug): string
{
    $words = preg_split('/[\s_-]+/', $slug, -1, PREG_SPLIT_NO_EMPTY) ?: [];

    $years = array_values(array_filter($words, fn(string $w) => preg_match('/^\d{4}$/', $w) === 1));
    $rest  = array_values(array_filter($words, fn(string $w) => preg_match('/^\d{4}$/', $w) !== 1));

    return trim(ucwords(implode(' ', array_merge($years, $rest))));
}

/** "picnic-2026" -> "picnic". The event type, for linking a topic page to its gallery. */
function sara_slug_kind(string $slug): string
{
    return strtolower(preg_replace('/[\s_-]*\d{4}[\s_-]*$/', '', $slug) ?: $slug);
}
