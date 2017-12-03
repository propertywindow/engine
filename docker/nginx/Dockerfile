FROM nginx:latest

COPY vhost.conf /etc/nginx/conf.d/vhost.conf
COPY propertywindow-engine.conf /etc/nginx/propertywindow-engine.conf

COPY entrypoint.sh /usr/local/bin/

RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ./usr/local/bin/entrypoint.sh