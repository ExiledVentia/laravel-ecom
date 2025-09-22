## Basic Laravel e-commerce.

A colaboration between amateurs to create a *horrid* laravel-based E-commerce Application.

## Tech Stack
- Laravel
- PHP
- MySQL
- TailwindCSS

## Installation Guide

1. Git clone this into laragon's www directory.
2. cd into the new directory and run 'composer install'
3. copy the '.env.example' file and delete the .example part.
4. Run the command 'php artisan key:generate', run 'php artisan storage:link' and change the filesystem_disk to public.
5. Run 'php artisan migrate:fresh --seed' and enjoy this thing.
