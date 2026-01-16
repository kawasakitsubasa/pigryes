# PiGLy（体重管理アプリ）

---



### Dockerビルド
git clone git@github.com:kawasakitsubasa/pigryes.git
cd pigly
docker-compose up -d --build

## 環境構築
docker-compose exec php bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed

## 開発環境
トップページ（ログイン）
http://localhost/login

ユーザー登録
http://localhost/register

phpMyAdmin
http://localhost:8080/

##　使用技術（実行環境）

・PHP 8.2

・Laravel 8.x

・MySQL 8.0

・nginx

・Docker / Docker Compose

##　ER図

```mermaid
erDiagram
    users ||--o{ weight_logs : has
    users ||--|| weight_targets : has

    users {
        bigint id PK
        string name
        string email
        string password
        float current_weight
        timestamp created_at
        timestamp updated_at
    }

    weight_logs {
        bigint id PK
        bigint user_id FK
        date date
        float weight
        int calories
        int exercise_minutes
        string exercise_content
        timestamp created_at
        timestamp updated_at
    }

    weight_targets {
        bigint id PK
        bigint user_id FK
        float target_weight
        timestamp created_at
        timestamp updated_at
    }

