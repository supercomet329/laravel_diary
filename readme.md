## 環境構築
- DBの作成

- `cp .env.example .env`

- 自分の環境に合わせて.envを編集
```
DB_DATABASE={DB_NAME}
DB_USERNAME={DB_USER}
DB_PASSWORD={DB_PASSWORD}
DB_SOCKET=/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock   //XAMPPを使用する場合のみ追記
```

- `composer install`

- `php artisan key:generate`

- `php artisan migrate:fresh --seed`

- `php artisan serve`

Go World!!