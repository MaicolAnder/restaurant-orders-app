# Usar una imagen base de Node.js
FROM node:latest as builder

# Establecer el directorio de trabajo en el contenedor
WORKDIR /app

# Copiar el archivo package.json y package-lock.json para instalar dependencias
COPY ./package*.json ./

# Instalar dependencias
RUN npm install

# Copiar el resto de los archivos de la aplicación
COPY . .

# Compilar la aplicación Angular
RUN npm run build --prod

# Usar una imagen base más ligera para el despliegue
FROM nginx:alpine

# Copiar los archivos compilados de la aplicación Angular desde la etapa anterior
COPY --from=builder /app/dist/web-restaurant-app /usr/share/nginx/html

# Exponer el puerto 80 del contenedor
EXPOSE 80

# Comando para iniciar Nginx cuando se ejecute el contenedor
CMD ["nginx", "-g", "daemon off;"]
