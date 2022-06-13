# Ecom

## Ecommerce Web App with, using a Laravel backend, Web iterface for users, and cross platform ElectronJS admin dashboard
<hr>

## Version
1.0.0

## N.B. If you have LiveServer installed in VScode, avoid having the laravel backend repository cloned into the same folder as the UI repositories, it can cause continuous reloads.
<hr>

# Usage

## 1 - Clone this repo, the laravel backend
### 1.a For faster setup, copy the .env.example contents into .env
### 1.b Install the dependencies

```sh
$ composer install
```
### 1.c Create database "ecomdb" using XAMPP phpMyAdmin interface
### 1.d Run the included migrations
```sh
$ php artisan migrate
```
### 1.e Get the Apache and mySQL servers running, then do:
```sh
$ php artisan serve
```
<hr>

### To test the ElectronJS interface: you should have NodeJS and NPM intstalled.
## 2 - Clone electron repo into your device: https://github.com/hsein-bitar/ecom-electron.git

### 2.a Install the dependencies
```sh
$ npm install
```
### 2.b Run Electron

```sh
$ npm start
```
<hr>

## 3 - To test the Website interface: Clone the following repo into your device: https://github.com/hsein-bitar/ecom-frontend.git