# Rese(飲食店予約サービス)
Reseは、飲食店の予約を簡単かつ迅速に行うためのWebサービスです。このアプリケーションは、ユーザーが希望する日時や人数に基づいて飲食店の予約をオンラインで簡単に行えるように設計されています。<br>また、予約した店舗の評価やレビューを確認することができ、ユーザーが信頼できる情報をもとに飲食店を選ぶことができます。


## 作成した目的  
Reseを作成した目的は、企業のグループ会社が外部の飲食店予約サービスに支払っている手数料を削減するためです。<br>自社で予約サービスを持つことで、コストを削減し、ユーザーにより良いサービスを提供することを目指しています。また、初年度で10,000人のユーザー数達成を目標としており、使いやすいインターフェースと充実した機能を提供することで、多くのユーザーに利用してもらうことを目的としています。


## アプリケーションURL    

### AWS
* http://54.238.171.131/login (ユーザーURL)
* http://54.238.171.131/admin/login (管理者URL)
* http://54.238.171.131/owner/login (店舗代表者URL)
* mailhog:http://54.238.171.131:8025/  

#### ユーザー用URLの使用方法
* ユーザーは、会員登録後にメールによる本人認証を行い、ログインすることができます。ログイン後は、飲食店一覧を閲覧し、各飲食店の詳細や評価を確認したり、自ら評価を投稿することができます。また、飲食店の予約および予約変更が可能です。<br>決済に関しては、現地決済とカード決済の選択肢が提供されます。予約確認の際には、マイページに表示されるQRコードを飲食店に提示することで、簡単に予約の照合が行えます。

#### 管理者URLの使用方法
* 管理者は、管理者用のメールアドレスとパスワードを使用してログインします。<br>ログイン後、店舗代表者の作成ページで、店舗代表者の名前、メールアドレス、パスワードを生成することができます。

#### オーナーURLの使用方法
* オーナーは、管理者によって作成されたメールアドレスとパスワードを使用してログインします。<br>ログイン後、店舗情報の作成や編集、予約の確認、お知らせメールの送信、QRコードスキャン（お客様のQRコードをスキャンして予約情報を照合する機能）などを利用することができます。


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
<img width="638" alt="スクリーンショット 2024-08-20 15 33 41" src="https://github.com/user-attachments/assets/9ec077d7-813b-4518-954d-9cd183fea1b7">
<img width="644" alt="スクリーンショット 2024-08-20 15 34 01" src="https://github.com/user-attachments/assets/5e607b3a-1662-4227-ad53-10bcefd23359">
<img width="639" alt="スクリーンショット 2024-08-20 15 34 15" src="https://github.com/user-attachments/assets/bd752b7c-2230-4a1d-8872-753627cbba19">
<img width="645" alt="スクリーンショット 2024-08-20 15 34 21" src="https://github.com/user-attachments/assets/679de661-d2c2-45f6-9656-0457115f20b0">




## ER図  
![er drawio](https://github.com/user-attachments/assets/a0307eb7-4d63-4320-bc8e-0ad4bcab796f)


## 環境構築  

**Dockerビルド**  
1.`git clone git@github.com:mmkano/ReseBookingSystem.git`  
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
php artisan db:seed 
```     


## リマインダー起動コマンド
``` bash 
php artisan reminder:send

```   


## 補足事項
* QRコードの読み取り機能を使用する際は、スマートフォンでQRコードを表示し、<br>パソコンなど他のデバイスで読み込むとスムーズに進めることができます。

#### テストユーザー
* email:admin@example.com  password:password (管理者ログイン用)
* email:sennin@example.com password:password (店舗代表者ログイン用）
* email:yamada@example.com password:password (ユーザーログイン用)


## 3つの機能開発の説明(pro)

### 口コミ機能
* 新規口コミ追加:　一般ユーザーは各店舗に対して口コミ（テキスト、星評価、画像）を投稿可能。1店舗に1件のみ投稿できます。
* 口コミ編集: ユーザーは自身の口コミを編集可能。編集時に前回の入力内容が保持されます。
* 口コミ削除: ユーザーは自身の口コミのみ削除可能。管理者は管理者ページのユーザー一覧から特定のユーザーを選択し、そのユーザーの全口コミを表示・削除できます。


### 店舗一覧ソート機能
一般ユーザーは、店舗一覧ページで以下の基準に基づいて店舗を並び替えることができます。
* ランダム：ユーザーがこのオプションを選択するたびに、店舗の並び順がランダムに変わります。<br>これにより、毎回異なる順序で店舗が表示されるため、新しい店舗を見つけやすくなります。
* 評価が高い順：評価が高い店舗から順に並べられます。<br>ただし、評価が一件もない店舗は、このオプションを選択した場合でも最後尾に表示されます。
* 評価が低い順：評価が低い店舗から順に並べられます。<br>同様に、評価が一件もない店舗は最後尾に表示されます。
  
また、各店舗の評価数は、ページアクセス時にリアルタイムで取得・反映されるように実装されています。<br>これにより、ユーザーは最新の評価に基づいて店舗を選ぶことができます。

### csvインポート機能
CSVファイルでは、各データの項目（カラム）をカンマで区切って記載します。<br>以下は、Reseで店舗情報を記載する際のカラムとその説明です。

| カラム名  | 説明 |
| ---- | ---- |
| **店舗名**  | 50文字以内で記載してください。 |
| **地域**  | 「東京都」「大阪府」「福岡県」のいずれかを記載してください。 |
| **ジャンル**  | 「寿司」「焼肉」「イタリアン」「居酒屋」「ラーメン」のいずれかを記載してください。 |
| **店舗概要** | 400文字以内で記載してください。 |
| **画像URL** | 画像のURLを記載してください。対応するファイル形式は「jpeg」「png」のみです。非対応の拡張子が含まれる場合、エラーメッセージが表示され、ファイルのインポートが失敗します。 |


```csv
店舗名,地域,ジャンル,店舗概要,画像URL
寿司太郎,東京都,寿司,新鮮なネタと職人の技術が光る寿司店です。,https://kinoaru.com/wp-content/uploads/2022/08/AdobeStock_280442849-1-1-1.jpeg
焼肉花子,大阪府,焼肉,厳選された牛肉を使用した贅沢な焼肉店です。,https://thumb.photo-ac.com/e8/e841fdf90009a28b4cb5cfdabc8e5ed1_w.jpeg
ラーメン一郎,福岡県,ラーメン,こってりスープが自慢のラーメン店です。,https://www.tototo.biz/staffblog/wp-content/uploads/2021/08/3029540_m.jpg
``` 
#### 注意事項
* カンマ区切り: 各項目はカンマで区切ってください。空白や特殊文字が含まれる場合は、項目をダブルクォート (") で囲んでください。
* エンコード: CSVファイルはUTF-8形式で保存してください。エンコード形式が異なると、データが正しくインポートされない場合があります。

