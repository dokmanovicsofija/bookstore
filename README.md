# Bookstore Application

## Pregled

Ovaj projekat koristi Docker i Docker Compose za pokretanje aplikacije i baze podataka u kontejnerima. U ovom dokumentu su opisani koraci za preuzimanje repozitorijuma, konfiguraciju i pokretanje aplikacije.

## Preduslovi

- [Docker](https://www.docker.com/get-started) (verzija 20.10 ili novija)
- [Docker Compose](https://docs.docker.com/compose/install/) (verzija 1.27.0 ili novija)
- [Git](https://git-scm.com/book/en/v2/Getting-Started-Installing-Git) (verzija 2.0 ili novija)

## Kloniranje Repozitorijuma

1. **Klonirajte repozitorijum sa GitHub-a:**

   U terminalu, u direktorijumu gde želite da sačuvate projekat, pokrenite:

    ```sh
    git clone https://github.com/dokmanovicsofija/bookstore.git
    ```

2. **Pređite u direktorijum projekta:**

    ```sh
    cd bookstore
    ```

## Konfiguracija

1. **Kreirajte `.env` fajl:**

   U istom direktorijumu gde se nalazi vaš `docker-compose.yaml` fajl, kreirajte `.env` fajl sa sledećim sadržajem:

    ```env
    DB_HOST=127.0.0.1
   DB_NAME=bookstore
   DB_USER=root
   DB_PASS=root
   DB_CHARSET=utf8mb4
   DB_ROOT_PASSWORD=root
   DB_PORT=3306
   DB_DATABASE=bookstore
   DB_USERNAME=root
   DB_PASSWORD=root
   MYSQL_ROOT_PASSWORD=root
   MYSQL_DATABASE=bookstore
    ```

   Ovaj fajl definiše promenljive okruženja koje će biti korišćene u `docker-compose.yaml` fajlu.

2. **Ažurirajte `docker-compose.yaml` fajl:**

   Otvorite `docker-compose.yaml` fajl u direktorijumu projekta i ažurirajte ga da koristi preuzetu sliku i promene definisane u `.env` fajlu. Trebalo bi da izgleda ovako:

    ```yaml
    version: '3.8'

    services:
      web:
        image: dokmanovicsofija/bookstore_web:latest
        container_name: bookstore-web
        ports:
          - "8081:80"
        environment:
          - DB_HOST=db
          - DB_PORT=${DB_PORT}
          - DB_DATABASE=${DB_DATABASE}
          - DB_USERNAME=${DB_USERNAME}
          - DB_PASSWORD=${DB_PASSWORD}
        depends_on:
          - db

      db:
        image: mysql:8.0
        container_name: bookstore-db
        environment:
          MYSQL_ROOT_PASSWORD: ${MYSQL_ROOT_PASSWORD}
          MYSQL_DATABASE: ${MYSQL_DATABASE}
        volumes:
          - db-data:/var/lib/mysql
          - ./scripts/seedData3.sql:/docker-entrypoint-initdb.d/seedData3.sql
   volumes:
    db-data:
  ```

## Preuzimanje Docker Slike sa Docker Hub-a

1. **Prijavite se na Docker Hub:**

   Ako već niste prijavljeni, prijavite se koristeći:

    ```sh
    docker login
    ```

2. **Preuzmite sliku sa Docker Huba:**

    ```sh
    docker pull dokmanovicsofija/bookstore_web:latest
    ```

## Pokretanje Aplikacije

1. **Izgradite i pokrenite kontejnere:**

   U terminalu, u direktorijumu gde se nalazi vaš `docker-compose.yaml` fajl, pokrenite:

    ```sh
    docker-compose up --build
    ```

   Ova komanda će preuzeti potrebne slike, izgraditi vašu aplikaciju i pokrenuti kontejnere za aplikaciju i bazu podataka.

2. **Proverite da li su kontejneri uspešno pokrenuti:**

   Možete koristiti sledeću komandu da proverite status kontejnera:

    ```sh
    docker-compose ps
    ```

   Trebalo bi da vidite kontejnere `bookstore-web` (vaša aplikacija) i `bookstore-db` (baza podataka) u statusu `Up`.

3. **Pristupite aplikaciji:**

   Otvorite web pretraživač i idite na [http://localhost:8081](http://localhost:8081). Trebalo bi da vidite vašu aplikaciju u radu.

4. **Zaustavite kontejnere:**

   Kada želite da zaustavite i uklonite kontejnere, koristite:

    ```sh
    docker-compose down
    ```

   Ova komanda će zaustaviti sve pokrenute kontejnere i ukloniti ih.

## SQL Skripta za Inicijalizaciju

U direktorijumu `./scripts` nalazi se SQL skripta `seedData2.sql`, koja će biti automatski izvršena prilikom pokretanja baze podataka. Skripta kreira bazu podataka i dodaje demo podatke, uključujući najmanje 20 autora i 20,000 knjiga.