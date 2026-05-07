# Docker (PHP 7.4 + Apache Rewrite + MySQL)

## 1) .env hazirla

```bash
cp .env.example .env
```

Lazim olan deyerleri `.env` faylinda deyisin.

## 2) Start

```bash
docker compose up -d --build
```

App: `http://localhost:${APP_PORT}`

phpMyAdmin: `http://localhost:${PMA_PORT}`

## Stop

```bash
docker compose down
```

## Reset DB (fresh import from `kitabxana.sql`)

```bash
docker compose down -v
docker compose up -d --build
```

## Notes

- Apache `mod_rewrite` aktivdir.
- `.htaccess` isleyir (`AllowOverride All`).
- CodeIgniter DB ayarlari env deyisenlerinden oxunur:
  - `DB_HOST`
  - `DB_USER`
  - `DB_PASS`
  - `DB_NAME`

- `DB_PASS_HASH_SHA256` yalnız referans ucundur; MySQL konteyneri `DB_PASS` plain deyerinden istifade edir.
