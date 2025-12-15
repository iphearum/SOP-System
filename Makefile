.PHONY: backend-bootstrap frontend-bootstrap install-all

backend-bootstrap:
cd backend && if [ ! -f artisan ]; then composer create-project laravel/laravel .; fi && cp -n .env.example .env || true && php artisan key:generate

frontend-bootstrap:
cd frontend && if [ ! -f package.json ]; then npm create vite@latest . -- --template react; fi && npm install

install-all: backend-bootstrap frontend-bootstrap
echo "Bootstrap completed"
