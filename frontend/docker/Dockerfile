FROM node:14.15.1-alpine3.10

WORKDIR /app

COPY docker/entrypoint.sh /entrypoint.sh
COPY app/package.json /app/package.json
COPY app/yarn.lock /app/yarn.lock

RUN chmod +x /entrypoint.sh

# install packages and start app
CMD ["/entrypoint.sh"]