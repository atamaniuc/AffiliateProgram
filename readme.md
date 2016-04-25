# Affiliate Program

## description
This is the two-tier Affiliate Program example written in Laravel 5.2<br />

## install

composer update<br />
artisan key:generate<br />
artisan migrate:install<br />
artisan migrate<br />
artisan db:seed<br />

Set up your .env and add to the end:<br />
PUSHER_APP_ID=200699<br />
PUSHER_KEY=e95c6a7f2c5eed28e4a1<br />
PUSHER_SECRET=5643d0099cb74c93a2c4<br />

## credentials
user: jack@daniels.com <br />
password: secret

## TODO:
1. Set up secure chanels for Pusher, use tokens instead of UserID and remove Long Polling Fallback (or use socket.io).<br />
2. Use UUID instead of incremental ID (was problems with user auth).
3. Implement User Roles.
4. Refactor DB to use Nested Sets for getting many referrers.
5. Set up cache for Eloquent.
6. Use Gulp for frontend.