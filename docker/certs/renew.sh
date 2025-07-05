#!/bin/sh
trap exit TERM
while :; do
  sleep 6h
  certbot renew --webroot -w /var/www/api/public
done
