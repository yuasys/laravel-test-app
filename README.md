# このリポジトリについて

目的：Laravel sailを使ったアプリ開発手順例を作ること


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

```bash
$ mkdir <project group> #任意のディレクトリを作成し、
$ cd <project group>    #そこに移動してから作業開始

# laravel sailをインストール
$ curl -s https://laravel.build/<project-name>|bash
```
