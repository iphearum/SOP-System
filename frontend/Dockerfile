FROM node:22-alpine
WORKDIR /usr/src/app

COPY package*.json ./
RUN if [ -f package.json ]; then npm install || true; fi

COPY . .
EXPOSE 3000
CMD ["npm", "run", "dev", "--", "--hostname", "0.0.0.0", "--port", "3000"]
