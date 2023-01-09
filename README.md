# このリポジトリについて

目的：Laravel sailを使ったアプリ開発手順例（on Windows）を作ること


<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## §１ 作業前の準備

### １．現状のシステムが要件を満たすように調整する

#### 要件１：wsl2がインストールされていること

OSがwindows11の場合、すでにwsl2がインストール済であることが場合があるので、下記の手順で確認する。

##### 確認手順

1. PowerShell または Windows コマンド プロンプトを起動する
1. wsl -l -v を入力して、インストールされている Linux ディストリビューションを一覧表示し、それぞれが設定されている WSL のバージョンを確認する。

[確認表示例]

```bash
Microsoft Windows [Version 10.0.22000.978]
(c) Microsoft Corporation. All rights reserved.

C:\Users\yuasy>wsl -l -v
  NAME                   STATE           VERSION
* Ubuntu                 Running         2
```

3. もし「*utunntu　2」が確認できなかったらwsl2をインストールする

#### 要件２：Docker Desktopが起動していること

1. WindowsデスクトップでDockerを検索してインストールの有無を確認する
1. もし、インストールされていなかったらインストールする
1. Docker Desktopを起動する

## §２ laravel sailの導入と設定

以下、utuntuのターミナルで作業する。  
※ubuntuのターミナルは最初windowsデスクトップ検索窓からutuntuと検索して立ち上げておいてピン止めしておくと、次回からの起動が楽にできる。

### １．sailの導入

```bash
$ mkdir <project group> #任意のディレクトリを作成し、
$ cd <project group>    #そこに移動してから作業開始

# laravel sailをインストール
$ curl -s https://laravel.build/<project-name>?php=81|bash
# curlコマンドで、Laravelのプロジェクト作成の最後に、PCのパスワードを求められる

# laravelのプロジェクトが作成さえた直後のメッセージに従い下記コマンドを打つ
$ cd <project-name>
# sailを起動する
$ ./vendor/bin/sail up
# 仮想環境dockerでlaavel sailが機能するのを待って、ブラウザから確認する
# http://localhost
# 確認を終えたら、control+Cでsailを強制終了させる

# sailをバックグラウンドで起動するには　-dオプションをつける
$ ./vendor/bin/sail up -d
# バックグラウンドで起動しているsailを終了させるには下記のコマンドを使う
$ ./vendor/bin/sail stop
```

【表記についての注意事項】  
これ以降のプロジェクト名はtest-appと表記します。  
また、プロジェクトフォルダの絶対パスは~/source/test-app/と表記します。  
異なるバスに異なるプロジェクト名をつかた場合はそれぞれ置き換えて作業を進めてください。

### ２．sailコマンドを楽に使うための設定

前述のように現状では、いちいち./vendor/bin/seil upのようにパス付でコマンドを発行しなければならない結構面倒なのでsail upとスッキリさせたい。そのためにはコマンドのエイリアス（別名）をホームディレクトリ~の直下にある.bashrcファイルの最後尾に追加すればよい

```bash
// viで編集する
$ vi ~/.bashrc

// 編集内容は下記の行を最後尾に追加するだけ（aまたはiで編集モードにする）
alias sail="~/source/test-app/vendor/bin/sail"
// 編集したら、escキーで編集モードから抜け:wqで保存終了する

// ターミナルから下記コマンドを打って変更内容を即時反映する
$ source ~/.bashrc

```

## §３ Laravel Breezeの導入

