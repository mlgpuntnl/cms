# CMS
Just a cms

## Setup development envoirment
### Prerequisites
Make sure you have installed the following programs:
- [Docker](https://www.docker.com/) (or [Podman](https://podman.io/))
- [NodeJS & npm](https://nodejs.org/en)
### Evnoirment variables
- Copy the `.env.example` file and rename it to `.env`.
- Fill the `.env` file with the desired variables
- Only envoirment variables starting with `APP_` will be available in your JabvaScript modules.

### Installation
Setup backend components:
```
docker-compose build
```
Setup asset bundeling & hot reloads:
```
npm install
```

### Run local dev envoirment
Backend server:
```
docker-compose up
```
Asset bundeling & hot reloads:
```
npm run dev
```

## CLI acces

```
docker-compose run --rm php php public/index.php [command] [...arguments]
```
