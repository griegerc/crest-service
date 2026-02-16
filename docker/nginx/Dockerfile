FROM nginx:1.29.3

RUN echo 'alias ll="ls -la"' >> ~/.bashrc
RUN apt-get update
RUN apt-get install -y less
RUN apt-get install -y nano

WORKDIR /var/www/csrv