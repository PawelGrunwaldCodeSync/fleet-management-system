# Instrukcja obsługi projektu Fleet management system

Poniżej znajdziesz opis najważniejszych komend, które ułatwiają pracę z projektem opartym na Dockerze, PHP i narzędziach do analizy kodu.

---

## Komendy Docker

- **up**
  Uruchamia kontenery Dockera w tle.
  ```bash
  make up
  ```

- **stop**
  Zatrzymuje działanie wszystkich kontenerów
  ```bash
  make stop
  ```
  
- **down**
  Zatrzymuje kontenery i je usuwa
  ```bash
  make down
  ```
  
- **bash**
  Wchodzi do kontenera `php`
  ```bash
  make bash
  ```
  
## Komendy Composer

- **install**
  Instaluje wszystkie zależności z `composer.json`
  ```bash
  make install
  ```

## Komendy do analizy kodu i stylu

- **phpstan**
  Uruchamia statyczną analizę kodu
  ```bash
  make phpstan
  ```

- **cs-fix**
  Uruchamia php cs-fixer do ujednolicenia stylu kodu
  ```bash
  make cs-fix
  ```
  
## Testy

- **test**
  Uruchamia phpunit i wszystkie napisane testy
  ```bash
  make test
  ```
  
## Endpointy

- Dokumentacja dostępna jest pod adresem: http://localhost:8000/swagger/doc
