FROM nginx:stable-alpine

ENV TZ Asia/Tokyo

COPY ./infra/conf/nginx/server.conf /etc/nginx/nginx.conf

CMD ["nginx", "-g", "daemon off;"]