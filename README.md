## Requirements
- PHP 8.2+
- Composer 2.6+
- Node 18+
- NPM 9+

## Installation
1. `cp .env.example .env`
2. `composer install`
3. `php artisan key:generate`
4. `php artisan migrate`
5. `php artisan db:seeed`
7. `npm install`
8. `npm run build`
9. `php artisan serve`
10. Open the link (default http://127.0.0.1:8000)
- By default, the project runs with sqlite for out-of-the-box functionality
  - Postgres configs are ready & commented out in the .env file

## Notes
- The Show Selected alert() works fine on my browsers (win+edge & mac+chrome),
perhaps there's a browser setting preventing JS alerts?
- I modified the code slightly to show the selected codes in the button title,
while the "correct" way would be to set up an html modal to pop up,
rather than a JS alert.
