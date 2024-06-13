# Rese(飲食店予約サービス)
Reseは、飲食店の予約を簡単かつ迅速に行うためのWebサービスです。このアプリケーションは、ユーザーが希望する日時や人数に基づいて飲食店の予約をオンラインで簡単に行えるように設計されています。また、予約した店舗の評価やレビューを確認することができ、ユーザーが信頼できる情報をもとに飲食店を選ぶことができます。


## 作成した目的  
Reseは、飲食店の予約を簡単かつ迅速に行うためのWebサービスです。このアプリケーションは、ユーザーが希望する日時や人数に基づいて飲食店の予約をオンラインで簡単に行えるように設計されています。また、予約した店舗の評価やレビューを確認することができ、ユーザーが信頼できる情報をもとに飲食店を選ぶことができます。


## アプリケーションURL    

### AWS（開発環境）  
* http://57.180.48.130/login
* mailhog:http://57.180.48.130:8025/  

### AWS(本番環境）  
* http://3.112.190.91/login
* mailhog：http://3.112.190.91:8026/


## 機能一覧  
* 会員登録
* ログイン
* 認証機能
* ログアウト
* 店舗検索（エリア、ジャンル、店舗名）
* 予約機能
* 予約変更機能
* 評価機能
* ユーザー別予約情報取得
* メール通知
* リマインダー
* QRコード発行
* 決済機能

	

## 使用技術
* PHP7.4.9
* Laravel8.83.27 
* HTML,CSS  
* MySQL8.0.26    
* NGINX1.21.1  
* MAILHOG  
* PHPMyADMIN  


## テーブル設計  

![スクリーンショット 2024-06-13 9 11 21](https://github.com/mmkano/fashionablylate/assets/155986309/9b03e3af-89e2-40a6-bd55-b4d680862483)
![スクリーンショット 2024-06-13 9 11 33](https://github.com/mmkano/fashionablylate/assets/155986309/7fa868f9-dc6d-4ff3-ac8f-1795e6a85398)
![スクリーンショット 2024-06-13 9 11 49](https://github.com/mmkano/fashionablylate/assets/155986309/860289e0-b6f5-4fa6-98a2-18acf3f4c52f)


## ER図  
![er drawio](https://github.com/mmkano/fashionablylate/assets/155986309/e95cde5c-06fe-4708-8a88-c0c5a37e673d)

* ユーザーがお気に入りに追加した店舗との多対多（many-to-many）リレーションシップを定義します。中間テーブル favorites を使用します。
![er1 drawio](https://github.com/mmkano/fashionablylate/assets/155986309/7553aa8e-5180-4b67-bb6b-8215e357f415)

## 環境構築  

**Dockerビルド**  
1.`git clone git@github.com:mmkano/AttendanceTracker.git`  
2.DockerDesktopアプリを立ち上げる  
3.`docker-compose up -d --build`    
4.「.env.example」ファイルを 「.env」ファイルに命名を変更。または、新しく.envファイルを作成  
5..envに以下の環境変数を追加  
 ```bash
DB_CONNECTION=mysql      
DB_HOST=mysql    
DB_PORT=3306
DB_DATABASE=laravel_db  
DB_USERNAME=laravel_user   
DB_PASSWORD=laravel_pass
```    
6.アプリケーションキーの作成  
``` bash 
php artisan key:generate
```   
7.マイグレーションの実行  
```bash
php artisan migrate
```  
8.シーディングの実行 
``` bash
php artisan db:seed --class=ComprehensiveSeeder
```     


## 補足事項



