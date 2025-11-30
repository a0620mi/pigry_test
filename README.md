# pigry_test

##環境構築
・git close 
・docker-compose up -d --build

##laravel環境構築
・docker-compose exec php bash
・composer install
・cp .env.example .env
・php artisan key:generate
・php artisan migrate
・php artisan db:seed

##開発環境
・ログイン：http://localhost/login
・会員登録：http://localhost/register
・管理画面：http://localhost/weight_logs
・phpmyAdmin：http://localhost:8080/

##使用技術
・PHP：8.3
・laravel：8.21
・Fortify：1.19
・Livewire：2.12
・MySQL：8.0.２６
・nginx：1.21.1

##ER図
