# Stage 1: Build Angular Application
FROM node:20-alpine AS build
WORKDIR /usr/src/app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build --prod

# Stage 2: Nginx Web Server
FROM nginx:1.23.4-alpine

# Copiar compilado Angular al directorio estatico de Nginx
COPY --from=build /usr/src/app/dist/tesoreria-frontend/browser /usr/share/nginx/html

# Copiar configuracion de Nginx
ADD --chown=root:root nginx.conf /etc/nginx/conf.d/default.conf

# Copiar los archivos de certificado y clave SSL al contenedor
COPY fullchain.pem /etc/nginx/ssl/fullchain.pem
COPY emssanareps.co.key /etc/nginx/ssl/emssanareps.co.key

EXPOSE 8464
