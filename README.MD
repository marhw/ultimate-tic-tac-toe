# Tic Tac Toe game

This repo contains simple Tic Tac Toe game made with Symfony and Vue.js <br>
Game is fully dockerized and standalone, so you can run it on any machine with docker and docker-compose installed.

## Requirements

1. docker
2. docker-compose

## Run project

1. Clone the repository
2. Go to backend-symfony folder and copy `.env.dist` file to `.env`
3. Go to frontend-vue folder and copy the `.env.local.dist` file to `.env.local`
4. Go back to main folder and run in console `docker-compose up`
5. Backend is under [localhost:8000](localhost:8000)
6. Frontend is under [localhost:3000](localhost:3000)

note: both `node_modules` and `vendor` folders are mounted to the host machine after `docker-compose`

## Migration
No migration Required

## Tests
Unfortunately I didn't have time to write tests for this project.

## Backend and backend libraries
I prepared backend with symfony and most of the libraries used are Symfony bundles ex: `nelmio` for CORS or `doctrine/mongodb-odm` for mongodb etc.<br>
I also used `phpstan`, `phpcs` and `psalm` for static analysis and linting.

List of all packages can be found in backend folder in `composer.json` file. under `require` section

## Frontend and frontend libraries
Frontend is made with Vue.js and Vite, external all libraries are for service itself or linting. <br>
Only one external library which I used [normalizer.css](https://necolas.github.io/normalize.css/). This "library" contain set of standardizing css for clear default browser styles and normalize css-es between standard components

List of all packages can be found in frontend folder in `package.json` file. under `require` section

## Other libraries
I used `lint-staged` and `husky` for pre-commit hooks, so before commiting code it will be checked by linters and static analysis tools.