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

### 現状のシステムが要件を満たすように調整する

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