Laravel Breezeとは：ログイン、ユーザー登録、パスワードリセット、メール確認、パスワード確認など、すべての認証機能を最小かつシンプルにLaravelへ実装したもので、ユーザーが名前、電子メールアドレス、パスワードを更新できるシンプルな「プロファイル」ページが含まれる便利なスターターキット。  
[日本語マニュアル](https://readouble.com/laravel/9.x/ja/starter-kits.html)

🐯注意事項：ターミナル作業をする前に、sailが起動されている事が必要です。起動されていないとエラーになります。

```bash
# Laravel Breezeのパッケージをインストール
$ sail composer require laravel/breeze --dev 

# Laravel Breezeのインストール
$ sail php artisan breeze:install
```

Laravel Breezeをインストールすると、このように初期画面の右上に『Log in』『Register』のリンクが追加される。

![Breeze初期画面](https://onetech.vn/wp-content/uploads/2022/12/image-5.png)
<hr/>

## §４ AdminLTEの導入

### １．イメージ取得とインストール

```bash
# AdminLTEのパッケージをインストールする
$ sail composer require jeroennoten/laravel-adminlte

# AdminLTEをインストールする
$ sail php artisan adminlte:install

```

### ２．管理者テーブルを作成する

ここでは管理者テーブルのテーブル名は「admin_users」とする。

#### (1)マイグレーションファイルとモデルを作成する

```bash
$ sail php artisan make:model AdminUser -m
```

【解説１】モデル名AdminUser:２つの単語をアッパーケース（頭文字を大文字）で連記する。２つ目の単語は必ず単数形で書く。 このルールを守れば「単語１_単語２の複数形」というテーブル名を自動生成してくれる。  

【解説２】オプション -m または --migration：このオプションによりモデルと同時にマイグレーションの各ファイルを自動で生成してくれる。

#### （２）マイグレーションファイルを修正する

```bash
# ---ファイル；ddatabase/migrations/20YY_MM_DD_hhmmss_create_admin_users_table.php
# 以下編集内容（一部）

public function up()
    {
        Schema::create('admin_users', function (Blueprint $table) { // 修正
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }
```

#### （３）AdminUserファイルの編集

Breezeをインストールしたときに作成されているapp/Models/User.phpの記述をコピーして、AdminUser.phpに貼り付けて、クラス名を『User』から『AdminUser』に修正する。

#### （４）config/auth.phpの編集

『users』の部分を『admin_users』、『User』の部分を『AdminUser』に修正する。

```php
<?php
return [

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'admin_users', // 修正
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'admin_users', // 修正
        ],
    ],

    'providers' => [
        'admin_users' => [ // 修正
            'driver' => 'eloquent',
            'model' => App\Models\AdminUser::class, // 修正
        ],
        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    'passwords' => [
        'admin_users' => [ // 修正
            'provider' => 'admin_users', // 修正
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,
];
```

#### （５）RegisteredUserController.phpの編集

app/Http/Controllers/Auth/RegisteredUserController.phpは、以下のように『User』を『AdminUser』に修正する

```php
<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\AdminUser; // 修正
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }
    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.AdminUser::class], // 修正
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $user = AdminUser::create([ // 修正
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        event(new Registered($user));
        Auth::login($user);
        return redirect(RouteServiceProvider::HOME);
    }
}
```

#### （６）マイグレーションを実行

[失敗から修正、成功までの事例]

```bash
# マイグレーションのコマンドを実行
$ sail php artisan migrate
   INFO  Preparing database.  

  Creating migration table ................................................................ 105ms DONE

   INFO  Running migrations.  

  2014_10_12_000000_create_users_table .................................................... 252ms DONE
  2014_10_12_100000_create_password_resets_table .......................................... 300ms DONE
  2019_08_19_000000_create_failed_jobs_table .............................................. 187ms DONE
  2019_12_14_000001_create_personal_access_tokens_table ................................... 289ms DONE
  2023_01_05_201007_create_admin_users_table ................................................ 0ms FAIL

   BadMethodCallException 

  Method Illuminate\Database\Schema\Blueprint::remenberToken does not exist.
～略～
# ↑のエラーは、remenberTokenなんて存在しないと怒っている様子
```

[ エラー解析 ]
🐯エラーメッセージで分かるようにmとnのスペル違いだったようだ。正：rememberToken  誤：remenberToken  

[ 修正前の結果確認方法]

```bash
# マイグレーション結果を確認するコマンド
$ sail php artissan migrate:status
  Migration name ...................................................................... Batch / Status  
  2014_10_12_000000_create_users_table ....................................................... [1] Ran  
  2014_10_12_100000_create_password_resets_table ............................................. [1] Ran  
  2019_08_19_000000_create_failed_jobs_table ................................................. [1] Ran  
  2019_12_14_000001_create_personal_access_tokens_table ...................................... [1] Ran  
  2023_01_05_201007_create_admin_users_table ................................................. Pending  
# ↑予想通りdamin_usersテーブルのみエラーでPendingになっている。（他のテーブルはOK）
```

[ スペルを修正してからサイドマイグレーションして結果を確認する ]

```bash
# 再度マイグレーションを実行
$ sail php artisan migrate
   INFO  Running migrations.  

  2023_01_05_201007_create_admin_users_table .............................................. 118ms DONE
# 再度マイグレーション結果を確認
$ sail php artisan migrate:status
  Migration name ...................................................................... Batch / Status  
  2014_10_12_000000_create_users_table ....................................................... [1] Ran  
  2014_10_12_100000_create_password_resets_table ............................................. [1] Ran  
  2019_08_19_000000_create_failed_jobs_table ................................................. [1] Ran  
  2019_12_14_000001_create_personal_access_tokens_table ...................................... [1] Ran  
  2023_01_05_201007_create_admin_users_table ................................................. [2] Ran  
# ↑全部OKになっていた！
```

#### （７）MySQLコマンドでテーブルが出来ていることを確認

sailから直接mysqlコマンドを打ってDB操作(テーブル存在の確認など）ができる

```bash
$ sail mysql
Reading table information for completion of table and column names
You can turn off this feature to get a quicker startup with -A

Welcome to the MySQL monitor.  Commands end with ; or \g.
Your MySQL connection id is 739
Server version: 8.0.31 MySQL Community Server - GPL

Copyright (c) 2000, 2022, Oracle and/or its affiliates.

Oracle is a registered trademark of Oracle Corporation and/or its
affiliates. Other names may be trademarks of their respective
owners.

Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.

mysql> show tables;
+------------------------+
| Tables_in_test_app     |
+------------------------+
| admin_users            |
| failed_jobs            |
| migrations             |
| password_resets        |
| personal_access_tokens |
| users                  |
+------------------------+
6 rows in set (0.01 sec)

mysql> exit
Bye
```

上記のようになっていればOK  

### ３．ログイン後の画面へのルーティングを設定

#### （１）routes/web.phpの編集（追加）

管理画面のトップページへのルーティングを設定する。ログインしていない場合は管理画面トップにアクセスできないようにミドルウェアを設定しておく。  

```php
<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController; //追加-----------------------------

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//以下を追加-----------------ログインしていないと不可にする-----------------ここから
Route::middleware('auth')->group(function(){
    // ログイン後の画面
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
}) // -------------------------------------------------------------------ここまで

require __DIR__.'/auth.php';
```

#### （２）app/Providers/RouteServiceProvider.php編集で遷移先を設定

下記の通りに変更する

```php
//変更部分のみ以下に記述
public const HOME = '/admin';//変更前 '/dashboard'
```

### ４．コントローラの作成

ここでは、必要なコントローラーを「AdminController」という名前で作成する。

#### （１）AdminControllerを生成するコマンドを実行

```bash
$ sail php artisan make:controller AdminController

   INFO  Controller [app/Http/Controllers/AdminController.php] created successfully.  
```

【確認】
上記のコマンドで app/Http/Controllers/AdminController.phpファイルが自動生成されているか確認する

#### （２）AdminControllerにindexアクションを追加する

app/Http/Controllers/AdminController.phpを下記のように編集する。  


【注意】元ネタとして参考にさせていただいている[サイト](https://onetech.jp/blog/how-to-create-a-good-admin-screen-in-laravel9-15789#lwptoc6)では、この部分のソースが間違っている。  
・間違っている場所：クラス名  
・誤記：AdminMainController  
・正解：AdminController

```php
<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }
}
```

### ５．管理画面トップページの作成

管理画面トップページとは、管理者がログイン直後に表示されるページ。

以下のように、resourses/views/admin/index.blade.phpを作成する。
【注意】このphpページの先頭に 「<? 」を書くとエラーになる。

```php
@extends('adminlte::page')
@section('title', '管理画面トップ')
@section('content_header')
    <h1>管理画面トップページ</h1>
@stop
@section('content')
    <div>ここにコンテンツが入ります。</div>
@stop
@section('css')
    {{-- CSSファイルを記述 --}}
@stop
@section('js')
    {{-- JSファイルを記述 --}}
@stop
```

## §５ AdminLTEのカスタマイズ

### 1. ログイン画面にAdminLTEを適用する

#### (1) AdminLTEの導入状況を確認する

```bash
$ sail php arttisan adminlte:status
Checking the resources installation ...
 7/7 [▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓] 100%
All resources checked succesfully!

+------------------+------------------------------------------+---------------+----------+
| Package Resource | Description                              | Status        | Required |
+------------------+------------------------------------------+---------------+----------+
| assets           | The AdminLTE required assets             | Installed     | true     |
| config           | The default package configuration file   | Installed     | true     |
| translations     | The default package translations files   | Installed     | true     |
| main_views       | The default package main views           | Not Installed | false    |
| auth_views       | The default package authentication views | Mismatch      | false    |
| basic_views      | The default package basic views          | Not Installed | false    |
| basic_routes     | The package routes                       | Not Installed | false    |
+------------------+------------------------------------------+---------------+----------+

Status legends:
+---------------+----------------------------------------------------------------------------------------------+
| Status        | Description                                                                                  |
+---------------+----------------------------------------------------------------------------------------------+
| Installed     | The resource is installed and matches with the default package resource                      |
| Mismatch      | The installed resource mismatch the package resource (update available or resource modified) |
| Not Installed | The package resource is not installed                                                        |
+---------------+----------------------------------------------------------------------------------------------+

```

#### (2) ログイン・登録画面のデザイン変更

ログイン画面のデザインにAdminLTEのテンプレートファイルを適用する
【注意】この手順では既存のログインテンプレートファイルが上書きされるので、必要ならバックアップを行うこと  

以下のコマンドを実行

```bash
$ sail php artisan adminlte:install --only=auth_views
# 下記の警告が出るので、問題がなければ「yes」を入力
The authentication views already exists. Want to replace the views? (yes/no) [no]: yes
```

#### (3) 確認

ログイン画面は```http://localhost/login``` で、登録画面は ```http://localhost/register``` で下記のような画面になっていればOK。
![login](/public/images/login20230109.png)
![register](/public/images/register20230109.png)


