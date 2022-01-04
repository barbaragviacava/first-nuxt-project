FROM node:14.15.1-alpine3.10

WORKDIR /app

# Adicionando `/app/node_modules/.bin` para o $PATH
ENV PATH /app/node_modules/.bin:$PATH

# Instalando dependências da aplicação e armazenando em cache.
COPY app/package.json /app/package.json
COPY app/yarn.lock /app/yarn.lock

RUN yarn install

# start app
CMD ["yarn", "dev"]