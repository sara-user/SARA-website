Source code for the Suburban Amateur Repeater Association web site. https://sararepeater.com

Testing locally, using PHP's built-in webserver, not for production use:

```php -S localhost:8000```

## This uses:
- Mostly HTML
- [Bootstrap](https://getbootstrap.com) 
- A bit of PHP for header, footer and contact form.
- MySQL for contact page form.


## Deploy
```aiignore
git clone https://github.com/sara-user/SARA-website
cd SARA-website/
cp -R * ..
```

This written by Dick Lieber, WA9NNN.