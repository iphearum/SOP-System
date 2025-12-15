.PHONY: backend-bootstrap frontend-bootstrap install-all

backend-bootstrap:
cd backend && composer install --no-interaction --prefer-dist || true && cp -n .env.example .env || true && php artisan key:generate

frontend-bootstrap:
cd frontend && npm install || true && cp -n .env.example .env.local || true

install-all: backend-bootstrap frontend-bootstrap
echo "Bootstrap completed"
