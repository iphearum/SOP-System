FROM node:22-alpine
WORKDIR /usr/src/app

COPY package*.json . || true
RUN if [ -f package.json ]; then npm install || true; fi

COPY . .
EXPOSE 5173
CMD ["npm", "run", "dev", "--", "--host", "0.0.0.0", "--port", "5173"]
