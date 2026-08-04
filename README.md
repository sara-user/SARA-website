Source code for the Suburban Amateur Repeater Association web site. https://sararepeater.com

Testing locally, using PHP's built-in webserver, not for production use:

```php -S localhost:8000```

## How to add a new event's photos

No PHP editing needed. Any event works -- picnic, Christmas party, field day.

### 1. Make a folder under `images/events/`

Name it after the event, ending with the year:

```
images/events/holiday-party-2025/
```

### 2. Copy the photos into it

JPG, PNG, GIF, WEBP and AVIF are all picked up. Anything else in the folder is
ignored.

### 3. Add `event.json` in the same folder (optional, but nicer)

```json
{
  "title": "2025 SARA Christmas Party",
  "date": "2025-12-09",
  "blurb": "Dino's Pizza & Italian Restaurant, Chicago.",
  "kind": "holiday-party"
}
```

Skip this and the page still works -- it just gets titled from the folder name,
"2025 Holiday Party", and dated January 1st of that year.

### 4. Look at it

Start the local server (`php -S localhost:8000`) and open
<http://localhost:8000/events.php>. The new event is there. Commit and deploy.

### What shows up where

| Page | What it shows |
|---|---|
| `events.php` | Every gallery, newest first. Always automatic. |
| `photos.php?event=holiday-party-2025` | The gallery itself. |
| `index.php` | Top-of-page link to the newest gallery of any kind, plus a link in the Events card next to the Christmas Party and Picnic rows. |
| `picnic.php`, `holidayParty.php` | A link to that event's own newest gallery. |

A brand new *kind* of event -- say Field Day -- shows up on `events.php` and can
take the top-of-page spot on the home page on its own. To also give it a row in
the home page Events card, copy one of the existing rows in `index.php` and call
`sara_photo_link('field-day')`.

### The `event.json` fields

All optional.

| Field | Default when left out |
|---|---|
| `title` | Made from the folder name: `holiday-party-2025` becomes "2025 Holiday Party" |
| `date` | January 1st of the year in the folder name. Sets the order galleries are listed in, so it's worth filling in. |
| `blurb` | Nothing. A sentence under the title -- where it was, what it was. |
| `kind` | Folder name minus the year: `picnic-2026` becomes `picnic`. This is what links `picnic.php` or `holidayParty.php` to its own newest gallery, so reuse `picnic` and `holiday-party` for those. |
| `cover` | The first photo. A file name in this folder, used for the card on `events.php`. |
| `hidden` | `false`. Set `true` to put a gallery up before announcing it -- it's reachable by URL but not listed anywhere. |

### Photo captions

Captions come from the file names, so `Stan & Udo.jpeg` is captioned "Stan & Udo".
Rename files to caption them. Camera names like `IMG_4821.jpeg` or `DSC_0007.jpg`
get no caption rather than a useless one.

Spaces, commas and `&` in file names are fine.

## This uses:
- Mostly HTML
- [Bootstrap](https://getbootstrap.com) 
- [GLightbox](https://github.com/biati-digital/glightbox) for the photo galleries
- A bit of PHP for header, footer and contact form.
~~- MySQL for contact page form.~~


## Deploy
```aiignore
git clone https://github.com/sara-user/SARA-website
cd SARA-website/
cp -R * ..
```

This written by Dick Lieber, WA9NNN.